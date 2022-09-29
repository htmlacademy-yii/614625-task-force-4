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

    public function getFileHeadColumn($fileCsv){
        $fileCsv->rewind();
        return $fileCsv->fgetcsv();
    }
    public function getLineFile($fileCsv)
    {
        while (!$fileCsv->eof()) {
            yield $fileCsv->fgetcsv();
        }
        return null;
    }
    public function getFileObject($filename){
        if(!file_exists(dirname(dirname(__DIR__)) . $filename)){
            throw new fileExeption();
        }
        $fileCsv = new \SplFileObject(dirname(dirname(__DIR__)) . $filename);

        $headerFile = $this->getFileHeadColumn($fileCsv);
        //array(2) { [0]=> string(4) "name" [1]=> string(4) "icon" }
        $line = $this->getLineFile($fileCsv);
        foreach ($this->getLineFile($fileCsv) as $line) {
            var_dump($line);
        }
        




        
        // $file->setFlags(\SplFileObject::READ_CSV);
        // foreach ($file as $row) {
        //     print_r('<pre>');
        //     var_dump($row);
        //     print_r('</pre>');
        // }
    }
}
