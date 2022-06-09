@extends('layouts.app')

@section('style')
    <style>
        .custom-card:hover{
            transform: translateY(100px);
        }
    </style>
@endsection

@section('content')
    @foreach($categories as $category)
        <h4 class="pb-1 mb-4 text-muted">{{ $category->name }}</h4>
        <div class="row" data-masonry='{"percentPosition": true }'>
            @foreach($category->menus as $menu)
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="" class="text-black custom-card">
                        <div class="card p-3">
                            <img class="card-img-top" src="{{asset('vendor/assets/img/elements/5.jpg')}}" alt="Card image cap" />
                            <figure class="p-3 mb-0">
                                <blockquote class="blockquote">
                                    <h4 class="fw-bold">{{ $menu->name }}</h4>
                                    <p class="fs-5"> Rp. {{ number_format($menu->price) }}</p>
                                </blockquote>
                                <figcaption class="blockquote-footer mb-0 text-warning">
                                    {{ substr($menu->description, 0, 200) }}
                                </figcaption>
                            </figure>
                        </div>
                    </a>
                </div>
{{--                <div class="col-sm-12  col-lg-3 col-md-6 mb-4">--}}
{{--                    <a href="" class="text-black custom-card">--}}
{{--                        <div class="card">--}}
{{--                            <img class="card-img-top" src="{{ $menu->imageUrl }}" alt="Card image cap" />--}}
{{--                            <div class="card-body">--}}
{{--                                <h5 class="card-title fw-bold">{{ $menu->name }}</h5>--}}
{{--                                <h5 class="fw-normal">Rp. {{ number_format($menu->price) }}</h5>--}}
{{--                                <p class="card-text">{{ substr($menu->description, 0,200)  }} ..</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
            @endforeach
        </div>
    @endforeach


@endsection
