<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{

    private function getInitialImageList() {
        $data = file_get_contents(base_path() . '/database/products/products.json');
        $data = json_decode($data, true);

        $category = $data['categories'][fake()->numberBetween(0, 2)];
        $subcategory = $category['subcategories'][fake()->numberBetween(0, count($category['subcategories'])-1)];
        return $subcategory['products'][fake()->numberBetween(0, count($subcategory['products'])-1)];
    }
    
    private function checkMainImage($productId) {
        return Image::where('product_id', $productId)->exists();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = $this->getInitialImageList();
        // $productId = Product::where('name', $product['name'])->value('id');
        // $main = $this->checkMainImage($product->id);


        return [
            'name' => $product['name'],
            'path' => $product['image'],
            'main' => false,
            'product_id' => 0
        ];
    }

}
