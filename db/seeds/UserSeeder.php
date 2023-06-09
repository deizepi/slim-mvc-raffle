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
        $rows = [
            [
                'id' => 1,
                'name'  => $_ENV["USER_NAME"],
                'email' => $_ENV["USER_EMAIL"],
                'password' => password_hash($_ENV["USER_PASSWORD"], PASSWORD_DEFAULT)
            ]
        ];

        $this->table('user')
            ->insert($rows)
            ->save();
    }
}
