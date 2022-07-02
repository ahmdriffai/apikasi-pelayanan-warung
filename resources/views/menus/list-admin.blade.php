<a href="{{ route('menus.create') }}" class="btn btn-primary mb-3">
    <span class="tf-icons bx bx-add-to-queue"></span>&nbsp; Tambah Menu
</a>
<div class="card">
    <div class="d-flex align-items-center flex-row justify-content-around">
        <h5 class="card-header flex-grow-1">List Pengabdian</h5>
        <form method="get" action="">
            <div class="input-group input-group-merge px-5">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                <input type="hidden" value="100" name="size">
                <input
                    type="text"
                    name="key"
                    class="form-control"
                    placeholder="Search..."
                    aria-label="Search..."
                    aria-describedby="basic-addon-search31"
                    value="{{ $_GET['key'] ?? '' }}"
                />
            </div>
        </form>
    </div>

    <div class="text-nowrap table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Gambar</th>
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
                    <td><strong>Rp. {{ number_format($value->price) }}</strong></td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('menus.show',$value->id) }}">
                            <i class="bx bx-show-alt me-1"></i> Lihat
                        </a>
                        <a class="btn btn-sm btn-primary" href="{{ route('menus.edit',$value->id) }}">
                            <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                        {!! Form::open(['method' => 'DELETE','route' => ['menus.destroy', $value->id],'style'=>'display:inline']) !!}
                        <button class="btn btn-sm btn-danger">
                            <i class="bx bx-trash me-1"></i> Hapus
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $data->links() !!}
    </div>
</div>
