<div class="card py-2 px-2">
    <div class="row">
        <div class="col-md-6">
            <h5 class="card-header">Daftar Meja</h5>
        </div>
    </div>
    <div class="text-nowrap">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nomer Meja</th>
                <th>Nama</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($tables as $table)
                <tr>
                    <td>#</td>
                    <td><i class="fa-lg text-danger"></i><strong>{{ $table->number }}</strong></td>
                    <td><i class="fa-lg text-danger"></i><strong>{{ $table->name }}</strong></td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('tables.edit',$table->id) }}">
                            <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                        {!! Form::open(['method' => 'DELETE','route' => ['tables.destroy', $table->id],'style'=>'display:inline']) !!}
                        <button class="btn btn-sm btn-danger">
                            <i class="bx bx-trash me-1"></i> Hapus
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
