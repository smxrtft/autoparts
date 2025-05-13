@extends('layouts.layout')

@section('title')
    Сброс пароля
@endsection

@section('content')
    <div class="container py-4">
        <!-- Toast Notification -->
        <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast"
            style="display: none; right: 1%; bottom: 1%; z-index: 999">
            <i class="fa fa-check" aria-hidden="true"></i> Пароль успешно сброшен
        </div>

        <h1 class="text-center mb-4 section-title">Сброс пароля</h1>


        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card border-0 shadow-sm admin-card">
                    <div class="card-body p-4">
                        <form id="submitForm" action="{{ route('password.update') }}" method="POST" class="reset-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Электронная почта <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control admin-input @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Введите email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Пароль <span class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control admin-input @error('password') is-invalid @enderror" id="password"
                                    name="password" placeholder="Введите пароль">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Подтвердите пароль <span
                                        class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control admin-input @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Подтвердите пароль">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <button class="btn btn-primary w-100" type="submit">Сменить пароль</button>
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
                        window.location.href = '{{ route('login') }}';
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        var errors = xhr.responseJSON.errors || {};
                        var errorMessage = '<ul class="mb-0">';
                        $.each(errors, function(key, value) {
                            errorMessage +=
                                '<li><i class="fas fa-exclamation-circle mr-2"></i>' +
                                value[0] + '</li>';
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(value[0]);
                        });
                        errorMessage += '</ul>';
                        $('.alert-danger').remove();

                        // Создаем сообщение об ошибке
                        var alertDiv = $('<div class="alert alert-danger mb-4">' +
                            errorMessage + '</div>');
                        form.before(alertDiv);

                        // Устанавливаем таймер для автоматического скрытия через 5 секунд (5000 мс)
                        setTimeout(function() {
                            alertDiv.fadeOut(500, function() {
                                $(this).remove();
                            });
                        }, 5000);
                    }
                });
            });
        });
    </script>
@endsection
