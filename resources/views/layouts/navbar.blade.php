<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('storage/img/logo.webp') }}" width="50"
            height="50" style="border-radius: 50%" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
        aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">Главная <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa fa-tags mr-1" aria-hidden="true"></i>Категории
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', ['slug' => $category->slug]) }}"
                            class="nav-link nav-categories">{{ $category->title }}</a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('delivery') }}" class="nav-link">Условия доставки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contacts') }}" class="nav-link">Контакты</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link">О нас</a>
            </li>
            <li class="nav-item">
                <button onclick="getCart('{{ route('cart.show') }}')" type="button" class="btn btn-cart">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Корзина <span
                        class="badge badge-dark mini-cart-qty">{{ session('cart_qty') ?? 0 }}</span>
                </button>
            </li>
        </ul>
        @if (Auth::user())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-auth" href="#" role="button" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa fa-user-circle align-middle mr-1" aria-hidden="true"></i>{{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <form action="{{ route('logout') }}" method="post">@csrf <button type="submit"
                            class="dropdown-item"><i class="fas fa-sign-out-alt mr-1"></i>Выйти из аккаунта</button>
                    </form>
                    @if (Auth::user() and Auth::user()->email == 'admin@mail.ru')
                        <a href="{{ route('admin.index') }}" class="dropdown-item"><i
                                class="fas fa-user-shield mr-1"></i>Админ-панель</a>
                    @endif
                </div>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-auth" href="#" role="button" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa fa-user-circle align-middle mr-1" aria-hidden="true"></i>Гость
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('login') }}" class="dropdown-item"><i
                            class="fas fa-sign-in-alt mr-1"></i>Логин</a>
                    <a href="{{ route('register') }}" class="dropdown-item"><i
                            class="fas fa-user-plus mr-1"></i>Регистрация</a>
                </div>
            </li>
        @endif
    </div>
</div>
</nav>
