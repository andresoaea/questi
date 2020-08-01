<?php

namespace App\Http\Controllers\Admin;

use Lang;
use QuestiConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{

    protected static $lang;

    protected static $parent_string_key;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $lang = [];
        $files = ['auth', 'validation', 'pagination', 'passwords'];

        foreach($files as $file)
        {
            $lang[$file] = Lang::get($file, [], 'en-default');
        }

        $lang_strings = self::langStringsList($lang);

        dd(config('app'));

        return view('admin.languages', compact('lang_strings', 'func'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public static function langStringsList($lang) 
    {
       
        foreach ($lang as $lang_string_key => $lang_string) {
            if(is_array($lang_string)) {
                self::$parent_string_key = $lang_string_key; 
                self::langStringsList($lang_string);
            } else {
               self::$lang .= '<tr><td><label for="' . self::$parent_string_key .'['.$lang_string_key . ']">' . e($lang_string) . '</label></td>';
               self::$lang .= '<td><input type="text" name="' . $lang_string_key . '" id="' . $lang_string_key . '" value="' . e($lang_string) . '"></td></tr>';
            }
        }

        return self::$lang;

    }
}
