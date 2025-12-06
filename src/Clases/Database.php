<?php
// وظیفه اول این فایل : خوندن و مپ کردنش برای استفاده در برنامه 
// وظیفه دوم : اگر تغیری ایجاد شده  بره توو دیتابیس بنویسه

namespace app\Clases;

class Database
{
    private $databaseFileAddress;
    private $data;

    public function __construct($fileName, $entityclass)
    {
        $this->databaseFileAddress = './Database/' . $fileName . '.json';
        $file = fopen($this->databaseFileAddress, "r+");
        $database = fread($file, filesize($this->databaseFileAddress));
        fclose($file);
        $data = json_decode($database, true);
        // به صورت ارایه انجمنی؛ فایل جیسون درون دالر دیتاهست


        $this->data = array_map(function ($item) use ($entityclass) {
            return new ($entityclass)($item); // تبدیل ارایه به شی
        }, $data);
    }


    public function setData($newData) 
    //  newData یه ارایه پر از اشیا هست
    {
        $this->data = $newData;
        $newData = array_map(function ($item) {
            return $item->toArray(); 
            // برای هر شی از نیو دیتا ما این متد تو اریی رو صدا میزنیم
        }, $newData);

        $newData = json_encode($newData);
        $file = fopen($this->databaseFileAddress, 'w+');
        fwrite($file, $newData);
        fclose($file);
        return true;
    }

    
    public function getData(){
        return $this->data;  // خروجی ابجکتی
    }
}

