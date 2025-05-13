<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_product_index()
    {
        // Создаём несколько продуктов в базе данных
        \App\Models\Product::factory(5)->create();

        // Запрашиваем главную страницу с продуктами
        $response = $this->get('/');

        // Проверяем успешный ответ и что в ответе присутствуют данные о продуктах
        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    public function test_product_search()
    {
        // Создаём несколько продуктов для поиска
        $product1 = \App\Models\Product::factory()->create(['title' => 'Test Product 1']);
        $product2 = \App\Models\Product::factory()->create(['title' => 'Test Product 2']);

        // Запрашиваем поиск по запросу
        $response = $this->get('/search?query=Test');

        // Проверяем успешный ответ и что возвращаются оба продукта
        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertSee($product1->title);
        $response->assertSee($product2->title);
    }

    public function test_admin_can_view_products_index()
    {
        // Создаём администратора
        $admin = \App\Models\User::factory()->create([
            'is_admin' => '1'
        ]);

        // Авторизуем администратора
        $this->actingAs($admin);

        // Создаём несколько продуктов в базе данных
        \App\Models\Product::factory(5)->create();

        // Запрашиваем административную страницу
        $response = $this->get('/admin');

        // Проверяем, что страница загружается и отображаются продукты
        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    public function test_admin_can_create_product()
    {
        // Создаём администратора
        $admin = \App\Models\User::factory()->create([
            'is_admin' => '1'
        ]);

        // Авторизуем администратора
        $this->actingAs($admin);

        // Создаём категорию для продукта
        $category = \App\Models\Category::factory()->create();

        // Делаем POST-запрос для создания нового продукта
        $response = $this->post('/admin/store/', [
            'title' => 'New Product',
            'category_id' => $category->id,
            'price' => 100,
            'hit' => 1,
            'sale' => 0,
            'status_id' => 1,
        ]);

        // Проверяем редирект на страницу с продуктами и что продукт был добавлен
        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('products', ['title' => 'New Product']);
    }

    public function test_admin_can_update_product()
    {
        // Создаём администратора
        $admin = \App\Models\User::factory()->create([
            'is_admin' => 1
        ]);

        // Авторизуем администратора
        $this->actingAs($admin);

        // Создаём продукт для обновления
        $product = \App\Models\Product::factory()->create();

        // Делаем PUT-запрос для обновления данных продукта
        $response = $this->post("/admin/update/{$product->id}", [
            'title' => 'Updated Product',
            'category_id' => $product->category_id,
            'price' => 200,
            'hit' => 1,
            'sale' => 0,
            'status_id' => 1,
        ]);

        // Проверяем редирект и что данные продукта были обновлены
        $response->assertRedirect('/');
        $this->assertDatabaseHas('products', ['title' => 'Updated Product']);
    }

    public function test_admin_can_delete_product()
    {
        // Создаём администратора
        $admin = \App\Models\User::factory()->create([
            'is_admin' => 1
        ]);

        // Авторизуем администратора
        $this->actingAs($admin);

        // Создаём продукт для удаления
        $product = \App\Models\Product::factory()->create();

        // Делаем DELETE-запрос для удаления продукта
        $response = $this->post("/admin/destroy/{$product->id}");

        // Проверяем редирект и что продукт был удалён из базы данных
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
