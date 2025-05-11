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
                        <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" class="img-fluid w-100 h-100 object-fit-cover">
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
@else
<div class="text-center">
    <h4>Корзина пуста</h4>
    <p>Добавьте товары, чтобы начать оформление заказа.</p>
</div>
@endif