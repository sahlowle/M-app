<?php

namespace Database\Factories;

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
        return [
            'name' => [
                'en' => 'name in en',
                'ar' => 'name in ar',
                'fr' => 'name in fr',
                'ur' => 'name in ur',
                'tr' => 'name in tr',
                'sw' => 'name in sw',
            ],
            
            'image' => 'files/categories_images/image.png'
        ];
    }
}
