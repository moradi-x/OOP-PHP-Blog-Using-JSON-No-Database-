<?php

namespace app\Models;

use app\Clases\Database;
use app\Exceptions\DosNotExistsException;

abstract class model
{
    protected $fileName;
    protected $entityclass;
    protected $database;

    public function __construct()
    {
        $this->database = new Database($this->fileName, $this->entityclass);
    }

    public function getAllData()
    {
        return $this->database->getData();
    }


    public function getDataById($id) // نشون دادن پست بر حسب ایدی
    {
        $data = $this->database->getData(); // برا دیدن کل دیتا بیس مون ارایه ای پر از شی یعنی خروجی ابجکتی هست

        $array = array_filter($data, function ($item) use ($id) {
            return $item->getId() == $id;
            //هر عنصر از ارایه دالر دیتا که یک شی از پوست اینتیتی هست با شرط ایدی که ما میدیم مقایسه میشه و مقدار ایدی شی رو میگیره 
        });
        $array = array_values($array); // بازنشانی کلید ها از 0 ارایه های شی ما
        if (count($array))
            return $array[0];
        throw new DosNotExistsException("dos not exists $this->entityclass ");  // استثنا اگ نشد این رو عملی کن 
    }

    public function getLastData() // نشون دادن اخرین پست
    {
        $data = $this->database->getData();
        uasort($data, function ($first, $second) {
            return $first->getId() > $second->getId() ? -1 : 1;
        });
        // دو ورودی میگیه اول ارایع دومی تابع  با تابع مقایسع مینه درون ارایعه رو و نزولی یا صعودی رتب میکنهه بر اساس  چیزی که توی تابع دادیم بهش
        $data = array_values($data);

        if (count($data))
            return $data[0];

        throw new DosNotExistsException("dos not exists $this->entityclass ");
    }

    public function getFirstData()
    { // برگردوندن اولین پست, کوچیک ترین ایدی 
        $data = $this->database->getData();
        uasort($data, function ($first, $second) {
            return $first->getId() < $second->getId() ? -1 : 1;
            // مرتب کردن ارایه ای از اشیا که بالاتر گرفت به صورت صعودی بر اساس ایدی
        });
        $data = array_values($data);
        if (count($data))
            return $data[0];
        throw new DosNotExistsException("dos not exists $this->entityclass ");
    }

    public function sortData($callback) // مرتب سازی بر حسب زمان
    {
        $data = $this->database->getData();
        uasort($data, $callback);
        $data = array_values($data);
        if (count($data))
            return $data;
        throw new DosNotExistsException("dos not exists $this->entityclass ");
    }

    public function filterData($callback) // فیلتر کردن برحسب...
    {
        $data = $this->database->getData();

        $data = array_filter($data, $callback);
        $data = array_values($data);
        if (count($data))
            return $data;
        throw new DosNotExistsException("dos not exists $this->entityclass ");
    }

    public function createData($newData)
    {
        $data = $this->database->getData();
        $data[] = $newData;

        $this->database->setData($data);
        return true;
    }

    public function deleteData($id)
    {
        $data = $this->database->getData();
        $newData = array_filter($data, function ($item) use ($id) {
            return $item->getId() == $id ? false : true;
        });
        $newData = array_values($newData);
        $this->database->setData($newData);
        return true;
    }

    public function editData($new)
    {
        $data = $this->database->getData();
        $newData = array_map(function ($item) use ($new) {
            return $item->getId() == $new->getId() ? $new : $item;
        }, $data);
        $newData = array_values($newData);
        $this->database->setData($newData);
        return true;
    }
}
