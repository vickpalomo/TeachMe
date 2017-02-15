<?php

use Faker\Generator;
use TeachMe\Entities\User;
use Faker\Factory as Faker;

/**
* Para cargar datos en la bd
*/
class UserTableSeeder extends BaseSeeder
{
  public function getModel()
  {
    return new User();
  }

  public function getDummyData(Generator $faker, array $customValues = array())
  {
    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt('admin')
      ];
  }

  public function run()
  {
    $this->createAdmin();
    $this->createMultiple(50);
  }

  public function createAdmin()
  {
    $this->create([
        'name' => 'Victor',
        'last_name' => 'Palomo',
        'email' => 'ing.victorpalomo@gmail.com',
        'password' => bcrypt('admin')
      ]);

  }
}