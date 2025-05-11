@extends('layouts.layout')

@section('title')
    Восстановление пароля
@endsection

@section('content')
<div class="container py-4">
    <!-- Toast Notification -->
    <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast" style="display: none; right: 1%; bottom: 1%; z-index: 999">
        <i class="fa fa-check" aria-hidden="true"></i> Ссылка для сброса пароля отправлена
    </div>

    <h1 class="text-center mb-4 section-title">Восстановление пароля</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card border-0 shadow-sm admin-card">
                <div class="card-body p-4">
                    <form id="submitForm" action="{{ route('password.email') }}" method="POST" class="reset-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Электронная почта <span class="text-danger">*</span></label>
                            <input type="email" class="form-control admin-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Введите email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <button class="btn btn-primary w-100" type="submit">Отправить ссылку</button>
                        </div>
                    </form>
                    <p class="small pt-3 text-center">
                        <span class="text-muted">Уже зарегистрированы?</span>
                        <a href="{{ route('login') }}" class="text-a8dadc">Войти</a>
                    </p>
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
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#liveToast').fadeIn().delay(3000).fadeOut();
                        form[0].reset();
                        $('.alert-success').not('#liveToast').remove();
                        form.before('<div class="alert alert-success mb-4"><i class="fas fa-check-circle mr-2"></i>Ссылка для сброса пароля отправлена на вашу почту</div>');
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        var errors = xhr.responseJSON.errors || {};
                        var errorMessage = '<ul class="mb-0">';
                        $.each(errors, function(key, value) {
                            errorMessage += '<li><i class="fas fa-exclamation-circle mr-2"></i>' + value[0] + '</li>';
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(value[0]);
                        });
                        errorMessage += '</ul>';
                        $('.alert-danger').remove();
                        form.before('<div class="alert alert-danger mb-4">' + errorMessage + '</div>');
                    }
                });
            });
        });
    </script>
@endsection