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
                ]
            
        ];

		$widgets = [];

		$default_widgets = [
			'add_new_question_button'   => null,
			'site_stats'                => 'siteStats',
			'most_liked_questions'      => 'mostLikedQuestions'
		];

		foreach ($widgets_needed as $widget_n_key => $widget_n_value) {

            

			if(array_key_exists($widget_n_key, $default_widgets)) {
              

				if(isset($widget_n_value['not_standard_layout'])) {
					$widgets[$widget_n_key] = $widget_n_value;
					continue;
				}

				$method = $default_widgets[$widget_n_key];
				$options = !empty($widget_n_value['options']) ? $widget_n_value['options'] : null;

				$widgets[$widget_n_key] = [
					'title' => $widget_n_value['title'],
					'data'  => self::$method($options)
				];
			}
		}


		// foreach ($default_widgets as $widget_key => $widget_data) {
		// 	$widgets[$widget_key] = self::$widget_data();
		// }

	

		return $widgets;

	}

    public static function siteStats($options = null) 
    {

    	$stats = [];
    	// $models = [ 'users' => 'User', 'questions' => 'Question', 'answers' => 'Answer'];
    	// $texts = [ 'users' => 'Users', 'questions' => 'Questions', 'answers' => 'Answers' ];

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

    	$questions = Question::orderBy('reactions->like', 'DESC')->take($number)->get()->toArray();

    	return $questions;

    }

}