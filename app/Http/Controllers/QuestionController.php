<?php

namespace App\Http\Controllers;

use Auth;
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
}