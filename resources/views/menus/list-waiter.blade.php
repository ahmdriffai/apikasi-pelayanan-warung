@include('components.cart-menu')

@foreach($categories as $category)
    <div class="row mb-4">
        <div class="col-md-5">
            <form method="get" action="">
                <div class="input-group input-group-merge">
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
    </div>
    @if(!isset($_GET['key']))
        <h4 class="pb-1 mb-4 text-muted">{{ $category->name }}</h4>
    @endif
    <div class="row mb-5">
        @if(!isset($_GET['key']))
            @php($data = $category->menus)
        @endif
        @foreach($data as $menu)
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img class="card-img card-img-left" src="{{asset($menu->image_url)}}" alt="Card image"/>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->name }}</h5>
                            <h5 class="card-title">Rp. {{ number_format($menu->price) }}</h5>
                            {!! Form::open(array('route' => 'menu-carts.store','method'=>'POST')) !!}

                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <div class="row mb-2">
                                <label class="col-sm-4 col-form-label">Jumlah pesan</label>
                                <div class="col-sm-5">
                                    {!! Form::number('quantity', 1, ['class' => ['form-control'], 'min' => 1, 'placeholder' => 'jumlah pesan']) !!}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mb-3">
                                <span class="tf-icons bx bx-cart"></span>&nbsp; Tambah Keranjang
                            </button>
                            <a href="{{ route('menus.create') }}" class="btn btn-info mb-3">
                                <span class="tf-icons bx bx-show"></span>&nbsp; Detail
                            </a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endforeach


