@extends('layouts.layout')

@section('title')
    Login page
@endsection
@section('content')
    @if ($errors->any())
        @foreach($errors->all() as $error)
        <li style="list-style: none"><i class="fas fa-exclamation"></i>  {{ $error }} </li>
        @endforeach
    @endif
    {{-- <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required class="form-control">
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required class="form-control">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label for="remember" class="form-check-label">Remember me</label>
        </div>
        <div>
            <button type="submit" class="btn btn-primary mt-3">Login</button>

            <a href="{{ route('password.request') }}" class="ms-2">Forgot password?</a>
        </div>
    </div>
    </form> --}}
    <div class="container">
    <div class="pt-5">
        <h1 class="text-center mb-4">Авторизация</h1>
        
      <div class="container">
                      <div class="row">
                          <div class="col-md-5 mx-auto">
                              <div class="card card-body">
                                                          
                                  <form id="submitForm" action="{{ route('login') }}" method="post" data-parsley-validate="" data-parsley-errors-messages-disabled="true" novalidate="" _lpchecked="1">@csrf
                                      <div class="form-group required">
                                          <lSabel for="email">Электронная почта</lSabel>
                                          <input type="email" class="form-control text-lowercase @error('email') is-invalid @enderror" id="email" required="" name="email" value="{{ old('email') }}" placeholder="Email">
                                      </div>                    
                                      <div class="form-group required">
                                          <label class="d-flex flex-row align-items-center" for="password">Пароль
                                              <a class="ml-auto border-link small-xl" href="{{ route('password.request') }}">Восстановить пароль</a></label>
                                          <input type="password" class="form-control @error('password') is-invalid @enderror" required="" id="password" name="password" value="" placeholder="пароль">
                                      </div>
                                      <div class="form-group mt-4 mb-4">
                                          <div class="custom-control custom-checkbox">
                                              <input type="checkbox" class="custom-control-input" id="remember" name="remember" data-parsley-multiple="remember">
                                              <label class="custom-control-label" for="remember">Запомнить меня</label>
                                          </div>
                                      </div>
                                      <div class="form-group pt-1">
                                          <button class="btn btn-primary btn-block" type="submit">Войти</button>
                                      </div>
                                  </form>
                                  <p class="small-xl pt-3 text-center">
                                      <span class="text-muted">Ещё не зарегистрированы?</span>
                                      <a href="{{ route('register') }}">Зарегистрироваться</a>
                                  </p>
                              </div>
                          </div>
                      </div>
                  </div>
      </div>
    </div>
@endsection
