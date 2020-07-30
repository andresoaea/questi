<?php

namespace App;

//use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
     use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'picture', 'fbid', 'email', 'role', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getPictureAttribute()
    {

        //return url('/image-storage/profile') . '/aaa';

        $fb_id = $this->attributes['fbid'];
        $picture = $this->attributes['picture'];
        $fb_picture ='https://graph.facebook.com/' . $fb_id . '/picture?height=150&width=150';

        if(empty($picture)) 
        {
            if(!empty($fb_id))
            {
                return $fb_picture;
            } 
        }
        else 
        {
            return $picture;
        }

    }
}