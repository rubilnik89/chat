<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->delete();
        \App\User::create([
            'name' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin'),
            'is_admin' => true,
        ]);
    }
}
