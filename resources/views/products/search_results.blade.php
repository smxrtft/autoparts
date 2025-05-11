@extends('layouts.layout')

@section('title')
    @parent Результаты поиска: "{{ $query }}"
@endsection

@section('content')
<div class="container py-4">
    <!-- Toast Notification -->
    <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index: 999">
        <i class="fa fa-check" aria-hidden="true"></i> Товар добавлен в корзину
    </div>

    <div class="row">
        <!-- Filter Sidebar -->
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
                                   class="list-group-item list-group-item-action border-0 rounded text-white text-light category-link">
                                    {{ $cat->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h1 class="section-title mb-4">Результаты поиска: "{{ $query }}"</h1>

            <!-- Search and Sort Form -->
            <form id="search-sort-form" action="{{ route('products.search') }}" method="GET" class="mb-4">
                <div class="row align-items-end justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control search-input input-search" 
                                   value="{{ $query }}" placeholder="Поиск...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Поиск
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @foreach((array)request('statuses') as $status_id)
                    <input type="hidden" name="statuses[]" value="{{ $status_id }}">
                @endforeach
            </form>

            <!-- Product Cards -->
            <div class="product-cards mb-5">
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
                                <img src="{{ $product->getImage() }}" alt="{{ $product->title }}">
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
                                    <input type="number" min="1" name="qty" class="form-control qty-addtocart" value="1">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn card-addtocart">
                                            <i class="fas fa-cart-arrow-down"></i> В корзину
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="item-status"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle mr-2"></i> По запросу "{{ $query }}" ничего не найдено. Попробуйте изменить параметры поиска.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if (count($products))
                <nav aria-label="Page navigation example">
                    {{ $products->appends([
                        'query' => $query,
                        'sort' => request('sort'),
                        'min_price' => request('min_price'),
                        'max_price' => request('max_price'),
                        'statuses' => request('statuses')
                    ])->links() }}
                </nav>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Price Filter Form
    $('#price-filter').on('submit', function(e) {
        e.preventDefault();
        const minPrice = $('input[name="min_price"]').val();
        const maxPrice = $('input[name="max_price"]').val();

        // Client-side validation
        if (minPrice && minPrice < 0) {
            alert('Минимальная цена не может быть отрицательной');
            return;
        }
        if (maxPrice && maxPrice < 0) {
            alert('Максимальная цена не может быть отрицательной');
            return;
        }
        if (minPrice && maxPrice && parseFloat(minPrice) > parseFloat(maxPrice)) {
            alert('Минимальная цена не может быть больше максимальной');
            return;
        }

        const url = new URL("{{ route('products.search') }}");
        url.searchParams.set('query', '{{ $query }}');
        url.searchParams.set('min_price', minPrice || '');
        url.searchParams.set('max_price', maxPrice || '');
        url.searchParams.set('sort', '{{ request('sort') }}');
        const statuses = $('input[name="statuses[]"]').map(function() { return $(this).val(); }).get();
        if (statuses.length) {
            url.searchParams.set('statuses', statuses.join(','));
        }

        window.location.href = url.toString();
    });

    // Search and Sort Form (AJAX)
    $('#search-sort-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'GET',
            data: form.serialize(),
            success: function(response) {
                // Update product cards dynamically
                $('.product-cards').html($(response).find('.product-cards').html());
                // Update pagination
                $('nav[aria-label="Page navigation example"]').html($(response).find('nav[aria-label="Page navigation example"]').html());
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                $('.product-cards').before('<div class="alert alert-danger mb-4"><i class="fas fa-exclamation-circle mr-2"></i>Ошибка при загрузке результатов поиска</div>');
            }
        });
    });

    // Add to Cart Form
    $('.addtocart').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#liveToast').fadeIn().delay(3000).fadeOut();
                // Optionally update cart modal content
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                form.before('<div class="alert alert-danger mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Ошибка при добавлении в корзину</div>');
            }
        });
    });
});
</script>
@endsection