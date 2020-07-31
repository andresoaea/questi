<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Answer;
use Illuminate\Http\Request;
use App\Http\Requests\AddAnswerRequest as AddAnswerRequest;
//use App\Http\Resources\Answer as AnswerResource;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $question_id)
    {
       // AnswerResource::withoutWrapping();
        // if(!$request->ajax()) {
        //     return;
        // }

        $answers = Answer::where('for', $question_id)
                    ->orderBy('created_at', 'desc')
                    ->get()->toArray();
        $answer_author_ids = array_column($answers, 'author');

        $authors = User::whereIn('id', $answer_author_ids)->get()->keyBy('id')->toArray();
        $authors = array_map(function($author) {
            unset($author['email'], $author['created_at'], $author['updated_at']);
            return $author;
        }, $authors);

       // dd();



       // dd($answers_authors);
        // $answers_authors = User::

        //return new AnswerResource((object) [$authors, $answers]);
        return response()->json([
            'answers' => $answers,
            'authors' => $authors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddAnswerRequest $request)
    {
        // Validate user answer
        // $data = $request->validate([
        //     'text'  => 'required',
        //     'for'   => 'required|int'
        // ]);

        $data = $request->validated();

        // Add exta information
        $data['author'] = Auth::id();

        // Save answer in database
       $answer = Answer::create($data);

       return response()->json(['answer' => $answer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
