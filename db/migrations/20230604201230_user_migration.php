<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserMigration extends AbstractMigration
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
        $this->table('user')
            ->addColumn('name', 'string')
            ->addColumn('email', 'string', [
                'null' => false
            ])
            ->addColumn('password', 'string', [
                'null' => false
            ])
            ->addColumn('active', 'boolean', [
                'null' => false,
                'default' => true
            ])
            ->addColumn('created_at', 'datetime',['default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime',['default'=>'CURRENT_TIMESTAMP'])
            ->create();
    }
}
