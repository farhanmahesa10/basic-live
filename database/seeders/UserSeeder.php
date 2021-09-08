<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'farhan',
            'email' => 'farhanmahesa10@gmail.com',
            'password' => bcrypt('1234'),
        ]);
        $user->assignRole('admin');
    }
}