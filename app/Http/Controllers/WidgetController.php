<?php

namespace App\Http\Controllers;

// use QuestiConfig;
use App\Question;

class WidgetController extends Controller
{

	public static function getAllData()
	{

        // $widgets_needed = QuestiConfig::getUnserialized('widgets');
        $widgets_needed = [
           
                'add_new_question_button' => [
                    'not_standard_layout' => true
				],
				'site_stats' => [
					'title' => 'Statistics'
					// 'not_standard_layout' => true
				],
				'most_liked_questions' => [
					'title' => 'Most appreciated qustions'
				]
            
        ];

		$widgets = [];

		$default_widgets = [
			'add_new_question_button'   => 'addQuestionButtonHTML',
			'site_stats'                => 'siteStats',
			'most_liked_questions'      => 'mostLikedQuestions'
		];

		foreach ($widgets_needed as $widget_n_key => $widget_n_value) {

            

			if(array_key_exists($widget_n_key, $default_widgets)) {
			  
				$method = $default_widgets[$widget_n_key];
				$options = !empty($widget_n_value['options']) ? $widget_n_value['options'] : null;

				$widget = [
					'title' => !empty($widget_n_value['title']) ? $widget_n_value['title'] : null,
					'data'  => self::$method($options)
				];

				if(isset($widget_n_value['not_standard_layout'])) {
					$widget['not_standard_layout'] = true;
				}

				$widgets[$widget_n_key] = $widget;
				
			}
		}

		return $widgets;

	}

    public static function siteStats($options = null) 
    {

    	$stats = [];

    	$defaults = [
    		'users' => [
    				'model' => 'User',
    				'text'  => 'Users',
    				'icon'  => 'user',
    			],
    		'questions' => [
    				'model' => 'Question',
    				'text'  => 'Questions',
    				'icon'  => 'question',
    				
    			],
    		'answers' => [
    				'model' => 'Answer',
    				'text'  => 'Answers',
    				'icon'  => 'reply-all',
    			],
    		'best_answers' => [
    			    'model' => 'Question',
    				'text'  => 'Best Answers',
    				'icon'  => 'star',
    			]		

    	];

    	foreach ($defaults as $what => $default) {

    		if(isset($options['show']) && !in_array($what, $options['show'])) {
    			continue;
    		}

    		$model = 'App\\' . $default['model'];
    		$stats[$what] = [
    			'text'   => !empty($options[$what]['text']) ? $options[$what]['text'] : $default['text'],
    			'icon'   => $default['icon'],
    			'number' => $what === 'best_answers' ? $model::whereNotNull('best_answer')->count() : $model::count()
    		];
		}

    	return $stats;

    }

    public static function mostLikedQuestions($options = null)
    {
    	$number = isset($options['number']) ? $options['number'] : 4;

		$questions = Question::where('reactions->like', '!=', '0')
							  ->orderBy('reactions->like', 'ASC')
							  ->take($number)
							  ->get()
							  ->makeHidden(['id', 'category', 'best_answer', 'description', 'author', 'created_at', 'updated_at', 'answers_count', 'category_slug', 'slug'])
							  ->toArray();

    	return $questions;

	}

	

	public static function addQuestionButtonHTML()
	{

		if(\Request::route()->getName() !== 'addQuestion') {
			$html = '<a href="' . route('addQuestion') . '">Ask a question</a>';
		} else {
			$html = '<!-- Fix for first widget spacing -->
			<div style="position:relative; top:0; margin-top: -30px;"></div>';
		}

		return ['html' => $html];

	}

}