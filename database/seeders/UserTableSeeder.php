<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int) $this->command->ask('How many Rows Do you want', 5);
        $hanuman = User::factory()->createhanuman()->create();
        $users = User::factory($userCount)->create(); 
    }
}
