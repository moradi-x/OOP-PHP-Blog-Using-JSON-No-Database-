<?php

const BASE_URL = 'http://localhost:8000/';

function dd($data)
{
    die("<pre>" . print_r($data, true));
}

function asset($file)
{ // برای برگردوندن عکس  
    return BASE_URL . 'assets/' . $file;
}

function url($patch, $query = [])
{
    if (! count($query))
        return BASE_URL . $patch;

    return BASE_URL . $patch . '?' . http_build_query($query);
// این تابع یک ورودی دارد که ارایه هست و خروجی این تایع رشته ای هست
 //از کلید ها به مقدار شون با = وصل شدن و & از هم جدا شدن  
}

function redirect($path,$query = []){
    $url = url($path,$query);
    header("location:$url");
    exit;
}

function deletedFile($file){
    if(file_exists('./assets/' . $file)){ // تابع چک کردن وجود پوشه 
        unlink('./assets/' . $file);
        return true ;
    }
    return false;
}