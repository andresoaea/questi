<?php

namespace App\Http\Controllers\API;

use Hash;
use Image;
use App\User;
use Validator;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function index()
    {

        $user = auth('api')->user();
        $questions = Question::where('author', $user->id)->count();
        $answers = Answer::where('author', $user->id)->count();

        $response = [
            'user'           => $user,
            'questionsCount' => $questions,
            'answersCount'   => $answers
        ];

        return response()->json($response);
    }

    public function getData($expected_data) 
    {

        $user = auth('api')->user();
        $can_retrieve = [ 
            'answers'   => 'App\Answer', 
            'questions' => 'App\Question' 
        ];

        if(array_key_exists($expected_data, $can_retrieve))
        {
            $paginator = $can_retrieve[$expected_data]::whereAuthor($user->id)
                                                        ->latest()
                                                        ->paginate(5);

            if($expected_data === "questions") 
            {
                $data = $paginator->each(function($answer) {
                            $answer->append('category_slug');
                            return $answer;
                        });
            }
            else 
            {

                $data = $paginator->each(function($answer) {
                            $answer->makeHidden(['for', 'author', 'reactions', 'updated_at']);
                            $answer->setAppends(['related_question', 'related_author']);
                            return $answer;
                        });
            }

            $paginator->data = $data;
            
            return response()->json($paginator);
        }

    }

    public function saveGeneralSettings(Request $request)
    {

        $user = auth('api')->user();

        // Validate user input 
        $validatedData = $request->validate([
            'firstname' => 'required|min:3',
            'lastname'  => 'nullable',
            'username'  => 'required|min:5|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id
        ]);

        // Save user input 
        foreach ($validatedData as $key => $value) 
        {
           $user->$key = $value;
        }

        $user->save();

        // Save user picture
        $this->saveUserImage($user, $request->picture);
        

        die();
    }


    public function changePassword(Request $request)
    {

        $user = auth('api')->user();
     
        $request_data = $request->all();
        $validator = $this->adminAredentialRules($request_data);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()], 422);
        }
        else
        {  
            $current_password = $user->password;           
            if(Hash::check($request_data['current_password'], $current_password))
                {           
                    $user->password = Hash::make($request_data['password']);;
                    $user->save(); 
                }
                else
                {           
                    $error = ['current_password' => 'Please enter correct current password'];
                    return response()->json(array('errors' => $error), 422);   
                }
            }        
          
          die();
    }

    public function delete($to_delete)
    {
        $user = auth('api')->user();

        // Delete user image 
        if($to_delete === "image")
        {
            // Delete from image storage
            $this->deleteCurrentPic($user->picture);

            // Delete from database
            $user->picture = null;
            $user->save();

        }      

        die();

    }



    /*
        
        HELPER METHODS used in this class
    
    */

    protected function saveUserImage($user, $image_64)
    {
        if($image_64) 
        {

            // Delete current images if exists
            $this->deleteCurrentPic($user->picture);


            // Process new image
            $img = Image::make($image_64);
            $name = 'store-' . md5(uniqid(rand(), true)) . '.' . str_replace('image/', '', $img->mime());         

            // Save imnages to image storage
            $img->save(public_path('image-storage/profile/original-' . $name));
            $img->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
            $save = $img->save(public_path('image-storage/profile/small-' . $name));

            // Store image name in database
            $user->picture = $name;
            $user->save();

        }
    }

    protected function deleteCurrentPic($pic)
    {
        $image_types = ['small', 'original'];

        foreach ($image_types as $type) {
            $image = public_path('image-storage/profile/' . $type . '-') . $pic;
            if(file_exists($image))
            {
                unlink($image);
            }
        }
    }


    protected function adminAredentialRules(array $data)
    {
      $messages = [
        'current_password.required'      => 'Please enter current password',
        'password.required'              => 'Please enter new password',
        'password_confirmation.required' => 'Please confirm your new password'
      ];

      $validator = Validator::make($data, [
        'current_password' => 'required',
        'password' => 'required|min:6|different:current_password',
        'password_confirmation' => 'required|same:password',     
      ], $messages);

      return $validator;
    }  

}
