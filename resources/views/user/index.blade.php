
@extends('template.style')

@section('content')


<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
<h2 class="text-center mb-4">Data Akun Kasir</h2>


            <!-- Form Pencarian -->
            <form action="{{ route('user.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Akun..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>



<p>
<div class="card">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table text-center align-middle mb-0">
                        <thead class="thead-dark">
    <tr>
        <th>No</th>
        <th> Nama Kasir </th>
        <th> Email </th>
    
       
</tr>
</thead>
<tbody>
    @foreach($users as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td> {{$item->name}}</td>
        <td> {{$item->email}}</td>
    
</tr>
@endforeach
</tbody>
</table>
</div>
{{ $users->links() }}

@endsection