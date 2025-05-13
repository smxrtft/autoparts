@extends('layouts.layout')

@section('title')
    @parent Оформление заказа
@endsection

@section('content')
<div class="container py-4">
    <!-- Toast Notification -->
    <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index: 999">
        <i class="fa fa-plus" aria-hidden="true"></i> Товар удален из корзины
    </div>

    <h1 class="text-f1faee mb-4">Оформление заказа</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(!empty(session('cart')))
        <div class="card border-0 shadow-sm mb-4 cart-table-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Фото</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Кол-во</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('cart') as $item)
                                <tr>
                                    <td class="p-3">
                                        <a href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                            <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" class="img-fluid w-100 h-100 object-fit-cover">
                                        </a>
                                    </td>
                                    <td class="p-3"><a href="{{ route('products.show', ['slug' => $item['slug']]) }}" class="text-a8dadc">{{ $item['title'] }}</a></td>
                                    <td class="p-3">@price_format($item['price']) руб.</td>
                                    <td class="p-3">{{ $item['qty'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="cart-summary mt-3">
                    <h5 class="text-f1faee">Ваш заказ:</h5>
                    <p class="text-adb5bd">Итого: <span id="cart-qty">{{ session('cart_qty') }}</span> шт.</p>
                    <p class="text-adb5bd">На сумму: <span id="cart-total">@price_format(session('cart_total')) руб.</span></p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm checkout-form-card">
            <div class="card-body p-4">
                <form action="{{ route('cart.checkout') }}" method="POST" class="mb-0">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name" class="text-f1faee">Имя</label>
                        <input type="text" name="name" id="name" required class="form-control checkout-input" value="{{ old('name') }}">
                        <input type="email" name="email" id="email" required class="form-control checkout-input" value="{{ Auth::user()->email }}" hidden>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone" class="text-f1faee">Телефон</label>
                        <input type="text" name="phone" id="phone" required class="form-control checkout-input" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address" class="text-f1faee">Адрес</label>
                        <input type="text" name="address" id="address" required class="form-control checkout-input" value="{{ old('address') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="note" class="text-f1faee">Примечание</label>
                        <textarea name="note" id="note" class="form-control checkout-input">{{ old('note') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить заказ</button>
                </form>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm text-center empty-cart-card">
            <div class="card-body p-4">
                <h4 class="text-f1faee">Корзина пуста</h4>
                <p class="text-adb5bd">Добавьте товары, чтобы начать оформление заказа.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Вернуться к покупкам</a>
            </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Delete item from cart
            $('.del-item').on('click', function() {
                var action = $(this).data('action');
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#liveToast').fadeIn().delay(3000).fadeOut();
                        location.reload(); // Reload to update cart
                    },
                    error: function(xhr) {
                        console.error('Error deleting item:', xhr.responseText);
                        alert('Не удалось удалить товар из корзины. Пожалуйста, попробуйте снова.');
                    }
                });
            });
        });
    </script>
@endsection