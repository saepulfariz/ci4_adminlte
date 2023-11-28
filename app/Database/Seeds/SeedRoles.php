<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedRoles extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Administrator',
            ],
            [
                'title' => 'Member',
            ],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
