{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин автозапчастей</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- Навигационное меню --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">AutoParts</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Каталог</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Контакты</a></li>
                <li class="nav-item"><a class="nav-link btn btn-primary text-white ml-2" href="#">Корзина</a></li>
            </ul>
        </div>
    </nav>

    {{-- Баннер --}} @section('admin-page')
    <div class="jumbotron text-center bg-light mt-3">
        <h1 class="display-4">Добро пожаловать в AutoParts!</h1>
        <p class="lead">Качественные автозапчасти для вашего автомобиля по лучшим ценам.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Каталог товаров</a>
    </div>
    @endsection
    {{-- Категории --}}
    <div class="container">
        <h2 class="text-center my-4">Популярные категории</h2>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Двигатели">
                    <div class="card-body">
                        <h5 class="card-title">Двигатели</h5>
                        <a href="#" class="btn btn-primary">Смотреть</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Тормозные системы">
                    <div class="card-body">
                        <h5 class="card-title">Тормозные системы</h5>
                        <a href="#" class="btn btn-primary">Смотреть</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Подвеска">
                    <div class="card-body">
                        <h5 class="card-title">Подвеска</h5>
                        <a href="#" class="btn btn-primary">Смотреть</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Электроника">
                    <div class="card-body">
                        <h5 class="card-title">Электроника</h5>
                        <a href="#" class="btn btn-primary">Смотреть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Популярные товары --}}
    <div class="container my-5 mb-5">
        <h2 class="text-center my-4">Популярные товары</h2>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }} ₽</p>
                            <a href="#" class="btn btn-primary">Купить</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Футер --}}
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 AutoParts. Все права защищены.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
