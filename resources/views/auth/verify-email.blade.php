@extends('layouts.layout')

@section('title')
    Подтверждение email
@endsection

@section('content')
    <div class="container py-4">
        <!-- Toast Notification -->
        <div class="alert alert-success position-fixed w-25" role="alert" id="liveToast"
            style="display: none; right: 1%; bottom: 1%; z-index: 999">
            <i class="fa fa-check" aria-hidden="true"></i> Ссылка для подтверждения отправлена повторно
        </div>

        <h1 class="text-center mb-4 section-title">Подтверждение email</h1>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card border-0 shadow-sm admin-card">
                    <div class="card-body p-4">
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle mr-2"></i> Спасибо за регистрацию! Ссылка для подтверждения
                            отправлена на вашу почту.
                        </div>


                        @if (session('status'))
                            <div class="alert alert-success mb-4">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        <p class="text-muted mb-3">Не получили письмо?</p>
                        <form id="resendForm" method="POST" action="{{ route('verification.send') }}" class="reset-form">
                            @csrf
                            <div class="form-group mt-2">
                                <button class="btn btn-primary w-100" type="submit">Отправить повторно</button>
                            </div>
                        </form>
                        <p class="small pt-3 text-center">
                            <span class="text-muted">Уже подтвердили email?</span>
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
            $('#resendForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#liveToast').fadeIn().delay(3000).fadeOut();
                        $('.alert-success').not('#liveToast').remove();
                        form.before(
                            '<div class="alert alert-success mb-4"><i class="fas fa-check-circle mr-2"></i>Ссылка для подтверждения отправлена повторно</div>'
                            );
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        var errors = xhr.responseJSON.errors || {};
                        var errorMessage = '<ul class="mb-0">';
                        $.each(errors, function(key, value) {
                            errorMessage +=
                                '<li><i class="fas fa-exclamation-circle mr-2"></i>' +
                                value[0] + '</li>';
                        });
                        errorMessage += '</ul>';
                        $('.alert-danger').remove();
                        form.before('<div class="alert alert-danger mb-4">' + errorMessage +
                            '</div>');
                    }
                });
            });
        });
    </script>
@endsection
