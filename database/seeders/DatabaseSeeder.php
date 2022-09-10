<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        if($this->command->confirm('Do you want refresh Database'))
        {
            $this->command->call('migrate:refresh');
            $this->command->info('Database refreshed');
            return;
        }
        $this->call([
            UserTableSeeder::class,
            BlogPostTableSeeder::class,
            CommenTableSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagSeeder::class,
        ]);
    }
}
