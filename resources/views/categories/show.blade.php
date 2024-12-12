{{-- @extends('layouts.layout')
@section('title')@parent {{ $category->title }}
@endsection
@section('content')
<div class="product-cards mb-5">
    <div class="col-md-12">
        <div class="row">
        @forelse ($products as $product)
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
                <div class="item-status"><i class="fas fa-check text-success"></i> {{ $product->status->title }}
                </div>
            </div>
        </div><!-- /product-card -->
            @empty
            <p>В этой категории пусто...</p>
        @endforelse
    </div>
    </div>
</div><!-- /product-cards -- -->
    @if (count($products))
    <div class="col-md-12">
        <nav aria-label="Page navigation example">
            {{ $products->links() }}
        </nav>
    </div>
    @endif
@endsection --}}

@extends('layouts.layout')
@section('title')
    @parent {{ $category->title }}
@endsection
@section('content')
    <div class="product-cards mb-5">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <form action="{{ route('categories.show', ['slug' => $category->slug]) }}" method="GET"
                        class="form-inline">
                        <label for="sort" class="mr-2">Сортировать по:</label>
                        <select name="sort" id="sort" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="">Выберите сортировку</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цене (по
                                возрастанию)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цене (по
                                убыванию)</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Названию (А-Я)
                            </option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Названию
                                (Я-А)</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="row">
                @forelse ($products as $product)
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
                                <a
                                    href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" class="addtocart">
                                @csrf
                                <div class="input-group">
                                    <input type="number" min="1" name="qty" class="form-control qty-addtocart"
                                        value="1" id="">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-block card-addtocart"
                                            id="liveToastBtn">
                                            <i class="fas fa-cart-arrow-down"></i> В корзину
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="item-status"><i class="{{ $product->status->icon }}"></i>
                                {{ $product->status->title }}
                            </div>
                        </div>
                    </div><!-- /product-card -->
                @empty
                    <p>В этой категории пусто...</p>
                @endforelse
            </div>
        </div>
    </div><!-- /product-cards -->
    @if (count($products))
        <div class="col-md-12">
            <nav aria-label="Page navigation example">
                {{ $products->links() }}
            </nav>
        </div>
    @endif
@endsection
