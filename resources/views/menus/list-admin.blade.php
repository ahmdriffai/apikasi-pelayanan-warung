<a href="{{ route('menus.create') }}" class="btn btn-primary mb-3">
    <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Menu
</a>
<div class="card py-2 px-2">
    <div class="row">
        <div class="col-md-6">
            <h5 class="card-header">Daftar User</h5>
        </div>
    </div>
    <div class="text-nowrap table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Keterangan</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($data as $key => $value)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td><i class="fa-lg text-danger"></i><strong>{{ $value->name }}</strong></td>
                    <td>
                        <img src="{{ $value->image_url }}" class="img-fluid rounded-1" width="100px" height="100px">
                    </td>
                    <td>{!! substr($value->description, 0, 100) !!} ...</td>
                    <td><strong>Rp. {{ number_format($value->price) }}</strong></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('menus.show',$value->id) }}">
                                    <i class="bx bx-show me-1"></i> Lihat
                                </a>
                                <a class="dropdown-item" href="{{ route('menus.edit',$value->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => ['menus.destroy', $value->id],'style'=>'display:inline']) !!}
                                <button class="dropdown-item">
                                    <i class="bx bx-trash me-1"></i> Hapus
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $data->links() !!}
    </div>
</div>
