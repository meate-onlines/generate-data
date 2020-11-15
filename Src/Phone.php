<?php
namespace Random\Generate\Src;


class Phone
{
    //号码的前三位的号段
    protected $phone_start;
    //号码的后四位号段
    protected $phone_end;

    protected $end_email;

    protected $end_email_array = ['163.com','qq.com', 'gmail.com', '139.com'];

    public function __set($name, $value)
    {
        $this->$name = $value;
        return $this;
    }

    public function generatePhone() :string
    {
        $start = $this->phone_start;
        if (empty($start)){
            $start = 1 . mt_rand(3,9) . mt_rand(0,9);
        }
        $end = $this->phone_end;

        if (empty($end)){
            $end = mt_rand(1000,9999);
        }

        return $start . mt_rand(10000,99999) . $end;
    }

    public function generateEmail() :string
    {
        $end_email = $this->end_email;
        if (empty($end_email)){
            $end_email = $this->end_email_array[array_rand($this->end_email_array, 1)];
        }

        return mt_rand(100000,999999) . '@' . $end_email;
    }
}