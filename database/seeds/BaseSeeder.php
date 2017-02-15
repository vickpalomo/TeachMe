<?php

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Collection;

abstract class BaseSeeder extends Seeder 
{
  protected $total = 50;
  protected static $pool = array();

  public function run()
  {
    $this->createMultiple($this->total);
  }

  protected function createMultiple($total, array $customValues = array())
  {
    
    for ($i=0; $i <= $total; $i++) { 
      $this->create($customValues);
    }
  }

  abstract public function getModel();
  abstract public function getDummyData(Generator $faker, array $customValues = array());

  protected function create(array $customValues = array())
  {
    $values = $this->getDummyData(Faker::create(), $customValues);
    $values = array_merge($values, $customValues);
    return $this->addToPool($this->getModel()->create($values));
  }

  protected function createFrom($seeder, array $customValues = array())
  {
    $seeder = new $seeder;
    return $seeder->create($customValues);
  }

  protected function getRandom($model)
  {
    if( ! isset (static::$pool[$model])){
      throw new Exception("The $model colection does not exist");
    }

    return static::$pool[$model]->random();
  }

  private function addToPool($entity)
  {
    $reflection = new ReflectionClass($entity);
    $class = $reflection->getShortName();
 
    if( !isset(static::$pool[$class])){
      static::$pool[$class] = new Collection();
    }
    static::$pool[$class]->add($entity);

    return $entity;
  }
}