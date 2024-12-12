@extends('layouts.layout')
@section('title')@parent  Оформление заказа
@endsection
@section('content')
    <div class="col-md-12">
        <h1>Оформление заказа</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
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
                    @foreach(session('cart') as $item)
                    <tr>
                        <td class="p-3">
                            <a href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" class="img-fluid w-25 h-25 object-fit-cover">
                            </a>
                        </td>
                        <td class="p-3"><a href="{{ route('products.show', ['slug' => $item['slug']]) }}">{{ $item['title'] }}</a></td>
                        <td class="p-3">@price_format($item['price']) руб.</td>
                        <td class="p-3">{{ $item['qty'] }}</td>
                        <td class="p-3">
                            <button type="button" class="btn btn-danger del-item" data-action="{{ route('cart.del_item', ['product_id' => $item['product_id']]) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <div class="cart-summary">
                    <h5>Ваш заказ:</h5>
                    <p>Итого: <span id="modal-cart-qty">{{ session('cart_qty') }}</span> шт.</p>
                    <p>На сумму: <span id="modal-cart-total">@price_format(session('cart_total')) руб.</span></p>
                </div>
            </div>
        </div>
    <form action="{{ route('cart.checkout') }}" method="POST" class="mb-5">
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" required class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="number" name="phone" id="phone" required class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Адрес</label>
            <input type="text" name="address" id="address" required class="form-control" required>
        </div>
        <div class="form-group">
            <label for="note">Примечание</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
@else
    <h4>Корзина пуста</h4>
@endif
    </div>
@endsection