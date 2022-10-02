<?php
namespace TaskForce\importers;
use TaskForce\exceptions\FileExeption;
class DataImporter{
    const TABLENAMECITIES = 'cities';
    const TABLENAMECATEGORIES = 'categories';
    const TABLEROWCATEGORIES = ['creation_time', 'name', 'symbol_code'];
    const TABLEROWCITIES = ['creation_time', 'name', 'longitude', 'latitude'];

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

    public function convertCsvtoSql($filename){
        if(!file_exists($filename)){
            throw new FileExeption();
        }
        $fileCsv = new \SplFileObject($filename);
        $fileInfo = new \SplFileInfo($filename);
        if($fileInfo->getFilename()==='categories.csv'){
            $tableName = $this::TABLENAMECATEGORIES;
            $tableRow = $this::TABLEROWCATEGORIES;
            $filename = 'categories';
        }
        if($fileInfo->getFilename()==='cities.csv'){
            $tableName = $this::TABLENAMECITIES;
            $tableRow = $this::TABLEROWCITIES;
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
