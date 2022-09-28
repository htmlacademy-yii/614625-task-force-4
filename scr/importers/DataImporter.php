<?php
namespace TaskForce\importers;
use SplFileObject;

class DataImporter{
    //нужен ряд функций:
    //получение файла
    //получение названия таблицы
    //название колонок

    //categories name, icon
    //в таблицу категорий добавить поле

    //cities name, lat, long

    public function getFileObject($filename){
        //(file_exists(dirname(dirname(__DIR__)) . $filename));

        $file = new \SplFileObject(dirname(dirname(__DIR__)) . $filename);
        $file->setFlags(\SplFileObject::READ_CSV);
        foreach ($file as $row) {
            print_r('<pre>');
            var_dump($row);
            print_r('</pre>');
        }

        // foreach ($file as $row) {
        //     var_dump($row);
        // }
    }
}
