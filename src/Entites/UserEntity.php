<?php 
namespace app\Entites ;

class UserEntity{
    private $id ;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $data; 

    public function __construct($array)
    {
        $this->id = $array['id'];
        $this->firstName = $array['firstName'];
        $this->lastName = $array['lastName'];
        $this->email = $array['email'];
        $this->password = $array['password'];
        $this->data = $array['data'];
    }

    public function toArry(){
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'data' => $this->data
        ];
    }

    public function getId(){
        return $this->id;
    }
    public function getFirstName(){
        return $this->firstName ;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function getFullName(){
        return $this->firstName . ' ' . $this->lastName ;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getData(){
        return $this->data;
    }
    public function getTimesTamp(){
        return strtotime($this->data);
    }
}

