<?php

use Illuminate\Database\Seeder;

class AddUsersToUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.pl',
            'password' => bcrypt('765uyt4321'),
            'type' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Jan',
            'surname' => 'Kowalski',
            'email' => 'jan@kowalski.pl',
            'password' => bcrypt('765uyt4321'),
            'type' => 0
        ]);
    }
}
