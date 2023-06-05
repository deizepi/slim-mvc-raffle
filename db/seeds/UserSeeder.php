<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
        // password: P3dro<3
        $rows = [
            [
                'id' => 1,
                'name'  => 'David Deizepi Rocha',
                'email' => 'david_deizepi@hotmail.com',
                'password' => '$2y$10$wv/C/od7eGV6cOgpSVh7TO1KjRwgLfNcROZ1rtXOz1fTR3rU88iLC'
            ]
        ];

        $this->table('user')
            ->insert($rows)
            ->save();
    }
}
