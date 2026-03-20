<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SaleItem extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('sale_item');
        $table->addColumn('sale_id', 'integer')
              ->addColumn('product_id', 'integer')
              ->addColumn('quantity', 'integer')
              ->addColumn('price_at_sale', 'decimal', ['precision' =>10, 'scale' => 2])
              ->addColumn('is_deleted', 'boolean', ['default' =>false])
              ->addForeignKey('sale_id', 'sale', 'id', ['delete'=> 'CASCADE'])
              ->addForeignKey('product_id', 'product', 'id')

              ->create();
    }
}
