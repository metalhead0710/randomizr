<?php

namespace Database\Factories;

use App\Models\FakeUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FakeUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FakeUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = $this->faker->unique()->numerify('000000####');
        return [
            'id' => "P-$id",
            'localisation1'=> strtoupper($this->faker->text(9)),
            'localisation2'=> strtoupper($this->faker->text(9)),
            'mail'=> $this->faker->unique()->safeEmail(),
            'department'=> $this->faker->word(),
            'nom_site1'=> $this->faker->words(3, true),
            'nom_site2'=> $this->faker->words(4, true),
            'sous_direction'=> $this->faker->sentence(5),
            'url_photo'=> asset('img/1.png'),
            'tupreduit'=> "PERSONNE",
            'pole'=> $this->faker->sentence(4),
            'salarie_rh'=> "0",
            'nom'=> $this->faker->firstName(),
            'prenom'=> $this->faker->lastName(),
            'idns'=> $id,
            'url_fiche' => $this->faker->imageUrl(),
            'fonction' => $this->faker->sentence(2),
            'direction' => $this->faker->sentence(2),
        ];
    }
}
