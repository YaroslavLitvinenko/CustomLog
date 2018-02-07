<?php

class CustomLog
{
    /**
     * Папка для логов
     */
    const LOG_FOLDER = '/log/';
    /**
     * Количество файлов, которое будет хранится в папке с логом
     */
    const MAX_COUNT_LOG_FILE = 40;

    /**
     * Имя файла текущего лога
     * @var string
     */
    private $file;

    /**
     * CustomLog constructor.
     * @param string $fileName
     * @param bool $clearOldFile
     */
    public function __construct($fileName, $clearOldFile = true) {
        $dir = __DIR__ . self::LOG_FOLDER;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        } elseif ($clearOldFile) {
            $masFile = glob($dir . $fileName . "_*");
            if (count($masFile) > self::MAX_COUNT_LOG_FILE) {
                rsort($masFile);

                for ($i = self::MAX_COUNT_LOG_FILE; $i < count($masFile); $i++) {
                    unlink($masFile[$i]);
                }

            }
        }

        $this->file = $dir . $fileName . '_' . date('Y-m-d') . '.log';
    }

    /**
     * Логирует данные
     * @param $data
     */
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