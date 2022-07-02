@extends('layouts.template')


@section('content')
    <a href="{{ route('menus.index') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
    </a>
    <!-- Basic Layout -->
    {!! Form::open(array('route' => ['menus.update', $menu->id],'method'=>'POST', 'files' => true)) !!}
    @method('PUT')
    <div class="row">
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Nama Menu <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::text('name', $menu->name , array('placeholder' => 'ex. Nasi Goreng','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Harga <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp.</span>
                                {!! Form::number('price', $menu->price, array('placeholder' => '10.000','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Kategori <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::select('category_id', $categories,$menu->category_id, array('class' => 'form-control', 'placeholder' => 'Categori Makanan')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Gambar <span class="text-danger">*</span></label>
                            <br>
                            <img src="{{ $menu->image_url }}" class="img-fluid mb-2" width="200px">
                            <div class="input-group input-group-merge">
                                {!! Form::file('image', array('placeholder' => '10.000','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Keterangan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::textarea('description', $menu->description, array('class' => 'form-control', 'id' => 'body', 'width' => '100%')) !!}
                            </div>
                            <div class="form-text">* keterangan makanan misal : bahan, bentuk, dll</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {!! Form::close() !!}


@endsection

@section('style')
    {{-- CKEditor CDN --}}
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>

    <script>
        var konten = document.getElementById("body");
        CKEDITOR.replace(konten,{
            language:'en-gb'
        });
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.width = '100%';
    </script>
@endsection


