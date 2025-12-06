<?php

namespace app\Entites;

class PostEntites
{
    private $id;
    private $titel;
    private $content;
    private $category;
    private $view;
    private $image;
    private $data;

    public function __construct($array)
    // داده های شی رو به ارایه انجمنی تبدیل میکنه 
    {
        $this->id = $array['id'];
        $this->titel = $array['titel'];
        $this->content = $array['content'];
        $this->category = $array['category'];
        $this->view = $array['view'];
        $this->image = $array['image'];
        $this->data = $array['data'];
    }


    public function toArray()
    {
        return [
            'id' => $this->id,
            'titel' => $this->titel,
            'content' => $this->content,
            'category' => $this->category,
            'view' => $this->view,
            'image' => $this->image,
            'data' => $this->data
        ];
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }
    public function getTitel()
    {
        return $this->titel;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getExcerpt($count = 200)
    {
        return substr($this->content, 0, $count) . '...';
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function setView($view)
    {
        $this->view = $view;
    }
    public function getView()
    {
        return $this->view;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getTimesTamp()
    {
        return strtotime($this->data);
    }
}
