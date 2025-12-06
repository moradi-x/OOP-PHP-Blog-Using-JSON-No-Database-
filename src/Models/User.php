<?php

namespace app\Models;

use app\Entites\UserEntity;

class User extends model
{
    protected $fileName = 'User';
    protected $entityclass = UserEntity::class;

    public function authenticatUser($email, $password)
    {
        $data = $this->database->getData();
        $user = array_filter($data, function ($item) use ($email, $password) {
            if ($item->getEmail() == $email and $item->getPassword() == $password)
                return true;
            return false;
            // تابع کمکی ما یک شی از یوزر انتیتی هست 
        });
        $user = array_values($user);
        if (count($user))
            return $user[0];
        return false;
    }
}
