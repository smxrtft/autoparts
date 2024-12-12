@extends('layouts.layout')

@section('title')
    Register page
@endsection
@section('content')
    {{-- @if ($errors->any())
        @foreach ($errors->all() as $error)
        <li>{{ $error }} </li>
        @endforeach
    @endif --}}
    {{-- <h1>Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required autofocus class="form-control">
        </div>
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required class="form-control">
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required class="form-control">
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
        </div>
        <div>
            <button type="submit" class="btn btn-primary mt-3">Register</button>
        </div>
    </div>
    </form> --}}
    <div class="container">
        <div class="pt-5">
            <h1 class="text-center mb-4">Регистрация</h1>

            <div class="container">
                <div class="row">
                    <div class="col-md-5 mx-auto">
                        <div class="card card-body mb-5">

                            <form id="submitForm" action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="form-group required">
                                    <lSabel for="name">Имя</lSabel>
                                    <input type="text" class="form-control text-lowercase @error('name') is-invalid @enderror" id="name" required=""
                                        name="name" value="{{ old('name') }}" placeholder="имя">
                                </div>
                                <div class="form-group required">
                                    <lSabel for="email">Электронная почта</lSabel>
                                    <input type="email" class="form-control text-lowercase @error('email') is-invalid @enderror" id="email" required=""
                                        name="email" value="{{ old('email') }}" placeholder="Email">
                                </div>
                                <div class="form-group required">
                                    <label class="d-flex flex-row align-items-center" for="password">Пароль</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" required="" id="password"
                                        name="password" value="" placeholder="пароль">
                                </div>
                                <div class="form-group required">
                                    <label class="d-flex flex-row align-items-center"
                                        for="password_confirmation">Подтвердите пароль</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" required="" id="password_confirmation"
                                        name="password_confirmation" value="" placeholder="подтвердите пароль">
                                </div>
                                <div class="form-group pt-1">
                                    <button class="btn btn-primary btn-block" type="submit">Зарегистрироваться</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
