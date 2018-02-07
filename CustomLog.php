<?php

class CustomLog
{
    const LOG_FOLDER = '/log/';

    private $file;

    public function __construct($fileName) {
        $dir = __DIR__ . self::LOG_FOLDER;
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $this->file = $dir . $fileName . '_' . date('Y-m-d') . '.log';
    }

    public function log($data) {
        $str = print_r($data, true);
        if ($str[strlen($str) - 1] != "\n") {
            $str .= "\n";
        } 

        $toFolder = fopen($this->file, "a+");
        fwrite($toFolder, date("H:i:s") . ": " . $str);
        fclose($toFolder);
    }
}