<?php 
namespace app\Clases ;

class Upload {

    private const UPLOAD_DIR  = './assets/images/' ; 
    private $name ;
    private $type ;
    private $size ;
    private $tmp ;
    private $extension ;

    public function __construct($arry)
    {
        $this->name = $arry['name'];
        $this->type = $arry['type'];
        $this->size = $arry['size'];
        $this->tmp = $arry['tmp_name'];
        $this->extension = pathinfo($this->name,PATHINFO_EXTENSION);
    }

    public function Upload(){
        $newName = time() . '.' . $this->extension;
        $address = self::UPLOAD_DIR . $newName ;

        if(move_uploaded_file($this->tmp , $address)) // برای ذخیره در پوشه 
          return "/images/$newName" ; // برای ذخیره در جیسون
        return false ;
    }

    public function getName(){
        return $this->name ;
    }

    public function getType(){
        return $this->type ;
    }

    public function getSize(){
        return $this->size / 1024;
    }

    public function getTmp(){
        return $this->tmp;
    }

    public function getExtension(){
        return $this->extension;
    }

    public function isFile(){
        return $this->name != '' ;
    }
}

