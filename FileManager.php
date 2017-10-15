<?php

namespace whc\filemanager;

class FileManager extends \yii\base\Widget
{
    public function run()
    {
        return "Hello!";
    }

    public static function upload($aa)
    {
        print_r($aa); exit();
    }

}
