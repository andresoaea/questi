<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     *  Store likes/dislikes in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $reactions = [];
        $model = $request->type === 'question' ? 'App\Question' : 'App\Answer';
        $query = $model::where('id', $request->for)->value('reactions');

        if(!empty($query)) {
            $reactions = json_decode($query, true);
        }
       
        $reactions[$request->reaction][] = Auth::id();
        $model::where('id', $request->for)->update(['reactions' => json_encode($reactions)]);
    }

    /**
     *  Get likes/dislikes for specific question
     *
     * @param  int  $question_id
     * @param  int  $current_user
     * @return \Illuminate\Http\Response
     */
    public function show($question_id, $current_user = null)
    {
        $reactions = \App\Question::where('id', $question_id)->value('reactions');

        $reactions = json_decode($reactions, true);

        if(!empty($current_user)) {
            $is_liked = !empty($reactions['like']) ? in_array($current_user, $reactions['like']) : false;
            $is_disliked = !empty($reactions['dislike']) ? in_array($current_user, $reactions['dislike']) : false;
        }
        
        $reactions = [
            'likes'    => !empty($reactions['like']) ? count($reactions['like']) : 0,
            'dislikes' => !empty($reactions['dislike']) ? count($reactions['dislike']) : 0,
        ];

        $response = ['reactions'  => $reactions];

        if(!empty($current_user)) {
            $response['isLiked']    = $is_liked;
            $response['isDisliked'] = $is_disliked;
        }

        return response()->json($response);
    }

    /**
     *  Delete like/dislike from database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response     
     */
    public function delete(Request $request)
    {

        $model = $request->type === 'question' ? 'App\Question' : 'App\Answer';

        $reactions = $model::where('id', $request->for)->value('reactions');
        $reactions = json_decode($reactions, true);

        $array = $reactions[$request->reaction];

        if (($key = array_search(Auth::id(), $array)) !== false) {
            unset($array[$key]);
        }

        $reactions[$request->reaction] = $array;

        $model::where('id', $request->for)->update(['reactions' => json_encode($reactions)]);

    }
}
