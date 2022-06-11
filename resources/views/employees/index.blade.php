@extends('layouts.template')

@section('content')
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Karyawan
    </a>
    <div class="card py-2 px-2">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header d-flex align-items-center">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    Daftar Karyawan</h5>
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
                            <a class="btn btn-sm btn-info" href="{{ route('employees.show',$value->id) }}">
                                <i class="bx bx-show-alt me-1"></i> Lihat
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('employees.edit',$value->id) }}">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            {!! Form::open(['method' => 'DELETE','route' => ['employees.destroy', $value->id],'style'=>'display:inline']) !!}
                            <button class="btn btn-sm btn-danger">
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
