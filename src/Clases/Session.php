<?php

namespace app\Clases;
// چون نمیخوای شی بسازیم و دسترسی راحت تر داشته  باشبم از استاتیک استفاده میکنیم
class Session
{

    public static function get($name)
    {
        if (isset($_SESSION[$name]))
            return $_SESSION[$name];
        return null;
        // سشن رو با نامش از ارایه گلوبال --سشن بیرون مکشیم
    }
 
    public  static function set($name, $value)
    {
        $_SESSION[$name] = $value;
        // برای تعریف کردن سشن در برنامه خودمون
    }

    public static function has($name)
    {
        if (isset($_SESSION[$name]))
            return true;
        return false;
        // چک میکنیم ایا وجود داره یا نه 
    }

    public static function forget($name)
    {
        unset($_SESSION[$name]);
        return true;
    }

    public static function flush($name, $value = null)
    {
        if (self::has($name)) {
            $session = self::get($name);
            self::forget($name);
            return $session;
        } else {
            self::set($name, $value);
        }
        // یعنی اگر وجود داشت بیایم مقدار رو برگشت بدیم و پاک کنیم  
        // و اگ وجود نداشت مقدارش رو ایجاد و  ست بکنیم 
    }
}
