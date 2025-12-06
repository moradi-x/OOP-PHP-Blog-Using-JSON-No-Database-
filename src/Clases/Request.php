<?php

namespace app\Clases;

class Request
{
    // این کلاس برای اینه که داده های کاربر که نمیدونیم چیه بیاد و ذخیره بشه به صورت داینامیک  در این ارایه
    private $attributes = [];
    private $method;
    private $url;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url =  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if ($this->method == 'POST') {
            foreach ($_POST as $key => $value) {
                $this->attributes[$key] = $value;
            }
            foreach ($_FILES as $key => $value) {
                $this->attributes[$key] = new Upload($value);
            }
        }
        foreach ($_GET as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function isPostMethod()
    {
        return strtolower($this->method) == 'post';
        // حروف بزرگ رشته رو به حروف کوچک رشته تبدیل میکنه  
    }

    public function __get($name)
    // با متد جدویی میتونیم پراپتی هایی که ست کردیم در اختیار بگیریم
    // وقتی این کلاس فراخانی میشه با متدی در این کلاس نیست حالا  
    //این متد شروع به فعالیت میکنه و در ورودی این متد اسم همون متدی که در کلاس نیست رو میگیره 
    {
        if (array_key_exists($name, $this->attributes))
            return $this->attributes[$name];
        return null;
    }

    public function has($name)
    // میسنجم که ایا یک پرامتر از سمت کاربر ارسال شده یا نه
    {
        if (isset($this->attributes[$name]))
            return true;
        return false;
    }

    public function get($name)
    {
        if (array_key_exists($name, $this->attributes))
            return $this->attributes[$name];
        return null;
    }

    public function getMethode()
    {
        return $this->method;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
