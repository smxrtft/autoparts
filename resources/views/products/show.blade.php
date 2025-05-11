@extends('layouts.layout')

@section('title')
    @parent {{ $product->title }}
@endsection

@section('content')
<div class="container py-4">
    <!-- Toast Notification -->
    <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index: 999">
        <i class="fa fa-plus" aria-hidden="true"></i> Товар был добавлен в корзину
    </div>

    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb p-3 rounded" style="background-color: #252525; color: #e0e0e0;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-a8dadc"><i class="fas fa-home"></i> Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.show', ['slug' => $product->category->slug]) }}" class="text-decoration-none text-a8dadc">{{ $product->category->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row mb-5">
        <!-- Изображение товара -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100 product-gallery-card">
                <div class="card-body p-4">
                    <div class="product-gallery text-center">
                        <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-fluid rounded product-main-img">
                    </div>
                </div>
            </div>
        </div>

        <!-- Информация о товаре -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 product-info-card">
                <div class="card-body p-4">
                    <!-- Заголовок и метки -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="h3 mb-0 font-weight-bold text-f1faee">{{ $product->title }}</h1>
                        <div class="offer">
                            @if ($product->hit)
                                <div class="offer-hit">Hit</div>
                            @endif
                            @if ($product->sale)
                                <div class="offer-sale">Sale</div>
                            @endif
                        </div>
                    </div>

                    <!-- Цена -->
                    <div class="mb-4 product-showprice">
                        @if ($product->old_price)
                            <small class="text-muted"><del>{{ number_format($product->old_price, 0, ',', ' ') }} руб.</del></small>
                            <h2 class="text-a8dadc mb-0">{{ number_format($product->price, 0, ',', ' ') }} руб.</h2>
                        @else
                            <h2 class="text-a8dadc mb-0">{{ number_format($product->price, 0, ',', ' ') }} руб.</h2>
                        @endif
                    </div>

                    <!-- Статус и категория -->
                    <div class="mb-4">
                        <p class="mb-2">
                            <span class="font-weight-bold">Категория:</span>
                            <a href="{{ route('categories.show', ['slug' => $product->category->slug]) }}" class="text-decoration-none text-a8dadc">
                                {{ $product->category->title }}
                            </a>
                        </p>
                        <p class="mb-0">
                            <span class="font-weight-bold">Наличие:</span>
                            <span class="badge-show">
                                <i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}
                            </span>
                        </p>
                    </div>

                    <!-- Форма покупки -->
                    <form action="{{ route('cart.add') }}" method="POST" class="addtocart mb-4">
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="number" required min="1" class="form-control qty-addtocart" name="qty" value="1">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn card-addtocart">
                                            <i class="fas fa-cart-arrow-down"></i> В корзину
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Краткое описание -->
                    <div class="product-short-description">
                        <h5 class="font-weight-bold text-f1faee">Описание</h5>
                        <p class="text-adb5bd">{{ $product->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Show toast when adding to cart
            $('.addtocart').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#liveToast').fadeIn().delay(3000).fadeOut();
                        // Note: Cart modal not opened here as it's not included on this page
                    },
                    error: function(xhr) {
                        console.error('Error adding to cart:', xhr.responseText);
                        alert('Не удалось добавить товар в корзину. Пожалуйста, попробуйте снова.');
                    }
                });
            });
        });
    </script>
@endsection