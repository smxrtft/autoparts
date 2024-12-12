@extends('layouts.layout')

@section('title')
    Reset password
@endsection
@section('content')
    {{-- <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="h2">Reset pass here</h1>

            <form action="{{ route('password.update') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm pass</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" id="password_confirmation" placeholder="Confirm pass" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary">Reset pass</button>
            </form>
        </div>
    </div> --}}
    <div class="container">
        <div class="pt-5">
            <h1 class="text-center mb-4">Сброс пароля</h1>

            <div class="container">
                <div class="row">
                    <div class="col-md-5 mx-auto">
                        <div class="card card-body">

                            <form id="submitForm" action="{{ route('password.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group required">
                                    <lSabel for="email">Электронная почта</lSabel>
                                    <input type="email" name="email" id="email"
                                        class="form-control text-lowercase @error('email') is-invalid @enderror"
                                        placeholder="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group required">
                                    <label class="d-flex flex-row align-items-center" for="password">Пароль</label>
                                    <input type="password" class="form-control" required="" id="password"
                                        name="password" value="" placeholder="пароль">
                                </div>
                                <div class="form-group required">
                                    <label class="d-flex flex-row align-items-center"
                                        for="password_confirmation">Подтвердите пароль</label>
                                    <input type="password" class="form-control" required="" id="password_confirmation"
                                        name="password_confirmation" value="" placeholder="подтвердите пароль">
                                </div>
                                <div class="form-group pt-1">
                                    <button class="btn btn-primary btn-block" type="submit">Сменить пароль</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
