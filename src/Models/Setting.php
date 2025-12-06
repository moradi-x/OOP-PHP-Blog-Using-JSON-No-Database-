<?php 
namespace app\Models ;

use app\Entites\SettingEntity;

class Setting extends model{
    protected $fileName = 'Setting';
    protected $entityclass = SettingEntity::class;
}