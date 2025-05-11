

function showCart(cart) {
    $("#cart-modal .modal-body").html(cart);
    $("#cart-modal").modal();
    let cartQty = $("#modal-cart-qty").text() ? $("#modal-cart-qty").text() : 0;
    $(".mini-cart-qty").text(cartQty);
    console.log(cartQty);

    if (cartQty) {
        $("#cart-modal .modal-footer button.btn-cart").removeClass("d-none");
    } else {
        $("#cart-modal .modal-footer button.btn-cart").addClass("d-none");
    }
    if (cartQty > 0) {
        $("#cart-modal .modal-footer a.btn-cart").removeClass("d-none");
    } else {
        $("#cart-modal .modal-footer a.btn-cart").addClass("d-none");
    }
}

function showCount(cart) {
    $("#cart-modal .modal-body").html(cart);
    let cartQty = $("#modal-cart-qty").text() ? $("#modal-cart-qty").text() : 0;
    $(".mini-cart-qty").text(cartQty);
    $("#liveToast").fadeIn(500, () => {
        setTimeout(()=> {
            $("#liveToast").fadeOut()
        },3000)
    });
}

function clearCart(action) {
    $.ajax({
        url: action,
        type: "get",
        success: function (result) {
            let now_location = document.location.pathname;
            if (now_location == '/cart/checkout') {
                location = '/cart/checkout';
            } else {
                showCart(result)
            }
        },
        error: function () {
            alert("Error");
        },
    });
}

function getCart(action) {
    $.ajax({
        url: action,
        type: "get",
        success: function (result) {
            showCart(result);
        },
        error: function () {
            alert("Error");
        },
    });
}

$(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $('.navbar').addClass('navbar-shrink');
    } else {
        $('.navbar').removeClass('navbar-shrink');
    }
});

$(function () {
    $(".addtocart").on("submit", function () {
        let form = $(this);
        $.ajax({
            url: form.attr("action"),
            data: form.serialize(),
            type: "post",
            success: function (result) {
                showCount(result);
            },
            error: function (msg) {
                alert("Error!");
                console.log(msg.responseJSON);
                form[0].reset();
            },
        });
        return false;
    });

    $("#cart-modal .modal-body").on("click", ".del-item", function () {
        $.ajax({
            url: $(this).data("action"),
            type: "get",
            success: function (result) {
                let now_location = document.location.pathname;
                if (now_location == '/cart/checkout') {
                    location = '/cart/checkout';
                } else {
                    showCart(result)
                }
            },
            error: function (msg) {
                alert("Error!");
            },
        });
    });
    $("#order-product").on("click", ".del-item", function () {
        $.ajax({
            url: $(this).data("action"),
            type: "get",
            success: function (result) {
                let now_location = document.location.pathname;
                if (now_location == '/cart/checkout') {
                    location = '/cart/checkout';
                } else {
                    showCart(result)
                }
            },
            error: function (msg) {
                alert("Error!");
            },
        });
    });
});

$(document).ready(function() {
    $('.order-details-btn').click(function() {
        const orderId = $(this).data('order-id');
        $('#orderId').text(orderId);
        
        // Получаем данные строки заказа
        const row = $(this).closest('tr');
        $('#orderDate').text(row.find('td:nth-child(2)').text());
        $('#orderTotal').text(row.find('td:nth-child(3)').text().trim().replace(' ₽', ''));
        $('#orderName').text(row.find('td:nth-child(4) div').text());
        $('#orderNote').text(row.find('td:nth-child(4) small').text() || '—');
        $('#orderEmail').text(row.find('td:nth-child(5) div:first-child a').text());
        $('#orderPhone').text(row.find('td:nth-child(5) div:last-child a').text());
        $('#orderAddress').text(row.find('td:nth-child(6)').text());
        
        // Клонируем статус
        const statusBadge = row.find('td:nth-child(7) span').clone();
        $('#orderStatus').empty().append(statusBadge);
        
        // Загружаем товары через AJAX
        $.get(`/orders/${orderId}/products`, function(data) {
            const tbody = $('#orderProductsTable tbody');
            tbody.empty();
            
            data.products.forEach(product => {
                tbody.append(`
                    <tr>
                        <td>${product.name}</td>
                        <td>${product.price.toFixed(2).replace('.', ',')} ₽</td>
                        <td>${product.quantity}</td>
                        <td>${(product.price * product.quantity).toFixed(2).replace('.', ',')} ₽</td>
                    </tr>
                `);
            });
            
            // Добавляем итого
            tbody.append(`
                <tr class="font-weight-bold">
                    <td colspan="3" class="text-right">Итого:</td>
                    <td>${data.total.toFixed(2).replace('.', ',')} ₽</td>
                </tr>
            `);
        });
    });
    
    $('#printOrderBtn').click(function() {
        window.print();
    });
});

