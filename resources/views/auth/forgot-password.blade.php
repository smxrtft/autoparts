@extends('layouts.layout')

@section('title')
    Forgot password
@endsection
@section('content')
    {{-- <h1 class="h2">Forgot password</h1>

    <p>email for link</p>

    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form> --}}
    <div class="container">
        <div class="pt-5">
            <h1 class="text-center mb-4">Сброс пароля</h1>
            
          <div class="container">
                          <div class="row">
                              <div class="col-md-5 mx-auto">
                                  <div class="card card-body">
                                                              
                                      <form id="submitForm" action="{{ route('password.email') }}" method="post">
                                        @csrf
                                          <div class="form-group required">
                                              <lSabel for="email">Электронная почта</lSabel>
                                              <input type="email" name="email" id="email" class="form-control text-lowercase @error('email') is-invalid @enderror" placeholder="email" value="{{ old('email') }}">
                                              @error('email')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                              @enderror
                                          </div>                                                   
                                          <div class="form-group pt-1">
                                              <button class="btn btn-primary btn-block" type="submit">Отправить сообщение</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
          </div>
        </div>
@endsection