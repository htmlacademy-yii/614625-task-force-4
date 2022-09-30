<?php
namespace TaskForce\importers;
use SplFileObject;

class DataImporter{

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

    public function arrayToSring($arrData){
        $stringData = '';
        foreach ($arrData as $key => $data){
            $stringData .= $arrData[$key];
            if(count($arrData)===$key+1){
                continue;
            }
            $stringData .= ',';
        }
        return $stringData;
    }

    public function getFileObject($filename){
        if(!file_exists(dirname(dirname(__DIR__)) . $filename)){
            //throw new fileExeption();
        }

        $fileCsv = new \SplFileObject(dirname(dirname(__DIR__)) . $filename);
        $fileInfo = new \SplFileInfo(dirname(dirname(__DIR__)) . $filename);

        if($fileInfo->getFilename()==='categories.csv'){
            $tableName = $this->getTableNameCategories();
            $tableRow = $this->getRowTableCategories();
        }
        if($fileInfo->getFilename()==='cities.csv'){
            $tableName = $this->getTableNameCities();
            $tableRow = $this->getRowTableCities();
        }

        $insertTxt = 'INSERT INTO ' . $tableName . ' (' . $this->arrayToSring($tableRow) . ')' . ' VALUES';
        //var_dump($insertTxt);
        //exit;
        foreach ($this->getLineFile($fileCsv) as $line) {
            //print_r('<pre>');
            //var_dump($line);
            //print_r('</pre>');
            //array(2) {[0]=>string(33) "Курьерские услуги"[1]=>string(7) "courier"}
        }

    }
}
