<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

	// protected $appends = ['test'];

    protected $fillable = [
    	'for', 'author', 'text'
    ];


    public function getRelatedQuestionAttribute()
    {
    	return $this->relatedQuestion();
    }

    public function getRelatedAuthorAttribute()
    {
    	return $this->relatedAuthor();
    }

   	public function relatedQuestion()
   	{
   		return Question::find($this->for, ['slug', 'title', 'author', 'category'])
				   		->append('category_slug')
				   		->makeHidden('answers_count');
				   		
   	}

   	public function relatedAuthor()
   	{
   		return User::whereId($this->related_question->author)->get(['firstname', 'lastname', 'picture', 'fbid'])[0];
   	}

}