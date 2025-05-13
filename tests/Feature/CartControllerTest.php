<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_adds_product_to_cart()
    {
        $product = Product::factory()->create(['price' => 100]);

        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'qty' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('cart.cart-modal');
        $this->assertEquals(2, session("cart.{$product->id}.qty"));
        $this->assertEquals(2, session('cart_qty'));
        $this->assertEquals(200, session('cart_total'));
    }

    public function test_add_product_validation_error()
    {
        $response = $this->post('/cart/add', [
            'product_id' => '', // пусто
            'qty' => 0, // недопустимое значение
        ]);

        $response->assertSessionHasErrors(['product_id', 'qty']);
    }

    public function test_delete_item_from_cart()
    {
        $product = Product::factory()->create(['price' => 50]);

        // Добавляем сначала
        $this->post('/cart/add', [
            'product_id' => $product->id,
            'qty' => 3,
        ]);

        $response = $this->get("/cart/del-item/{$product->id}");

        $response->assertStatus(200);
        $response->assertViewIs('cart.cart-modal');
        $this->assertFalse(session()->has("cart.{$product->id}"));
        $this->assertEquals(0, session('cart_qty'));
        $this->assertEquals(0, session('cart_total'));
    }

    public function test_clear_cart()
    {
        session([
            'cart' => ['dummy'],
            'cart_qty' => 5,
            'cart_total' => 100,
        ]);

        $response = $this->get('/cart/clear');

        $response->assertStatus(200);
        $response->assertViewIs('cart.cart-modal');
        $this->assertFalse(session()->has('cart'));
        $this->assertFalse(session()->has('cart_qty'));
        $this->assertFalse(session()->has('cart_total'));
    }

    public function test_checkout_get_returns_view()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/cart/checkout');

        $response->assertStatus(200);
        $response->assertViewIs('cart.checkout');
    }

    public function test_checkout_post_valid_data_creates_order()
    {
        $user = \App\Models\User::factory()->create();

        $product = Product::factory()->create(['price' => 150]);

        // Добавим товар в сессию
        session([
            "cart" => [
                $product->id => [
                    'product_id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'img' => 'dummy.jpg',
                    'qty' => 2,
                ],
            ],
            "cart_qty" => 2,
            "cart_total" => 300,
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/cart/checkout', [
                'name' => 'Иван',
                'email' => 'ivan@example.com',
                'phone' => '1234567890',
                'address' => 'Test street 1',
            ]);

        $response->assertRedirect('/cart/checkout');
        $response->assertSessionHas('success', 'Заказ оформлен');

        $this->assertDatabaseHas('orders', [
            'email' => 'ivan@example.com',
            'qty' => 2,
            'total' => 300,
        ]);

        $this->assertFalse(session()->has('cart'));
        $this->assertFalse(session()->has('cart_qty'));
        $this->assertFalse(session()->has('cart_total'));
    }

    public function test_checkout_post_fails_validation()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/cart/checkout', [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
            ]);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'address']);
    }

    public function test_orders_only_returns_user_orders()
    {
        $user = User::factory()->create(['email' => 'user1@example.com']);
        $otherUser = User::factory()->create(['email' => 'user2@example.com']);

        Order::factory()->create(['email' => $user->email]);
        Order::factory()->create(['email' => $otherUser->email]);

        $response = $this->actingAs($user)->get('/orders');

        $response->assertStatus(200);
        $response->assertViewIs('cart.orders');
        $response->assertSee('user1@example.com');
        $response->assertDontSee('user2@example.com');
    }
}
