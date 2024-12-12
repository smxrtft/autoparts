@extends('layouts.layout')
@section('title')
    @parent {{ $product->title }}
@endsection
@section('content')
    {{-- <div class="col-sm-3">
        <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-thumbnail">
    </div>
    <div class="col-sm-9">
        <ul class="list-unstyled">
            <h1 class="mb-3">{{ $product->title }}</h1>
            <li class="mb-3">Категория: <a href="{{ route('categories.show', ['slug' => $product->category->slug]) }}">{{ $product->category->title }}</a></li>
            <li class="mb-3">Наличие: <i class="{{ $product->status->icon }}"></i>{{ $product->status->title }}</li>
            <li class="mb-3">Цена: <span class="card-price text-center">
                @if ($product->old_price)
                <del><small>{{ $product->old_price }} руб.</small></del>
               <span class="hit-price">{{ $product->price }} руб.</span> 
               @else
               {{ $product->price }} руб.
               @endif
                </span></li>
        </ul>
        <form action="{{ route('cart.add') }}" method="post" class="addtocart">
            @csrf
            <div class="form-row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control qty-addtocart" name="qty" value="1">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info btn-block card-addtocart">
                                <i class="fas fa-cart-arrow-down"></i> Купить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="product-desc w-100">
        <hr>
        {{ $product->content }}
    </div> --}}

    <div class="container">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('categories.show', ['slug' => $product->category->slug]) }}">{{ $product->category->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
            </ol>
        </nav>

        <div class="row" style="margin-bottom: 100px">

            <!-- Product Images -->
            <div class="col-md-6">
                <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-thumbnail">
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h2>{{ $product->title }}</h2>
                <h4 class="text-muted">Цена: <span class="card-price text-center">
                        @if ($product->old_price)
                            <del><small class="product-showsmallprice">{{ $product->old_price }} руб.</small></del>
                            <span class="hit-price product-showprice">{{ $product->price }} руб.</span>
                        @else
                            {{ $product->price }} руб.
                        @endif
                    </span></h4>
                <p>Категория: <a
                        href="{{ route('categories.show', ['slug' => $product->category->slug]) }}">{{ $product->category->title }}</a>
                </p>
                <p>Наличие: <i class="{{ $product->status->icon }}"></i>{{ $product->status->title }}</p>
                <form action="{{ route('cart.add') }}" method="post" class="addtocart mb-3">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" required min="1" class="form-control qty-addtocart"
                                    name="qty" value="1">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-block card-addtocart">
                                        <i class="fas fa-cart-arrow-down"></i> Купить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <p class="lead">{{ $product->content }}</p>
            </div>
        </div>
    @endsection
