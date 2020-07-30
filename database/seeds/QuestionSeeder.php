<?php

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

       

        for($i=0; $i<=50; $i++):
            $title = $faker->sentence;
            DB::table('questions')
                ->insert([
                    'title' => str_replace('.', '?', $title),
                    'description' => $faker->paragraph,
                    'slug' => \Str::slug($title, '-'),
                    'category' => 1, 
                    'author' => rand(1,2),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
        endfor;
    }
}
