<?php


namespace Random\Generate\Src;


class Random
{
    protected $name = ['赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '卫', '于', '杨'];

    public function name()
    {
        $json = $this->get_one_data();
        $first_name = $this->name[array_rand($this->name, 1)];
        $last_name = mb_substr($json['word'], 0, mt_rand(1,2));
        return $first_name . $last_name;

    }

    public function text()
    {
        $json = $this->get_one_data();
        return $json['description'] ?? $json['word'];
    }

    public function get_un()
    {
        return uniqid('php_uniqid');
    }

    public function get_float($min=0, $max=1, $round=2)
    {
        return round($min + mt_rand()/mt_getrandmax() * ($max-$min), $round);
    }

    protected function get_one_data()
    {
        $fo = new \SplFileObject(__DIR__ . '/../lib/chenyu.json', 'r');
        $line = mt_rand(0, 43508);
        $fo->seek($line);
        return json_decode($fo->fgets(), true);
    }

}
