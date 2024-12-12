@extends('layouts.layout')

@section('title')
    Admin Page
@endsection
@section('admin-page')
    @if ($errors->any())
        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

            <ul>

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif
    <div class="container">
        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Добавить продукт</a>
        <a href="{{ route('admin.create-category') }}" class="btn btn-primary mb-3">Добавить категорию</a>
    </div>
    <div class="container-fluid">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Товары</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Категории</a>
                <a class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button"
                    role="tab" aria-controls="nav-contact" aria-selected="false">Заказы</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col" class="col-2">Наименование</th>
                            <th scope="col" class="col-2">Описание</th>
                            <th scope="col" class="col-1">Категория</th>
                            <th scope="col">Статус</th>
                            <th scope="col" class="col-1">Изображение</th>
                            <th scope="col" class="col-1">Цена</th>
                            <th scope="col" class="col-1">Старая цена</th>
                            <th scope="col">Хит</th>
                            <th scope="col">Скидка</th>
                            <th scope="col" class="col-1">Редактировать/удалить</th>
                        </tr>
                    </thead>
                    @foreach ($products as $product)
                        <form action="{{ route('admin.update', $product) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <tbody>
                                <tr>
                                    <div class="form-group">
                                        <th scope="row">{{ $product->id }}</th>
                                        <td><input class="form-control" type="text" name="title" id="title"
                                                value="{{ $product->title }}"></td>
                                        <td>
                                            <textarea name="content" class="form-control" id="content" cols="40" rows="5">{{ $product->content }}</textarea>
                                        </td>
                                        <td><select name="category_id" id="" class="form-control">
                                                <option value="{{ $product->category_id }}">{{ $product->category->title }}
                                                </option>
                                                @foreach ($categories as $category)
                                                    @if ($product->category->title != $category->title)
                                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @else
                                                    @endif
                                                @endforeach
                                            </select></td>
                                        <td><select name="status_id" class="form-select form-control"
                                                id="inputGroupSelect01">
                                                @if ($product->status_id == 1)
                                                    <option value="1">В наличии</option>
                                                    <option value="2">Ожидается</option>
                                                @else
                                                    <option value="2">Ожидается</option>
                                                    <option value="1">В наличии</option>
                                                @endif
                                            </select></td>
                                        {{-- <td><input type="text" name="img" id="img" value="{{ $product->img }}" class="form-control"></td> --}}
                                        <td><img src="{{ $product->getImage() }}" alt=""> <input type="file"
                                                name="img" id="img" class="form-control p-1"></td>
                                        <td><input type="text" name="price" id="price"
                                                value="{{ $product->price }}" class="form-control"></td>
                                        <td><input type="text" name="old_price" id="old_price"
                                                value="{{ $product->old_price }}" class="form-control"></td>
                                        <td><select name="hit" class="form-select form-control"
                                                id="inputGroupSelect01">
                                                @if ($product->hit == 1)
                                                    <option value="1">Хит</option>
                                                    <option value="0">Не хит</option>
                                                @else
                                                    <option value="0">Не хит</option>
                                                    <option value="1">Хит</option>
                                                @endif
                                            </select></td>
                                        <td> <select name="sale" class="form-select form-control"
                                                id="inputGroupSelect01">
                                                @if ($product->sale == 1)
                                                    <option value="1">Скидка</option>
                                                    <option value="0">Не скидка</option>
                                                @else
                                                    <option value="0">Не скидка</option>
                                                    <option value="1">Скидка</option>
                                                @endif
                                            </select></td>
                                        <td> <button class="btn btn-primary mb-3" type="submit">Редактировать</button>
                        </form>

                        <form action="{{ route('admin.destroy', $product->id) }}" method="post">@csrf<button
                                type="submit" class="btn btn-danger"
                                onclick="return confirm('Вы действительно хотите удалить продукт?')">Удалить</button>
                        </form>
                        </td>
            </div>
            </tr>
            </tbody>
            @endforeach
            </table>
            <div class="container">
                <div class="col-md-12">
                    <nav aria-label="Page navigation example">
                        {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col" class="col-4">Название</th>
                        <th scope="col">Редактировать/удалить</th>
                    </tr>
                </thead>
                @foreach ($categories as $category)
                    <form action="{{ route('admin.update-category', $category) }}" method="post">
                        @csrf
                        <tbody>
                            <tr>
                                <div class="form-group">
                                    <th scope="row">{{ $category->id }}</th>
                                    <td><input class="form-control" type="text" name="title" id="title"
                                            value="{{ $category->title }}"></td>
                                    <td> <button class="btn btn-primary mb-3" type="submit">Редактировать</button>
                    </form>
                    <form action="{{ route('admin.destroy-category', $category->id) }}" method="post">@csrf<button
                            type="submit" class="btn btn-danger"
                            onclick="return confirm('Вы действительно хотите удалить категорию?')">Удалить</button></form>
                    </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Email</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Адрес</th>
                        <th scope="col">Примечание</th>
                        <th scope="col">Сумма</th>
                    </tr>
                </thead>
                @foreach ($orders as $order)
                    <tbody>
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->note }}</td>
                            <td>@price_format($order['total']) руб.</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
    </div>

@endsection
