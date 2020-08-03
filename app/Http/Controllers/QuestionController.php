<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Category;
use App\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all()->keyBy('id')->makeHidden(['id', 'slug'])->toArray();
        $categories = array_diff(array_combine(array_keys($categories), array_column($categories, 'name')), [null]);

       // return view('add-question', compact('categories'));

        \JavaScript::put([
            'categories' => array_map('strip_tags', $categories)
        ]);

        return view('add-question');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         if($request->ajax())
         {

            // Validate user question
            $data = $request->validate([
                'title'        => 'required|min:10|max:191|unique:questions',
                'category'     => 'required',
                'description'  => 'nullable'
            ]);

            
            // Add exta information
            $data['author'] = Auth::id();
            $data['slug'] = Str::slug($request->title, '-');

            // Save quoestion in database
            Question::create($data);

         }
         

        die();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category = null, $slug = null)
    {
        $question = Question::where('slug', $slug)->first()->makeHidden(['reactions'])->toArray();
        $category = Category::where('id', $question['category'])->value('name');
        $question['category'] = $category;
        $question_title = $question['title'];

        
        \JavaScript::put([
            'question'      => $question
            //'currentUser'   => Auth:: check() ? Auth::user()->makeHidden(['email', 'created_at', 'updated_at']) : false
        ]);

        return view('single-question', compact('question_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getQuestions(Request $request)
    {

       

        if($request->ajax())
        {

            if($request->type) {
                return $this->queryByType($request->type);
            } else {
                return $this->queryDefault($request);
            }      
            
        }

        die();

    }

    private function queryByType($type) {
        if($type === 'most-answered') {
             $questions_resource = Question::with('answers')                 
                            ->orderBy('answers_count', 'desc')   
                            ->withCount('answers')
                            ->having('answers_count', '>', 0)
                            ->paginate(20)
                            ->toArray();

            //  foreach ($questions_resource as $q) {
            //     echo $q->id . "\n";
            //     echo $q->answers_count . "\n";
            //     echo  "--------- \n";
            // }

         return $this->sendResponse($questions_resource);
        } 

        if($type === 'without-answer') {
            return '0 ans';
        }
    }

    private function queryDefault($request) {
        if($search = $request->q) {
            $questions_resource = Question::where(function($query) use ($search) {
                $query->where('title','LIKE',"%$search%")
                      ->orWhere('description','LIKE',"%$search%");
            })->paginate(20)->toArray();
        } else {
            $questions_resource = Question::latest()->paginate(20)->toArray();
        }

        return $this->sendResponse($questions_resource);
    }

    private function sendResponse($questions_resource) {

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