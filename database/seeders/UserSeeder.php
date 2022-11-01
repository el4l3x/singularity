<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();

        $user->name = 'David';
        $user->username = 'el4l3x';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('!.D1am229tJl!.');
        $user->assignRole('Admin');

        $user->save();
        
        $user = new User();

        $user->name = 'Aylwin';
        $user->username = 'blackfire';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('11111111');
        $user->assignRole('Socio');

        $user->save();
        
        $user = new User();

        $user->name = 'Alexis';
        $user->username = 'negrito';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('11111111');
        $user->assignRole('Socio');

        $user->save();
    }
}
