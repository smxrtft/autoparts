@extends('layouts.layout')

@section('title')
    Admin - Добавить продукт
@endsection

@section('content')
<div class="container py-4">
    <!-- Toast Notification -->
    <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index: 999">
        <i class="fa fa-check" aria-hidden="true"></i> Продукт успешно добавлен
    </div>

    <h1 class="text-center mb-4 section-title">Добавление продукта</h1>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card border-0 shadow-sm admin-card">
                <div class="card-body p-4">
                    <form id="submitForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Наименование <span class="text-danger">*</span></label>
                            <input type="text" class="form-control admin-input @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}" placeholder="Введите наименование">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Описание товара <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control admin-textarea @error('content') is-invalid @enderror" rows="5" placeholder="Введите описание товара">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Категория <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control admin-select @error('category_id') is-invalid @enderror">
                                <option value="" {{ old('category_id') ? '' : 'selected' }}>Выберите категорию</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="status_id" class="form-label">Статус <span class="text-danger">*</span></label>
                            <select name="status_id" id="status_id" class="form-control admin-select">
                                <option value="1" {{ old('status_id', 1) == 1 ? 'selected' : '' }}>В наличии</option>
                                <option value="2" {{ old('status_id') == 2 ? 'selected' : '' }}>Ожидается</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="img" class="form-label">Изображение</label>
                            <input type="file" name="img" id="img" class="form-control admin-input p-1">
                        </div>
                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Цена <span class="text-danger">*</span></label>
                            <input type="number" class="form-control admin-input @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price') }}" placeholder="Введите цену" min="0" step="0.01">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="old_price" class="form-label">Старая цена</label>
                            <input type="number" class="form-control admin-input @error('old_price') is-invalid @enderror" name="old_price" id="old_price" value="{{ old('old_price') }}" placeholder="Введите старую цену" min="0" step="0.01">
                            @error('old_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="hit" class="form-label">Хит</label>
                            <select name="hit" id="hit" class="form-control admin-select">
                                <option value="0" {{ old('hit', 0) == 0 ? 'selected' : '' }}>Не хит</option>
                                <option value="1" {{ old('hit') == 1 ? 'selected' : '' }}>Хит</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sale" class="form-label">Скидка</label>
                            <select name="sale" id="sale" class="form-control admin-select">
                                <option value="0" {{ old('sale', 0) == 0 ? 'selected' : '' }}>Без скидки</option>
                                <option value="1" {{ old('sale') == 1 ? 'selected' : '' }}>Со скидкой</option>
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <button class="btn btn-primary w-100" type="submit">Добавить продукт</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#submitForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#liveToast').fadeIn().delay(3000).fadeOut();
                        window.location.href = '{{ route("admin.index") }}';
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        var errors = xhr.responseJSON.errors || {};
                        var errorMessage = 'Не удалось добавить продукт. Пожалуйста, исправьте ошибки:';
                        $.each(errors, function(key, value) {
                            errorMessage += '\n- ' + value[0];
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(value[0]);
                        });
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>
@endsection