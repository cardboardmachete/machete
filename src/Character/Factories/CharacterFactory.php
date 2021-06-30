<?php

namespace Machete\Character\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Machete\Account\Models\Account;
use Machete\Character\Models\Character;

class CharacterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Character::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'is_active' => true,
            'account_id' => Account::factory(),
        ];
    }

    /**
     * Indicate that the Character should not be active.
     */
    public function inactive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
