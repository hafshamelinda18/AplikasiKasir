<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // Pastikan mengimpor model User
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\KasirMail;
use Illuminate\Support\Str;

class AuthentificationController extends Controller
{
    // Menampilkan form login
    public function showFormLogin()
    {
        return view('Authenfication.login');
    }

    // Proses login
    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
        $this->validate($request, $rules);
    
        // Mencari user berdasarkan email
        $user = User::where('email', $request->input('email'))->first();
    
        // Memeriksa apakah user ditemukan dan password sesuai
        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Login user
            Auth::login($user);
    
            // Redirect ke halaman home dengan pesan sukses
            return redirect()->route('home')->with('success', 'Anda Berhasil Masuk');
        } else {
            // Jika login gagal, kembali ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Email atau Password Anda Salah');
        }
    }

    // Menampilkan form register
    public function showFormRegister()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang bisa mendaftarkan kasir.');
        }
        return view('Authenfication.register');
    }

    // Proses register
    public function postRegister(Request $request)
    {

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang bisa mendaftarkan kasir.');
        }
    
        // Validasi input
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];

        $this->validate($request, $rules);

        $passwordPlain = $request->password;

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($passwordPlain),
        ]);
        // Menyiapkan data yang ingin dikirimkan
    $data = [
        'name' => $user->name,
        'email' => $user->email,
        'password' => $passwordPlain,
    ];

    // Kirim email pemberitahuan ke kasir
    Mail::to($user->email)->send(new KasirMail($data));


        // Redirect ke halaman home setelah berhasil registrasi
        return redirect()->route('home')->with('success', 'Akun Kasir Berhasil Didaftarkan!');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    public function index(Request $request)
    {
        
        $search = $request->input('search'); 
        $query =User::query();
        $query->where('role', 'kasir');

        if ($search) { 
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        $query->orderBy('id', 'desc');
        $users = $query->paginate(10);
        
        return view('user.index', [
        'users' => $users, 
        'search' => $search
        ]);
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->role !== 'kasir') {
        return redirect()->route('user.index')->with('error', 'Hanya user dengan role kasir yang bisa dihapus.');
    }

    $user->delete();

    return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
}

}
