<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class StockMovements extends AbstractMigration
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
        $table = $this->table('stock_movements');
        
        $table->addColumn('product_id', 'integer')
              ->addColumn('user_id', 'integer')
              ->addColumn('type', 'string', ['limit' => 10]) // 'ENTRADA', 'SALIDA' o 'AJUSTE'
              ->addColumn('quantity', 'integer')
              ->addColumn('reason', 'string', ['limit' => 255, 'null' => true]) // Ej: "Venta #101" o "Dañado"
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              
              ->addForeignKey('product_id', 'product', 'id', [
                  'delete'=> 'RESTRICT', 
                  'update'=> 'CASCADE'
              ])
              
              ->addForeignKey('user_id', 'users', 'id', [
                  'delete'=> 'RESTRICT', 
                  'update'=> 'CASCADE'
              ])
              
              ->create();
    }
}
