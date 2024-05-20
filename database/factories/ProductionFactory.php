<?php

namespace Database\Factories;

use App\Models\Batiment;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Production>
 */
class ProductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'datprd' => $this->faker->dateTimeThisMonth(),
            'zone_id' => Zone::all()->random()->id,
            'batiment_id' => Batiment::all()->random()->id,
            'agepou'=> $this->faker->numberBetween(1,3),
            'nbrpou'=> $this->faker->numberBetween(0,10000),
            'nbrcrt'=> $this->faker->numberBetween(100,300),
            'prdjrn'=> $this->faker->numberBetween(1000,1500000),
            'nbrcas'=> $this->faker->numberBetween(1,300),
            'nbrdcd'=> $this->faker->numberBetween(1,100),
            'cnsali'=> $this->faker->randomNumber(),
            'nbrsac'=> $this->faker->numberBetween(1,100),


        ];
    }
}
