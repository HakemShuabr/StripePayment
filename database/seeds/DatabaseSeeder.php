<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Eloquent::unguard();
        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');
        $this->call('RoleTableSeeder');
        $this->command->info('Role table seeded!');
    }

}

class UserTableSeeder extends Seeder
{
    public function run() {
        DB::table('users')->delete();
        \App\User::create(array(
            'email'    => 'joe.bloggs@example.com',
            'name'     => 'Joe Bloggs',
            'password' => Hash::make('password')
        ));
    }

}

class RoleTableSeeder extends Seeder
{
    public function run() {
        DB::table('user_roles')->delete();
        \App\UserRole::create(array('name' => 'admin'));
        \App\UserRole::create(array('name' => 'pending'));
        \App\UserRole::create(array('name' => 'member'));
        \App\UserRole::create(array('name' => 'bronze'));
        \App\UserRole::create(array('name' => 'silver'));
        \App\UserRole::create(array('name' => 'gold'));
    }
}