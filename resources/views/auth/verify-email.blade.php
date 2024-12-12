@extends('layouts.layout')

@section('title')
    Register page
@endsection
@section('content')
    <div class="container">
        <div class="alert alert-info" role="alert">
            Спасибо за регистрацию, ссылка для подтверждения отправлена на вашу почту
        </div>
        <div>
            Не получили письмо?
            <form method="post" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary ps-0">Отправить повторно</button>
            </form>
        </div>
    </div>
@endsection
