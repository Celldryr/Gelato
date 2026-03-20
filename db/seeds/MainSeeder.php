<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class MainSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        //insertar datos en tabla usuarios
        // usuario creado
        $user = $this->table('users');
        $user->insert([[
            'name' => 'admin',
            'password' =>password_hash('1234', PASSWORD_BCRYPT),
            'role' => 'admin',
            'is_deleted' => false
        ]])->saveData();
        // productos de prueva
        $product = $this->table('product');
        $product->insert([
            ['sku' => '001', 'name' => 'Producto A', 'price' => 10.50, 'is_deleted' => false],
            ['sku' => '002', 'name' => 'Producto B', 'price' => 5.00, 'is_deleted' => false],
            ['sku' => '003', 'name' => 'Producto C', 'price' => 20.00, 'is_deleted' => false],
        ])->saveData();
    }
}
