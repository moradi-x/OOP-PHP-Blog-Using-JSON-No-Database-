<?php

namespace app\Clases;

class Validator
{

    private $request; // مقدار ارسالی توسط کاربر
    private $errors = []; // ارور هامون درون اینه 

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function validate($array)
    {
        foreach ($array as $field => $rules) {
            if (in_array('unllable', $rules) and !$this->request->{$field}->isFile()) // در ادیت هست
                continue; //  یعنی کد های باقی مانده برای ادامه این حلقه اجرا نمیشن و  مستقیم به حلقه بعدی میره
            foreach ($rules as $rule) {
                if ($rule == 'unllable')
                    continue;
                if (str_contains($rule, ':')) {
                    // دو تا رشته رو میگیره و میسنجه زیر رشته ورودی اول هست یا نه
                    $rule = explode(':', $rule);
                    $ruleName = $rule[0];
                    $ruleValue = $rule[1];
                    if ($error = $this->{$ruleName}($field, $ruleValue)) {
                        $this->errors[$field] = $error;
                        break;
                    }
                } else {
                    if ($error = $this->{$rule}($field)) {
                        $this->errors[$field] = $error;
                        break;
                    }
                }
            }
        }
        return $this;
    }

    public function hasError()
    {
        return count($this->errors) ? true : false;
    }

    public function getErrors()
    {
        return $this->errors;

        // برای اینکه به ازای رول ما این متد عمل بکنه 
    }

    private function required($field)
    {
        if (is_null($this->request->get($field)))
            return "please fill $field";

        if (empty($this->request->get($field))) {
            return "please fill $field";
        }
        false;

        // میسنجیم که مقدار ورودی این این متد که ارسال شده نال نباشد و ای ام تی و خالی نباشد 
    }

    private function email($field)
    {
        if (!filter_var($this->request->{$field}, FILTER_VALIDATE_EMAIL))
            return "`$field` is invalid email ";
        return false;
        // این فیلتر ور با این ورودی دوم میسنجه ایا ورودی اول به فرمت ایمیل هست یا نه ِ
        // برای اعتبار سنجیه  خروجی رشته ایمیل مون هست
    }

    private function min($field, $value)
    {
        if (strlen($this->request->{$field}) < $value)
            return "`$field` chars length is smaller tan $value ";
        return false;

        // چون این رول دو بخشی هست ماهم  دوتا ورودی گرفتیم 
        //‌ باید چک کنیم که  ورودی اول مون بزرگ تر از ورودی دوم مون باشه در غیر این صورت ارور میدیم
    }

    private function max($field, $value)
    {
        if (strlen($this->request->{$field}) > $value)
            return "`$field` chars length is bigger tan $value ";
        return false;
        // این تابع میاد و طول رشته رو حساب میکنه
        // چون این رول دو بخشی هست ماهم  دوتا 
    }

    public function in($field, $items)
    {
        $items = explode(',', $items);
        if (!in_array($this->request->{$field}, $items))
            return "selected `$field` is invalid";
        return false;
    }

    public function size($field, $len)
    {
        if ($this->request->{$field}->getSize() > $len)
            return "`$field` must be smaller thane $len KB";
        return false;
    }

    public function type($field, $types)
    {
        $types = explode(',', $types);
        if (!in_array($this->request->{$field}->getExtension(), $types))
            return "`$field` format is invalid ";
    }

    public function file($field)
    {
        if (!$this->request->{$field} instanceof Upload) // چک میکنه  ایا  این شی از این کلاس هست یا نه ؟
            return "`$field` is not file ";

        if (!$this->request->{$field}->isFile())
            return "`$field` is not file ";
        return false;
    }
}
