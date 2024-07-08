<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $arr = [
            Category::SERVICE_TYPE,
            Category::SERVICE_TYPE,
            Category::SERVICE_TYPE,
        ];

        return [
            'name' => [
                'en' => 'name in en',
                'ar' => 'name in ar',
                'fr' => 'name in fr',
                'ur' => 'name in ur',
                'tr' => 'name in tr',
                'sw' => 'name in sw',
            ],
            
            'type' => $arr[array_rand($arr)],


            'image' => 'files/categories_images/image.png'
        ];
    }
}
