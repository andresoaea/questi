<?php

use App\User;
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

        DB::table('questions')->delete();

        $faker = \Faker\Factory::create();

        for($i=0; $i<=100; $i++):
            $title = $faker->sentence;
            DB::table('questions')
                ->insert([
                    'title' => str_replace('.', '?', $title),
                    'description' => $faker->paragraph,
                    'slug' => \Str::slug($title, '-'),
                    'category' => 1, 
                    'author' => self::createRandomUserId(),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
        endfor;

    }

    private static function createRandomUserId(){

        $usersIds = array_map(function ($el) { return $el['id']; }, User::all()->toArray());
        $randomNr = rand($usersIds[0], $usersIds[count($usersIds)-1]);
    
        if(in_array($randomNr, $usersIds)) {
            return $randomNr;
        } else {
            return self::createRandomUserId();
        }

    }
}
