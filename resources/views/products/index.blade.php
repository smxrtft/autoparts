@extends('layouts.layout')

@section('title')
    @parent {{ $title }}
@endsection
@section('content')
<div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index:999">
    <i class="fa fa-plus" aria-hidden="true"></i> Товар был добавлен в корзину
</div>
{{-- <div class="toast-container position-fixed bottom-0 end-0 p-3"  id="liveToast">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div> --}}


{{-- Баннер --}}
@section('admin-page')
<div class="jumbotron text-center bg-light mt-3">
    <img src="{{ asset("storage/img/logo.webp") }}" width="200px" style="border-radius: 50%" alt="">
    <h1 class="display-4">Добро пожаловать в AutoParts!</h1>
    <p class="lead mb-3">Качественные автозапчасти для вашего автомобиля по лучшим ценам.</p>
</div>
@endsection

{{-- Категории --}}
<div class="container">
    <h2 class="text-center my-4">Популярные категории</h2>
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="{{ asset("storage/img/salon-home.jpg") }}" class="card-img-top" alt="Салон">
                <div class="card-body">
                    <h5 class="card-title">Салон</h5>
                    <a href="{{ route('categories.show', ['slug' => 'salon']) }}" class="btn btn-primary">Смотреть</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="{{ asset("storage/img/dvigatel-home.jpg") }}" class="card-img-top" alt="Двигатель">
                <div class="card-body">
                    <h5 class="card-title">Двигатель</h5>
                    <a href="{{ route('categories.show', ['slug' => 'dvigatel']) }}" class="btn btn-primary">Смотреть</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="{{ asset("storage/img/optika-home.jpg") }}" class="card-img-top" alt="Оптика">
                <div class="card-body">
                    <h5 class="card-title">Оптика</h5>
                    <a href="{{ route('categories.show', ['slug' => 'optika']) }}" class="btn btn-primary">Смотреть</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="{{ asset("storage/img/kuzovnye-detali-home.jpg") }}" class="card-img-top" alt="Кузовные детали">
                <div class="card-body">
                    <h5 class="card-title">Кузовные детали</h5>
                    <a href="{{ route('categories.show', ['slug' => 'kuzovnye-detali']) }}" class="btn btn-primary">Смотреть</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Популярные товары --}}
<div class="container my-5 mb-5">
    <h2 class="text-center my-4">Популярные товары</h2>
    <div class="row">
        @foreach ($products as $product)  
                <div class="product-card">
                    <div class="offer">
                        @if ($product->hit)
                            <div class="offer-hit">Hit</div>
                        @endif
                        @if ($product->sale)
                            <div class="offer-sale">Sale</div>
                        @endif
                    </div>
                    <div class="card-thumb">
                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                            <img src="{{ $product->getImage() }}" alt="">
                        </a>
                    </div>
                    <div class="card-caption">
                        <div class="card-price mb-3">
                            @if ($product->old_price)
                                <del><small>{{ $product->old_price }} руб.</small></del>
                               <span class="hit-price">{{ $product->price }} руб.</span> 
                               @else
                               {{ $product->price }} руб.
                               @endif
                        </div>
                        <div class="card-title">
                            <a href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="addtocart">
                            @csrf
                            <div class="input-group">
                                <input type="number" required min="1" name="qty" class="form-control qty-addtocart" value="1"
                                    id="">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn card-addtocart" id="liveToastBtn">
                                        <i class="fas fa-cart-arrow-down"></i> В корзину
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="item-status"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}
                        </div>
                    </div>
                </div><!-- /product-card -->
            @endforeach
    </div>
</div>

    {{-- <div class="product-cards mb-5">
        <div class="col-md-12">
            @foreach ($products as $product)
                <div class="product-card">
                    <div class="offer">
                        @if ($product->hit)
                            <div class="offer-hit">Hit</div>
                        @endif
                        @if ($product->sale)
                            <div class="offer-sale">Sale</div>
                        @endif
                    </div>
                    <div class="card-thumb">
                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                            <img src="{{ $product->getImage() }}" alt="">
                        </a>
                    </div>
                    <div class="card-caption">
                        <div class="card-price mb-3">
                            @if ($product->old_price)
                                <del><small>{{ $product->old_price }} руб.</small></del>
                               <span class="hit-price">{{ $product->price }} руб.</span> 
                               @else
                               {{ $product->price }} руб.
                               @endif
                        </div>
                        <div class="card-title">
                            <a href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="addtocart">
                            @csrf
                            <div class="input-group">
                                <input type="number" min="1" name="qty" class="form-control qty-addtocart" value="1"
                                    id="">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-block card-addtocart" id="liveToastBtn">
                                        <i class="fas fa-cart-arrow-down"></i> В корзину
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="item-status"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}
                        </div>
                    </div>
                </div><!-- /product-card -->
            @endforeach
        </div>
    </div><!-- /product-cards --> --}}
    
@endsection
