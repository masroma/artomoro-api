<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $save = new User();
        $save->name = 'Admin Toko Online';
        $save->email = 'admin@gmail.com';
        $save->password = bcrypt('password');
        $save->save();

    }
}
