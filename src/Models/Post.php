<?php 
namespace app\Models;
use app\Entites\PostEntites;

class post extends model {
    protected $fileName = 'Post';
    protected $entityclass = PostEntites::class ;
}