@extends('layouts.template')


@section('content')

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah User
    </a>
    <div class="card py-2 px-2">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Daftar User</h5>
            </div>
        </div>
        <div class="text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Hak Akses</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($data as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td><i class="fa-lg text-danger"></i><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <span class="badge bg-label-primary me-1">{{ $v }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('users.show',$user->id) }}">
                                        <i class="bx bx-show me-1"></i> Lihat
                                    </a>
                                    <a class="dropdown-item" href="{{ route('users.edit',$user->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
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
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        $('#search').on('keyup', function(){
            search();
        });
        search();
        function search(){
            var keyword = $('#search').val();
            $.post('{{ route("users.search") }}',
                {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    keyword:keyword
                },
                function(data){
                    table_post_row(data);
                    console.log(data);
                });
        }
        // table row with ajax
        function table_post_row(res){
            let htmlView = '';
            if(res.employees.length <= 0){
                htmlView+= `
       <tr>
          <td colspan="4">No data.</td>
      </tr>`;
            }
            for(let i = 0; i < res.employees.length; i++){
                htmlView += `
        <tr>
           <td>`+ (i+1) +`</td>
              <td>`+res.employees[i].name+`</td>
               <td>`+res.employees[i].phone+`</td>
        </tr>`;
            }
            $('tbody').html(htmlView);
        }
    </script>
@endsection
