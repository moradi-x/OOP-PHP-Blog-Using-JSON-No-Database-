<?php

namespace app\Clases;

use app\Entites\UserEntity;

class Auth
{

    public static function loginUser($user)
    {
        session::set('user', $user->toArry());
        // لاگین میکنه و این متد در ورودی ابجکت میگیرد
        // و به صورت ارایه ذخیره میکنیم 
    }

    public static function logoutUser()
    {
        session::forget('user');
        redirect('index.php', ['action' => 'login']);
    }

    public static function getLoggedUser()
    {
        return new UserEntity(session::get('user'));

        // کاربری که لاگین شده رو نشون میده و 
        // خروجی سشن یک ارایه هست
        // برای برگشت دیتا باید ابجکت باشد
    }
    public static function isAuthenticated()
    {
        return session::has('user') ? true : false;
    }

    public static function checkAuthenticated(){
        if(! self::isAuthenticated())
            redirect('index.php',['action'=>'login']);
    }
}
