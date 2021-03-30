<?php

namespace Tests\Feature;

use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function product_categories_can_be_listed()
    {
        $this->withoutExceptionHandling();

        $count = 5;

        ProductCategory::factory()->count($count)->create();

        $response = $this->get(
            route('api.v1.product_categories.index'),
            $this->headers
        )->assertStatus(200);

        $json = $response->decodeResponseJson();

        $this->assertIsArray($json['data']);
        $this->assertCount($count, $json['data']);

    }

    /** @test */
    public function a_product_category_can_be_created()
    {
        $attributes = ProductCategory::factory()->raw();

        $this->assertDatabaseMissing('product_categories', $attributes);

        $response = $this->post(
            route('api.v1.product_categories.store'),
            $attributes,
            $this->headers
        )->assertStatus(200);

        $this->assertDatabaseHas('product_categories', $attributes);
    }

    /** @test */
    public function a_product_category_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $product = ProductCategory::factory()->create();

        $update_data = [
            'name' => 'changed...',
        ];

        $response = $this->patch(
            route('api.v1.product_categories.update', $product->id),
            $update_data,
            $this->headers
        )->assertStatus(200);

        $expected = array_merge(['id' => $product->id], $update_data);

        $this->assertDatabaseCount('product_categories', 1);
        $this->assertDatabaseHas('product_categories', $expected);
    }

    /** @test */
    public function a_product_category_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $product = ProductCategory::factory()->create();
        $this->assertDatabaseCount('product_categories', 1);

        $response = $this->delete(
            route('api.v1.product_categories.delete', $product->id),
            [],
            $this->headers
        )->assertStatus(200);

        $this->assertDatabaseCount('product_categories', 0);
    }
}
