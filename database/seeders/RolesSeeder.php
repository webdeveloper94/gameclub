<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin rolini qo'shish
        Role::firstOrCreate(['name' => 'Admin']);

        // User rolini qo'shish
        Role::firstOrCreate(['name' => 'User']);
    }
}
