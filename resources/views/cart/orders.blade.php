@extends('layouts.layout')

@section('title', 'Мои заказы')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="section-title mb-0">Мои заказы</h1>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-2"></i>На главную
                    </a>
                </div>

                @if ($orders->isEmpty())
                    <div class="card border-0 shadow-sm admin-card empty-orders-card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h3 class="section-title">У вас пока нет заказов</h3>
                            <p class="text-muted">После оформления заказа вы сможете отслеживать его статус здесь</p>
                            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-shopping-cart mr-2"></i>Перейти в каталог
                            </a>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm admin-card">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover orders-table">
                                    <thead>
                                        <tr>
                                            <th class="col-order-id">№ Заказа</th>
                                            <th class="col-order-date">Дата</th>
                                            <th class="col-order-total">Сумма</th>
                                            <th class="col-order-name">Получатель</th>
                                            <th class="col-order-contacts">Контакты</th>
                                            <th class="col-order-address">Адрес</th>
                                            <th class="col-order-actions"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr data-order-id="{{ $order->id }}"
                                                data-order-date="{{ $order->created_at->format('d.m.Y H:i') }}"
                                                data-order-total="{{ number_format($order->total, 2, ',', ' ') }}"
                                                data-order-name="{{ $order->name }}" data-order-phone="{{ $order->phone }}"
                                                data-order-email="{{ $order->email }}"
                                                data-order-address="{{ $order->address }}"
                                                data-order-note="{{ $order->note ?? '' }}">
                                                <td data-label="№ Заказа">#{{ $order->id }}</td>
                                                <td data-label="Дата">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                                <td data-label="Сумма">{{ number_format($order->total, 2, ',', ' ') }} ₽
                                                </td>
                                                <td data-label="Получатель">
                                                    <div>{{ $order->name }}</div>
                                                    @if ($order->note)
                                                        <small class="text-muted">{{ $order->note }}</small>
                                                    @endif
                                                </td>
                                                <td data-label="Контакты">
                                                    <div><a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                                                    </div>
                                                    <div><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></div>
                                                </td>
                                                <td data-label="Адрес">{{ $order->address }}</td>
                                                <td data-label="Действия" class="text-right">
                                                    <button class="btn btn-sm btn-primary order-details-btn"
                                                        data-toggle="modal" data-target="#orderModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Модальное окно с деталями заказа -->
    <div class="modal fade order-modal" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Детали заказа #<span id="orderId"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Информация о заказе</h6>
                            <p><strong>Дата:</strong> <span id="orderDate"></span></p>
                            <p><strong>Сумма:</strong> <span id="orderTotal"></span> ₽</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Данные получателя</h6>
                            <p><strong>ФИО:</strong> <span id="orderName"></span></p>
                            <p><strong>Телефон:</strong> <span id="orderPhone"></span></p>
                            <p><strong>Email:</strong> <span id="orderEmail"></span></p>
                            <p><strong>Адрес:</strong> <span id="orderAddress"></span></p>
                            <p><strong>Комментарий:</strong> <span id="orderNote" class="font-italic"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="printOrderBtn">
                        <i class="fas fa-print mr-2"></i>Печать
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.order-details-btn').on('click', function() {
                var row = $(this).closest('tr');
                $('#orderId').text(row.data('order-id'));
                $('#orderDate').text(row.data('order-date'));
                $('#orderTotal').text(row.data('order-total'));
                $('#orderName').text(row.data('order-name'));
                $('#orderPhone').text(row.data('order-phone'));
                $('#orderEmail').text(row.data('order-email'));
                $('#orderAddress').text(row.data('order-address'));
                $('#orderNote').text(row.data('order-note') || 'Нет комментария');
            });

            $('#printOrderBtn').on('click', function() {
                var printContent = `
                    <h2>Детали заказа #${$('#orderId').text()}</h2>
                    <h3>Информация о заказе</h3>
                    <p><strong>Дата:</strong> ${$('#orderDate').text()}</p>
                    <p><strong>Сумма:</strong> ${$('#orderTotal').text()} ₽</p>
                    <h3>Данные получателя</h3>
                    <p><strong>ФИО:</strong> ${$('#orderName').text()}</p>
                    <p><strong>Телефон:</strong> ${$('#orderPhone').text()}</p>
                    <p><strong>Email:</strong> ${$('#orderEmail').text()}</p>
                    <p><strong>Адрес:</strong> ${$('#orderAddress').text()}</p>
                    <p><strong>Комментарий:</strong> ${$('#orderNote').text()}</p>
                `;
                var printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Печать заказа #${$('#orderId').text()}</title>
                            <style>
                                body { font-family: 'Noto Sans', sans-serif; margin: 20px; }
                                h2, h3 { color: #1a1a1a; }
                                p { margin: 5px 0; }
                                strong { font-weight: 500; }
                            </style>
                        </head>
                        <body>${printContent}</body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
            });
        });
    </script>
@endsection
