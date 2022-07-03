@extends('layouts.template')

@section('content')
    <div class="row mb-3">
        <div class="col-md-5">
            {!! Form::open(array('route' => 'employees.index','method'=>'GET')) !!}
            <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>

                {!! Form::text('key', $_GET['key'] ?? '', array('placeholder' => 'Search...','class' => 'form-control')) !!}

                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Pengguna
    </a>
    <div class="card py-2 px-2">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header d-flex align-items-center">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    Daftar Pengguna</h5>
            </div>
        </div>
        <div class="text-nowrap table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Nomer Telpon</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Sebagai</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($employees as $key => $value)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td><i class="fa-lg text-danger"></i><strong>{{ $value->name }}</strong></td>

                        <td>{{ $value->telp }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->user->email }}</td>
                        <td>
                            @if(!empty($value->user->getRoleNames()))
                                @foreach($value->user->getRoleNames() as $v)
                                    <span class="badge bg-label-primary me-1">{{ $v }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('employees.edit',$value->id) }}">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            {!! Form::open(['method' => 'DELETE','route' => ['employees.destroy', $value->id],'style'=>'display:inline']) !!}
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ?')">
                                <i class="bx bx-trash me-1"></i> Hapus
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $employees->links() !!}
        </div>
    </div>

@endsection
