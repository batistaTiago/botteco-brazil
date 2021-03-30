<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function products_can_be_listed()
    {
        // $this->withoutExceptionHandling();

        $count = 5;

        Product::factory()->count($count)->create();

        $response = $this->get(
            route('api.v1.products.index'),
            $this->headers
        )->assertStatus(200);

        $json = $response->decodeResponseJson();

        $this->assertIsArray($json['data']);
        $this->assertCount($count, $json['data']);

    }

    /** @test */
    public function a_product_can_be_created()
    {

        $this->withoutExceptionHandling();

        $attributes = Product::factory()->raw();

        $this->assertDatabaseMissing('products', $attributes);

        $response = $this->post(
            route('api.v1.products.store'),
            $attributes,
            $this->headers
        )->assertStatus(200);

        $this->assertDatabaseHas('products', $attributes);
    }

    /** @test */
    public function a_product_can_be_created_validation()
    {
        /* @TODO: usar um data provider */
        $this->withoutExceptionHandling([
            ValidationException::class,
        ]);
        $attributes = Product::factory()->raw();

        $this->assertDatabaseCount('products', 0);

        $this->post(
            route('api.v1.products.store'),
            array_merge($attributes, ['name' => '']),
            $this->headers
        )->assertStatus(422);
        $this->assertDatabaseMissing('products', $attributes);

        $this->post(
            route('api.v1.products.store'),
            array_merge($attributes, ['price' => 'abc']),
            $this->headers
        )->assertStatus(422);
        $this->assertDatabaseMissing('products', $attributes);

        $this->post(
            route('api.v1.products.store'),
            array_merge($attributes, ['product_category_id' => 'csd']),
            $this->headers
        )->assertStatus(422);
        $this->assertDatabaseMissing('products', $attributes);

        $this->assertDatabaseCount('products', 0);
        $this->post(
            route('api.v1.products.store'),
            array_merge($attributes, ['description' => '']),
            $this->headers
        )->assertStatus(200);
        $this->assertDatabaseCount('products', 1);

        $this->post(
            route('api.v1.products.store'),
            array_merge($attributes, ['description' => 'etc']),
            $this->headers
        )->assertStatus(200);
        $this->assertDatabaseCount('products', 2);

        $this->post(
            route('api.v1.products.store'),
            array_merge($attributes, ['ingredients' => 'etc']),
            $this->headers
        )->assertStatus(200);
        $this->assertDatabaseCount('products', 3);
    }

    /** @test */
    public function a_product_can_be_updated()
    {
        /* @TODO: separar esse teste em varios, um pra cada regra */
        $this->withoutExceptionHandling();

        $product = Product::factory()->create();

        $update_data = [
            'name' => 'changed',
            'price' => '420',
            'description' => 'changed!!',
            'product_category_id' => ProductCategory::factory()->create()->id,
            'ingredients' => json_encode([
                $this->faker->sentence(), 
                $this->faker->sentence(), 
            ])
        ];

        $response = $this->patch(
            route('api.v1.products.update', $product->id),
            $update_data,
            $this->headers
        )->assertStatus(200);

        $expected = array_merge(['id' => $product->id], $update_data);

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', $expected);
    }

    /** @test */
    public function a_product_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $product = Product::factory()->create();
        $this->assertDatabaseCount('products', 1);

        $response = $this->delete(
            route('api.v1.products.delete', $product->id),
            [],
            $this->headers
        )->assertStatus(200);

        $this->assertDatabaseCount('products', 0);
    }
}
