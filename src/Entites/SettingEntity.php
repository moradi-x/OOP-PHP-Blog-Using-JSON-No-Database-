<?php 
namespace app\Entites ;

class SettingEntity{
    private $id;
    private $titel ;
    private $keywords;
    private $desception;
    private $authors;
    private $logo ;
    private $footer ;

    public function __construct($array)
    {
        $this->id = $array['id'] ;
        $this->titel = $array['titel'];
        $this->keywords = $array['keywords'];
        $this->desception = $array['desception'];
        $this->authors = $array['authors'];
        $this->logo = $array['logo'];
        $this->footer = $array['footer'];
    }

        // ما نیازی به نوشتن نداریم برای همین متد تو ارای رو نمینویسیم

        public function getId(){
            return $this->id;
        }

    public function getTitel(){
        return $this->titel ;
    }
    public function getKeywords(){
        return $this->keywords ;
    }
    public function getDesception(){
    return $this->desception ;       
    }
    public function getAuthors(){
        return $this->authors ;
    }
    public function getLogo(){
        return $this->logo ;
    }
    public function getFooter(){
        return $this->footer;
    }
}