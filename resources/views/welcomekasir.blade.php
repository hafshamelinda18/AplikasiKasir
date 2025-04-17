<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pendaftaran Kasir</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: rgb(206, 61, 17);
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            color: #666666;
            line-height: 1.6;
            margin: 10px 0;
        }
        .email-body table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .email-body th,
        .email-body td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }
        .email-body th {
            width: 30%;
        }
        .email-body a {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(212, 54, 54);
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .email-body a:hover {
            background-color: rgb(190, 35, 15);
        }
        .email-footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
        .email-footer p {
            margin: 0;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Selamat datang, {{ $data['name'] }}!</h2>
        </div>
        <div class="email-body">
            <p>Anda telah berhasil didaftarkan sebagai kasir di toko kami. Berikut adalah informasi login Anda:</p>
            
            <table>
                <tr>
                    <th>Email:</th>
                    <td>{{ $data['email'] }}</td>
                </tr>
                <tr>
                    <th>Password:</th>
                    <td>{{ $data['password'] }}</td>
                </tr>
            </table>

            <p>Silakan login menggunakan email dan password di atas.</p>
            <p>Terima kasih telah bergabung!</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Toko Kami. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
