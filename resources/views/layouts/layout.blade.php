<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

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
    <div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="product.html"><img src="{{ asset('assets/front/img/1.jpg') }}"
                                            alt="CORT AD810M Акустическая гитара"></a></td>
                                <td><a href="product.html">CORT AD810M Акустическая гитара</a></td>
                                <td>2 799</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td><a href="product.html"><img src="{{ asset('assets/front/img/2.jpg') }}"
                                            alt="Crafter D6/N Акустическая гитара"></a></td>
                                <td><a href="product.html">Crafter D6/N Акустическая гитара</a></td>
                                <td>12 626</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Товаров: 3 <br> Сумма: 28 051 руб.</td>
                            </tr>
                        </tbody>
                    </table>
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
