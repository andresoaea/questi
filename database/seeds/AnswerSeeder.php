<?php

use App\User;
use App\Question;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->delete();

        $faker = \Faker\Factory::create();

        for($i=0; $i<=400; $i++):
        
            DB::table('answers')
                ->insert([
                    'text'        => $faker->paragraph,
                    'for'         => self::createRandomQuestionId(),
                    'author'      => self::createRandomUserId(),
                    'created_at'  => date("Y-m-d H:i:s"),
                    'updated_at'  => date("Y-m-d H:i:s")
                ]);
        endfor;

    }

    private static function createRandomQuestionId(){

        $questionsIds = array_map(function ($question) { return $question['id']; }, Question::all()->toArray());
        $randomNr = rand($questionsIds[0], $questionsIds[count($questionsIds)-1]);
    
        if(in_array($randomNr, $questionsIds)) {
            return $randomNr;
        } else {
            return self::createRandomQuestionId();
        }

    }

    private static function createRandomUserId(){

        $usersIds = array_map(function ($user) { return $user['id']; }, User::all()->toArray());
        $randomNr = rand($usersIds[0], $usersIds[count($usersIds)-1]);
    
        if(in_array($randomNr, $usersIds)) {
            return $randomNr;
        } else {
            return self::createRandomUserId();
        }

    }
}
