<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_show_displays_category_and_products()
    {
        $category = Category::factory()->create(['slug' => 'electronics']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get("/category/{$category->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
        $response->assertViewHasAll(['category', 'products', 'categories']);
        $response->assertSee($product->title);
    }

    public function test_show_applies_price_filter_and_sort()
    {
        $category = Category::factory()->create(['slug' => 'tech']);
        $cheap = Product::factory()->create(['category_id' => $category->id, 'price' => 100, 'title' => 'Cheap']);
        $expensive = Product::factory()->create(['category_id' => $category->id, 'price' => 999, 'title' => 'Expensive']);

        $response = $this->get("/category/{$category->slug}?min_price=500&sort=price_desc");

        $response->assertStatus(200);
        $response->assertSee('Expensive');
        $response->assertDontSee('Cheap');
    }

    public function test_admin_can_create_category()
    {
        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);

        $response = $this->post('/admin/store-category', [
            'title' => 'New Category',
            'slug' => 'new-category'
        ]);

        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('categories', ['title' => 'New Category']);
    }

    public function test_store_category_fails_validation()
    {
        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);

        $response = $this->post('/admin/store-category', [
            'title' => '' // Пустое поле
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_admin_can_update_category()
    {
        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);

        $category = Category::factory()->create(['title' => 'Old']);

        $response = $this->post("/admin/updatecat/{id}", [
            'id' => $category->id,
            'title' => 'Updated Category'
        ]);

        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('categories', ['title' => 'Updated Category']);
    }

    public function test_admin_can_delete_category()
    {
        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);

        $category = Category::factory()->create();

        $response = $this->post("/admin/destroycat/{$category->id}");

        $response->assertRedirect('/admin');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
