<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <!-- Логотип + кнопка корзины (мобильная версия) -->
        <div class="d-flex align-items-center">
            <a class="navbar-brand mr-auto" href="{{ route('home') }}">
                <img src="{{ asset('storage/img/logo.webp') }}" width="40" height="40" class="rounded-circle mr-2" alt="Логотип">
            </a>
            
            <!-- Кнопки для мобильной версии -->
            <div class="d-lg-none">
                <button onclick="getCart('{{ route('cart.show') }}')" type="button" class="btn btn-primary nav-cart-btn position-relative mr-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mini-cart-qty">
                        {{ session('cart_qty') ?? 0 }}
                    </span>
                </button>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>

        <!-- Основное меню -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home mr-1"></i> Главная</a>
                </li>
                
                <!-- Категории с мегаменю -->
                <li class="nav-item dropdown mega-menu">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-tags mr-1"></i> Категории
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg p-4" aria-labelledby="categoriesDropdown">
                        <div class="row">
                            @foreach($categories->chunk(ceil($categories->count()/3)) as $chunk)
                            <div class="col-md-4">
                                @foreach($chunk as $category)
                                <a class="dropdown-item py-2 border-bottom" href="{{ route('categories.show', ['slug' => $category->slug]) }}">
                                    <i class="fas fa-{{ $category->icon ?? 'tag' }} mr-2 text-primary"></i>
                                    {{ $category->title }}
                                </a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('delivery') }}"><i class="fas fa-truck mr-1"></i> Доставка</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contacts') }}"><i class="fas fa-map-marker-alt mr-1"></i> Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}"><i class="fas fa-info-circle mr-1"></i> О нас</a>
                </li>
            </ul>

            <!-- Правая часть меню -->
            <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center">
                <!-- Поиск -->
                <form class="form-inline my-2 my-lg-0 mx-lg-2 mb-3 mb-lg-0 w-100" action="{{ route('products.search') }}" method="GET">
                    <div class="input-group flex-nowrap">
                        <input class="form-control input-search" type="search" name="query" 
                               placeholder="Поиск товаров..." aria-label="Search" 
                               value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-light btn-search" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Корзина (десктопная версия) -->
                <div class="d-none d-lg-block ml-lg-2">
                    <button onclick="getCart('{{ route('cart.show') }}')" type="button" class="btn btn-primary nav-cart-btn position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mini-cart-qty">
                            {{ session('cart_qty') ?? 0 }}
                        </span>
                    </button>
                </div>
                
                <!-- Профиль пользователя -->
                <div class="dropdown ml-lg-2 mt-2 mt-lg-0">
                    @auth
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle mr-1"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">
                        @if(Auth::user()->email == 'admin@mail.ru')
                        <a class="dropdown-item" href="{{ route('admin.index') }}">
                            <i class="fas fa-user-shield mr-2"></i>Админ-панель
                        </a>
                        <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ route('orders') }}">
                            <i class="fas fa-box-open mr-2"></i>Мои заказы
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i>Выйти
                            </button>
                        </form>
                    </div>
                    @else
                    <a class="btn btn-secondary dropdown-toggle" href="#" id="guestDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle mr-1"></i>
                        <span class="d-none d-md-inline">Войти</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="guestDropdown">
                        <a class="dropdown-item" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt mr-2"></i>Авторизация
                        </a>
                        <a class="dropdown-item" href="{{ route('register') }}">
                            <i class="fas fa-user-plus mr-2"></i>Регистрация
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
