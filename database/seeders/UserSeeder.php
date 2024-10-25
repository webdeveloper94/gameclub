<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // User modelini import qilish
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'tulkintakhirov@gmail.com',
            'password' => bcrypt('Aspire578'), // parolni shifrlash
        ]);

        
    }
}
