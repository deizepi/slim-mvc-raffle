<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class BuyerRaffleMigration extends AbstractMigration
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
        $this->table('buyer_raffle')
            ->addColumn('buyer_id', 'integer', [
                'signed' => false
            ])
            ->addColumn('raffle_id', 'integer', [
                'signed' => false
            ])
            ->addColumn('number', 'integer', [
                'null' => false
            ])
            ->addColumn('created_at', 'datetime',['default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime',['default'=>'CURRENT_TIMESTAMP'])
            ->addForeignKey('buyer_id', 'buyer', 'id')
            ->addForeignKey('raffle_id', 'raffle', 'id')
            ->save();
    }
}
