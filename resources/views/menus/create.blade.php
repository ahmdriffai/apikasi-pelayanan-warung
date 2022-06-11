@extends('layouts.template')


@section('content')
    <a href="{{ route('menus.index') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
    </a>
    <!-- Basic Layout -->
    {!! Form::open(array('route' => 'menus.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Nama Menu <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::text('name', null, array('placeholder' => 'ex. Nasi Goreng','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Harga <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp.</span>
                                {!! Form::number('price', null, array('placeholder' => '10.000','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Kategori <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::select('category_id', $categories,[], array('class' => 'form-control', 'placeholder' => 'Categori Makanan')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Gambar <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::file('image', array('placeholder' => '10.000','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Keterangan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'body', 'width' => '100%')) !!}
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


