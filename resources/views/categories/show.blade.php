@extends('layouts.layout')

@section('title')
    @parent {{ $category->title }}
@endsection

@section('content')
<div class="container my-5">
    <!-- Toast Notification -->
    <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index: 999">
        <i class="fa fa-plus" aria-hidden="true"></i> Товар был добавлен в корзину
    </div>
    <div class="row">
        <!-- Боковая панель с фильтрами -->
        <div class="col-md-3">
            <div class="card filter-card mb-4">
                <div class="card-header bg-dark border-0">
                    <h5 class="section-title mb-0">Фильтры</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Фильтр по категориям -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-muted mb-3">Категории</h6>
                        <div class="list-group list-group-flush">
                            @foreach($categories as $cat)
                                <a href="{{ route('categories.show', ['slug' => $cat->slug]) }}"
                                   class="list-group-item list-group-item-action border-0 rounded {{ $category->id == $cat->id ? 'active bg-primary text-white' : 'text-light' }} category-link">
                                    {{ $cat->title }}
                                    @if($category->id == $cat->id)
                                        <i class="fas fa-arrow-right float-right mt-1"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                   <!-- Price Filter -->
                   <div class="mb-4">
                    <h6 class="text-f1faee">Цена</h6>
                    <form id="price-filter" class="reset-form">
                        <div class="form-row">
                            <div class="col">
                                <input type="number" name="min_price" class="form-control filter-input" 
                                       placeholder="От" value="{{ request('min_price') }}" min="0">
                            </div>
                            <div class="col">
                                <input type="number" name="max_price" class="form-control filter-input" 
                                       placeholder="До" value="{{ request('max_price') }}" min="0">
                            </div>
                        </div>
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <button type="submit" class="btn btn-primary w-100 mt-2">
                            <i class="fas fa-filter"></i> Применить
                        </button>
                    </form>
                </div>
                </div>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="col-md-9">
            <div class="card mb-4 category-header">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-light">{{ $category->title }}</h5>
                        <form action="{{ route('categories.show', ['slug' => $category->slug]) }}" method="GET" class="form-inline">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <label class="border-0 text-muted pr-1" for="sort">
                                        <small>Сортировка:</small>
                                    </label>
                                </div>
                                <select name="sort" id="sort" class="form-control sort-select" onchange="this.form.submit()">
                                    <option value="">По умолчанию</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена (↑)</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена (↓)</option>
                                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Название (А-Я)</option>
                                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Название (Я-А)</option>
                                </select>
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-cards product-cards-category">
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
                            <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="product-img">
                        </a>
                    </div>
                    <div class="card-caption">
                        <div class="card-title">
                            <a href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                        </div>
                        <div class="card-price mb-3">
                            @if ($product->old_price)
                                <del><small>{{ $product->old_price }} руб.</small></del>
                                <span class="hit-price">{{ $product->price }} руб.</span>
                            @else
                                {{ $product->price }} руб.
                            @endif
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="addtocart">
                            @csrf
                            <div class="input-group">
                                <input type="number" required min="1" name="qty" class="form-control qty-addtocart" value="1">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn card-addtocart" id="liveToastBtn">
                                        <i class="fas fa-cart-arrow-down"></i> В корзину
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="item-status"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            @if (count($products))
                <div class="mt-4">
                    <nav aria-label="Page navigation">
                        {{ $products->appends([
                            'sort' => request('sort'),
                            'min_price' => request('min_price'),
                            'max_price' => request('max_price'),
                            'statuses' => request('statuses')
                        ])->links('pagination::bootstrap-4') }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Обработка формы фильтра по цене
            $('#price-filter').on('submit', function(e) {
                e.preventDefault();
                const url = new URL(window.location.href);
                url.searchParams.set('min_price', $('input[name="min_price"]').val() || '');
                url.searchParams.set('max_price', $('input[name="max_price"]').val() || '');
                window.location.href = url.toString();
            });

            // Обработка чекбоксов статусов
            $('.status-filter').on('change', function() {
                const url = new URL(window.location.href);
                const statuses = [];
                $('.status-filter:checked').each(function() {
                    statuses.push($(this).val());
                });
                if (statuses.length > 0) {
                    url.searchParams.set('statuses', statuses.join(','));
                } else {
                    url.searchParams.delete('statuses');
                }
                window.location.href = url.toString();
            });
        });

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
