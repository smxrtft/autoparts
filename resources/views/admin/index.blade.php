@extends('layouts.layout')

@section('title')
    Admin Page
@endsection

@section('admin-page')
    <div class="">
        <!-- Toast Notification -->
        <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast"
            style="display: none; right: 1%; bottom: 1%; z-index: 999">
            <i class="fa fa-check" aria-hidden="true"></i> Действие выполнено успешно
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>Ошибка!</strong> Пожалуйста, исправьте следующие проблемы:
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex mb-4">
            <a href="{{ route('admin.create') }}" class="btn btn-primary mr-2">Добавить продукт</a>
            <a href="{{ route('admin.create-category') }}" class="btn btn-primary">Добавить категорию</a>
        </div>

        <div class="card border-0 shadow-sm admin-card">
            <div class="card-body p-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Товары</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Категории</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                            role="tab" aria-controls="nav-contact" aria-selected="false">Заказы</a>
                    </div>
                </nav>
                <div class="tab-content mt-4" id="nav-tabContent">
                    <!-- Products Tab -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col" class="col-title">Наименование</th>
                                        <th scope="col" class="col-content">Описание</th>
                                        <th scope="col" class="col-category">Категория</th>
                                        <th scope="col" class="col-status">Статус</th>
                                        <th scope="col" class="col-img">Изображение</th>
                                        <th scope="col" class="col-price">Цена</th>
                                        <th scope="col" class="col-old-price">Старая цена</th>
                                        <th scope="col" class="col-hit">Хит</th>
                                        <th scope="col" class="col-sale">Скидка</th>
                                        <th scope="col" class="col-actions">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <form action="{{ route('admin.update', $product) }}" method="POST"
                                                enctype="multipart/form-data" class="admin-form">
                                                @csrf
                                                <th scope="row">{{ $product->id }}</th>
                                                <td><input class="form-control admin-input" type="text" name="title"
                                                        value="{{ $product->title }}"></td>
                                                <td>
                                                    <textarea class="form-control admin-textarea" name="content" rows="4">{{ $product->content }}</textarea>
                                                </td>
                                                <td>
                                                    <select name="category_id" class="form-control admin-select">
                                                        <option value="{{ $product->category_id }}">
                                                            {{ $product->category->title }}</option>
                                                        @foreach ($categories as $category)
                                                            @if ($product->category->title != $category->title)
                                                                <option value="{{ $category->id }}">{{ $category->title }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="status_id" class="form-control admin-select">
                                                        <option value="1"
                                                            {{ $product->status_id == 1 ? 'selected' : '' }}>В наличии
                                                        </option>
                                                        <option value="2"
                                                            {{ $product->status_id == 2 ? 'selected' : '' }}>Ожидается
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <img src="{{ $product->getImage() }}" alt="{{ $product->title }}"
                                                        class="img-fluid w-100 h-100 object-fit-cover mb-2">
                                                    <input type="file" name="img"
                                                        class="form-control admin-input p-1">
                                                </td>
                                                <td><input class="form-control admin-input" type="text" name="price"
                                                        value="{{ $product->price }}"></td>
                                                <td><input class="form-control admin-input" type="text"
                                                        name="old_price" value="{{ $product->old_price }}"></td>
                                                <td>
                                                    <select name="hit" class="form-control admin-select">
                                                        <option value="1" {{ $product->hit == 1 ? 'selected' : '' }}>
                                                            Хит</option>
                                                        <option value="0" {{ $product->hit == 0 ? 'selected' : '' }}>
                                                            Не хит</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sale" class="form-control admin-select">
                                                        <option value="1"
                                                            {{ $product->sale == 1 ? 'selected' : '' }}>Скидка</option>
                                                        <option value="0"
                                                            {{ $product->sale == 0 ? 'selected' : '' }}>Не скидка</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary mb-2 w-100"
                                                        type="submit">Редактировать</button>
                                            </form>
                                            <form action="{{ route('admin.destroy', $product->id) }}" method="POST"
                                                class="admin-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger w-100"
                                                    onclick="return confirm('Вы действительно хотите удалить продукт?')">Удалить</button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation" class="mt-4">
                            {{ $products->links() }}
                        </nav>
                    </div>

                    <!-- Categories Tab -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col" class="col-title">Название</th>
                                        <th scope="col" class="col-actions">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <form action="{{ route('admin.update-category', $category) }}" method="POST"
                                                class="admin-form">
                                                @csrf
                                                <th scope="row">{{ $category->id }}</th>
                                                <td><input class="form-control admin-input" type="text" name="title"
                                                        value="{{ $category->title }}"></td>
                                                <td>
                                                    <button class="btn btn-primary mb-2 w-30"
                                                        type="submit">Редактировать</button>
                                            </form>
                                            <form action="{{ route('admin.destroy-category', $category->id) }}"
                                                method="POST" class="admin-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger w-30"
                                                    onclick="return confirm('Вы действительно хотите удалить категорию?')">Удалить</button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Имя</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Телефон</th>
                                        <th scope="col">Адрес</th>
                                        <th scope="col">Примечание</th>
                                        <th scope="col">Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $order->id }}</th>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>{{ $order->note }}</td>
                                            <td>@price_format($order['total']) руб.</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            // Handle edit and delete form submissions
            $('.admin-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method') === 'POST' ? 'POST' :
                    'POST', // Handle DELETE via POST with _method
                    data: form.serialize(),
                    success: function(response) {
                        $('#liveToast').fadeIn().delay(3000).fadeOut();
                        location.reload(); // Reload to update table
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        alert('Не удалось выполнить действие. Пожалуйста, попробуйте снова.');
                    }
                });
            });
        });
    </script>
@endsection
