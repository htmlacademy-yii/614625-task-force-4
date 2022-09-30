<?php
namespace TaskForce\importers;
use TaskForce\exceptions\FileExeption;
use Exception;
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
        // if(!file_exists(dirname(dirname(__DIR__)) . $filename)){
        //     throw new FileExeption();
        // }
        try{
        $fileCsv = new \SplFileObject(dirname(dirname(__DIR__)) . $filename);
        $fileInfo = new \SplFileInfo(dirname(dirname(__DIR__)) . $filename);
        } catch(Exception $e){
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
        if($fileInfo->getFilename()==='categories.csv'){
            $tableName = $this->getTableNameCategories();
            $tableRow = $this->getRowTableCategories();
            $filename = 'categories';
        }
        if($fileInfo->getFilename()==='cities.csv'){
            $tableName = $this->getTableNameCities();
            $tableRow = $this->getRowTableCities();
            $filename = 'cities';
        }
        $filename .= '.sql';

        $insertTxt = 'INSERT INTO ' . $tableName . ' (' . $this->arrayToSring($tableRow) . ')' . ' VALUES ';
        $date = date('Y-m-d');
        $this->getFileHeadColumn($fileCsv);

        foreach ($this->getLineFile($fileCsv) as $key => $line) {
            if($key!==0){
                $insertTxt .= ',';
            }
            $insertTxt .= "('{$date}',";
            foreach ($line as $keyLine => $lineData) {
                $insertTxt .= "'{$lineData}'";
                if(count($line)===$keyLine+1){
                    continue;
                }
                $insertTxt .= ',';
            }
            $insertTxt .= ')';

        }
        $insertTxt .= ';';
        file_put_contents($filename, $insertTxt);
    }
}
