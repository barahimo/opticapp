<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        function getPermssion($string)
        {
            $list = [];
            $array = explode("','",$string);
            foreach ($array as $value) 
                foreach (explode("['",$value) as $val) 
                    if($val != '')
                        array_push($list, $val);
            $array = $list;
            $list = [];
            foreach ($array as $value) 
                foreach (explode("']",$value) as $val) 
                    if($val != '')
                        array_push($list, $val);
            return $list;
        }
        function hasPermssion($string)
        {
            $permission = getPermssion(Auth::user()->permission);
            $permission_ = getPermssion(User::find(Auth::user()->user_id)->permission);
            $result = 'no';
            if(
                (Auth::user()->is_admin == 2) ||
                (Auth::user()->is_admin == 1 && in_array($string,$permission)) ||
                (Auth::user()->is_admin == 0 && in_array($string,$permission) && in_array($string,$permission_))
            )
            $result = 'yes';
            return $result;
        }
        function msg($string){
            return $string;
        }
    }
}
