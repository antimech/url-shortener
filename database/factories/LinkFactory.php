<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customOrRandom = fake()->boolean
            ? fake()->userName() . fake()->numberBetween(1, 100)
            : Str::random(8);
        $dateOrNull = fake()->boolean
            ? fake()->dateTimeBetween('-1 week', '+ 1 week')->format('Y-m-d')
            : null;

        return [
            'hash' => $customOrRandom,
            'link' => 'https://source.unsplash.com/collection/' . random_int(1, 50),
            'expired_at' => $dateOrNull,
        ];
    }
}
