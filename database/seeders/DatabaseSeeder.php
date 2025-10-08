<?php

namespace Database\Seeders;

use App\Models\Assignments;
use App\Models\Courses;
use App\Models\CourseStudent;
use App\Models\Discussions;
use App\Models\Materials;
use App\Models\Replies;
use App\Models\Submissions;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        $dosen =  User::factory()->create([
            'name' => 'dosen',
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
        ]);

        $mahasiswa =  User::factory()->create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

     
        Courses::factory(1)->create();
        CourseStudent::factory(1)->create();
        Materials::factory(1)->create();
        Assignments::factory(1)->create();
        Submissions::factory(1)->create();
        Discussions::factory(1)->create();
        Replies::factory(1)->create();
    }
}
