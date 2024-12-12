@extends('layouts.layout')

@section('title')
    Admin Page
@endsection
@section('content')
    {{-- <div class="container">
             <form action="{{ route('admin.store') }}" method="post" enctype="multipart/form-data">
                @csrf
            <tbody>
                <tr>
                    <div class="form-group">
                    <td><label for="title">title</label><input class="form-control" type="text" name="title" id="title" value="" placeholder="title"></td>
                    <td><label for="content">content</label><input type="text" class="form-control" name="content" id="content" placeholder="content"></td>
                    <td><label for="category_id">category_id</label><input type="number" max="2" min="1" name="category_id" id="category_id" value="" class="form-control" placeholder="category_id(1 or 2)"></td>
                    <td><label for="status_id">status_id</label><select name="status_id" class="form-select" id="inputGroupSelect01">
                        <option value="1">В наличии</option>
                        <option value="2">Ожидается</option>
                      </select></td>
                    {{-- <td><input type="text" name="img" id="img" value="{{ $product->img }}" class="form-control"></td> 
                    <td><label for="img">img</label><input type="file" name="img" id="img" class="form-control"></td>
                    <td><label for="price">price</label><input type="text" name="price" id="price" value="" placeholder="price" class="form-control"></td>
                    <td><label for="old_proce">old_price</label><input type="text" name="old_price" id="old_price" value="" placeholder="old_price" class="form-control"></td>
                    <td><label for="hit">hit</label><select name="hit" class="form-select" id="inputGroupSelect01">
                        <option value="0">0</option>
                        <option value="1">1</option>
                      </select></td>
                    <td><label for="sale">sale</label> <select name="sale" class="form-select" id="inputGroupSelect01">
                        <option value="0">0</option>
                        <option value="1">1</option>
                      </select></td>
                   <td> <button class="btn btn-primary" type="submit">create</button></td>
                   
            </div>
                </tr>
            </form> 
   </div>          --}}
    <div class="container">
        <div class="pt-5">
            <h1 class="text-center mb-4">Добавление продукта</h1>

            <div class="container">
                <div class="row">
                    <div class="col-md-5 mx-auto">
                        <div class="card card-body">

                            <form id="submitForm" action="{{ route('admin.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group required">
                                    <lSabel for="title">Наименование</lSabel>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        type="text" name="title" id="title" value="{{ old('title') }}"
                                        placeholder="Наименование">

                                </div>
                                <div class="form-group required">
                                    <lSabel for="title">Описание товара</lSabel>
                                    <textarea name="content" id="content" cols="30" rows="5" class="form-control @error('content') is-invalid @enderror"
                                        placeholder="Описание товара">{{ old('content') }}</textarea>
                                </div>
                                <div class="form-group required">
                                    <lSabel for="email">Категория</lSabel>
                                    <select name="category_id" id="" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Выберите категорию</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('cocategory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group required">
                                    <lSabel for="status_id">Статус</lSabel>
                                    <select name="status_id" class="form-control" id="inputGroupSelect01">
                                        <option value="1">В наличии</option>
                                        <option value="2">Ожидается</option>
                                    </select>
                                </div>
                                <div class="form-group required">
                                    <lSabel for="img">Изображение</lSabel>
                                    <input type="file" name="img" id="img" class="form-control p-1">
                                </div>
                                <div class="form-group required">
                                    <lSabel for="price">Цена</lSabel>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                                        value="{{ old('price') }}" placeholder="Цена">
                                </div>
                                <div class="form-group required">
                                    <lSabel for="old_price">Старая цена</lSabel>
                                    <input type="number" class="form-control @error('old_price') is-invalid @enderror" name="old_price" id="old_price"
                                        value="{{ old('old_price') }}" placeholder="Старая цена">
                                </div>
                                <div class="form-group required">
                                    <lSabel for="hit">Хит</lSabel>
                                    <select name="hit" class="form-control" id="inputGroupSelect01">
                                        <option value="0">Не хит</option>
                                        <option value="1">Хит</option>
                                    </select>
                                </div>
                                <div class="form-group required">
                                    <lSabel for="sale">Скидка</lSabel>
                                    <select name="sale" class="form-control" id="inputGroupSelect01">
                                        <option value="0">Без скидки</option>
                                        <option value="1">Со скидкой</option>
                                    </select>
                                </div>
                                <div class="form-group pt-1">
                                    <button class="btn btn-primary btn-block" type="submit">Добавить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
