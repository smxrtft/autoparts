<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('storage/img/favicon/favicon.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('storage/img/favicon/favicon-16x16.png') }}" sizes="16x16">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/img/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('storage/img/favicon/site.webmanifest') }}">
    <!-- Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">
    <title>@yield('title', 'Laravel Shop')</title>
    {{-- @vite(['resources/js/app.js']) --}}
</head>

<body>
    @include('layouts.navbar')
    
    <div class="col-6 m-auto">

        @if ($errors->any())
            <div class="alert alert-danger position-fixed w-25" role="alert" id="liveToast"
                style="right: 1%; bottom: 1%; z-index:999">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="list-style: none"><i class="fas fa-exclamation"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast"
                style="right: 1%; bottom: 1%; z-index:999">
                <i class="fas fa-check"></i> {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="wrapper mt-5">
        @yield('admin-page')
        <div class="container">
            <div class="row">
                @yield('content')

            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /wrapper -->

    <!-- Modal -->
    <div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: #2a2a2a; color: #e0e0e0;">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Корзина</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: #e0e0e0;">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (!empty(session('cart')))
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Фото</th>
                                        <th scope="col">Наименование</th>
                                        <th scope="col">Цена</th>
                                        <th scope="col">Кол-во</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('cart') as $item)
                                        <tr>
                                            <td class="p-3">
                                                <a href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                                    <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}"
                                                        class="img-fluid w-100 h-100 object-fit-cover">
                                                </a>
                                            </td>
                                            <td class="p-3"><a
                                                    href="{{ route('products.show', ['slug' => $item['slug']]) }}">{{ $item['title'] }}</a>
                                            </td>
                                            <td class="p-3">@price_format($item['price']) руб.</td>
                                            <td class="p-3">{{ $item['qty'] }}</td>
                                            <td class="p-3">
                                                <button type="button" class="btn btn-danger del-item"
                                                    data-action="{{ route('cart.del_item', ['product_id' => $item['product_id']]) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" align="right">
                                            Товаров: <span id="modal-cart-qty">{{ session('cart_qty') }}</span> шт.<br>
                                            Сумма: <span id="modal-cart-total">@price_format(session('cart_total')) руб.</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h4>Корзина пуста</h4>
                            <p>Добавьте товары, чтобы начать оформление заказа.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="button" onclick="clearCart('{{ route('cart.clear') }}')"
                            class="btn btn-danger">Очистить корзину</button>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Оформить заказ</a>
                </div>
            </div>
        </div>
    </div>


    @include('layouts.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
</body>

</html>
