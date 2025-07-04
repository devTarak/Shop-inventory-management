<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use App\Models\ProductsModel;

class DummyProductSeeder extends Seeder
{
    protected $productsModel;
    public function run()
    {
        $this->productsModel = new ProductsModel();
        for ($i = 0; $i < 10; $i++) {
            $this->productsModel->insert($this->seedsProducts());
        }
    }
    public function seedsProducts(){
         $faker = Factory::create();
         return [
            'name' => $faker->words(3, true),
            'sku' => strtoupper($faker->lexify('??????')),
            'buying_price' => $faker->randomFloat(2, 50, 500),
            'quantity' => $faker->numberBetween(1, 100),
            'created_at' => date('Y-m-d H:i:s'),];
    }
}
