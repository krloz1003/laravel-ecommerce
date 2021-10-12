<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User;
        $user->name     = 'admin';
        $user->email    = 'admin@mail.com';
        $user->password = \Hash::make('admin');
        $user->save();

        factory(App\User::class, 10)->create();
        factory(App\Product::class, 10)->create();
        //App\Models\Product::factory()->count(50)->create();
    }
}
