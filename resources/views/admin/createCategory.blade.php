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
            <h1 class="text-center mb-4 section-title">Добавление категории</h1>

            <div class="container">
                <div class="row">
                    <div class="col-md-5 mx-auto">
                        <div class="card card-body">

                            <form id="submitForm" action="{{ route('admin.store-category') }}" method="post">
                                @csrf
                                <div class="form-group required">
                                    <lSabel for="title" class="mb-3">Название категории</lSabel>
                                    <input type="text"
                                        class="mt-1 form-control admin-input @error('title') is-invalid @enderror"
                                        name="title" id="title" value="" placeholder="Название категории">
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
