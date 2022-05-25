<?php

namespace App\Services\General;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class GeneralService
{ 

    /**
     * The attributes that should be cast to native types.
     * @var  $route Route App
     * @return  Boolean
    */
    public function is_allow($route,$user_id = null)
    {
        if(!$user_id) $user_id = \General::getUser()->id;
        return User::is_allow($route,$user_id);
    }

    /**
     * The attributes that should be cast to native types.
     * @var  $route Route App
     * @return  Boolean
    */
    public function is_allow_live_wire($route = null)
    {

        if(!isset($route)){
            $route = Route::currentRouteName();
        }
        //dd(request()->all()["updates"][0]["payload"]["method"]);
        if(isset(request()->all()["updates"][0]["payload"]["method"])){
            if(!$this->is_allow($route.".".request()->all()["updates"][0]["payload"]["method"])){
                App::abort(401, 'Unauthorized');
            }   
        }else{
            if(!$this->is_allow($route)){
                App::abort(401, 'Unauthorized');
            }
        }
        return true;
    }
    
    /**
     * Get User Info
     * @return  array
    */
    public function getUser()
    {
        $user = '';
        if (Auth::guard('api')->user()) {
            $user = Auth::guard('api')->user();
        } elseif (Auth::guard('web')->user()) {
            $user = Auth::guard('web')->user();
        }
        return $user;
    }

    /**
     * Get Guest
     * @return  array
    */
    public function getGuest()
    {
        $guest = false;
        if (!Auth::guard('api')->guest()) {
            $guest = false;
        } elseif (!Auth::guest()) {
            $guest = false;
        }
        return $guest;
    }

    /**
     * Get Current Route
     * @return  string
     */
    public function getCurrentRoute()
    {
        $route = explode(".", Route::currentRouteName());
        return $route[0];
    }

    /**
     * Get Current Action
     * @return  string
     */
    function getCurrentAction()
    {
        $app = explode(".", Route::currentRouteName());
        if (isset($app[1])) {
            return $app[1];
        } else {
            return 'index';
        }
    }
}