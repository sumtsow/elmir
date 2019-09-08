<?php

class DBConnect extends PDO
{
    public function __construct($file = 'config/db.ini')
    {
        if (!file_exists($file)) {
            throw new Exception('Unable to open ' . $file . ' file.');
        }
        
        $settings = parse_ini_file($file, TRUE);        
        $params = $settings['db']['driver'] .
        ':host=' . $settings['db']['host'] .
        ((!empty($settings['db']['port'])) ? (';port=' . $settings['db']['db']) : '') .
        ';dbname=' . $settings['db']['schema'] .
        ';charset=' . $settings['db']['charset'];
       
        parent::__construct($params, $settings['db']['username'], $settings['db']['password']);
    }
}