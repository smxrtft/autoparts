$(window).on('load', function() { // makes sure the whole site is loaded 
    $('#status').fadeOut(); // will first fade out the loading animation 
    $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
    $('body').delay(350).css({'overflow':'visible'});
  })

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
