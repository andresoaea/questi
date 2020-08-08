<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	protected $appends = ['answers_count', 'full_url', 'category_slug'];

    protected $fillable = [
    	'title', 'slug', 'description', 'category', 'author', 'reactions', 'best_answer'
    ];


    public function user() {
        return $this->belongsTo('App\User', 'author', 'id');
    }

    public function answers() {
        return $this->hasMany('App\Answer', 'for', 'id');
    }

    public function answersCount() 
    {
    	 return Answer::whereFor($this->id)->count();
    }


    public function getAnswersCountAttribute()
    {
    	return $this->answersCount();
    }

    public function getCategorySlugAttribute()
    {
       
        try{
            $category_slug = Category::whereId($this->category)->pluck('slug')[0];
        } catch(\Exception $e) {
        $category_slug = 'uncategorized';    
        }

        return $category_slug;
    }


    public function getFullUrlAttribute() {
        return \URL::to("/{$this->category_slug}/{$this->slug}");
    }

}