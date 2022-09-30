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
    public function getRowTableCategories(){
        return ['creation_time', 'name', 'symbol_code'];
    }
    public function getTableNameCategories(){
        return 'categories';
    }
    public function getRowTableCities(){
        return ['creation_time', 'name', 'longitude', 'latitude'];
    }
    public function getTableNameCities(){
        return 'cities';
    }
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
            //throw new fileExeption();
        }
        $fileCsv = new \SplFileObject(dirname(dirname(__DIR__)) . $filename);

        $headerFile = $this->getFileHeadColumn($fileCsv);
        //array(2) { [0]=> string(4) "name" [1]=> string(4) "icon" }
        $line = $this->getLineFile($fileCsv);
        foreach ($this->getLineFile($fileCsv) as $line) {
            //print_r('<pre>');
            //var_dump($line);
            //print_r('</pre>');
            //array(2) {[0]=>string(33) "Курьерские услуги"[1]=>string(7) "courier"}
        }



    }
}
