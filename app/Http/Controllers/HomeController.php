<?php

namespace App\Http\Controllers;

use App\User;
use App\Question;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getQuestions(Request $request)
    {

        if($request->ajax())
        {

            if($search = $request->q) {
                $questions_resource = Question::where(function($query) use ($search) {
                    $query->where('title','LIKE',"%$search%")
                          ->orWhere('description','LIKE',"%$search%");
                })->paginate(20)->toArray();
            } else {
                $questions_resource = Question::latest()->paginate(20)->toArray();
            }

            if(count($questions_resource['data']) === 0) {
                return response()->json(['questions' => false]);
            }

            $categories = Category::all()->keyBy('id')->toArray();

            $questions = [];
            $question_author_ids = [];
            foreach ($questions_resource['data'] as $question_key => $question) {
               
                //$question['answers_num'] = Answer::where('for', $question['id'])->get()->count();
                $questions[] = $question;

                $question_author_ids[$question['id']] = $question['author'];
                
            }

            $authors = User::whereIn('id', $question_author_ids)->get()->keyBy('id')->toArray();

            return response()->json([
                'questions'             => $questions,
                'categories'            => $categories,
                'question_author_ids'   => $question_author_ids,
                'authors'               => $authors
            ]);
            
        }

    }
}
