<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'status' => 1,
            'title' => 'Laravel 12 API Sanctum',
            'content' => 'Laravel 12 API Sanctum',
            'slug' => 'laravel-12-api-sanctum',
            'path'=> '',
            'fc' => Carbon::now(),
            'user_id'=> 1,
        ]);

        Post::create([
            'status' => 1,
            'title' => 'Angular 19 Front de Sistemas',
            'content' => 'Angular 19 Front de Sistemas',
            'slug' => 'angular-19-front-de-sistemas',
            'path'=> '',
            'fc' => Carbon::now(),
            'user_id'=> 1,
        ]);

        Post::create([
            'status' => 1,
            'title' => 'Windows y Linux dualboot',
            'content' => 'Windows y Linux dualboot',
            'slug' => 'windows-y-linux-dualboot',
            'path'=> '',
            'fc' => Carbon::now(),
            'user_id'=> 1,
        ]);

        Post::create([
            'status' => 1,
            'title' => 'API Laravel 12 & Angular 19',
            'content' => 'API Laravel 12 & Angular 19',
            'slug' => 'api-laravel-12-angular-19',
            'path'=> '',
            'fc' => Carbon::now(),
            'user_id'=> 1,
        ]);
    }
}
