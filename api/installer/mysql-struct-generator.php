<?php
/*
include dirname(__FILE__ ) . '/../../laf-config.php';
include API_PATH . '/classes/connect.php';
include API_PATH . '/classes/LabforumUpdater.php';
*/

include_once dirname(__FILE__) . '/../../autoload.php';

$tables_stmt = $pdoconnect->prepare("SHOW TABLES");
$tables_stmt->execute();

$tables_arr = $tables_stmt->fetchAll(PDO::FETCH_COLUMN);

$updater = new LabforumUpdater($pdoconnect);
$databases_arr = array(
    'laf_settings' => $updater->getCurrentVersion(),
    'struct' => array(),
);

foreach($tables_arr as $item){
    $stmt = $pdoconnect->prepare('SHOW COLUMNS FROM `'. $item . '`;');
    $stmt->execute();
    $table_cols_arr = array(
        'table' => $item,
        'cols' => array(),
    );

    $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach($resultset as $set){
        $col_arr = array(
            'field' => $set['Field'],
            'type' => $set['Type'],
            'null' => ($set['Null'] === 'NO') ? false : true,
            'key' => ($set['Key'] === 'PRI')? 'PRIMARY KEY' : '',
            'default' => $set['Default'],
            'extra' => ($set['Extra'] === 'auto_increment') ? strtoupper($set['Extra']) : $set['Extra'],
        );
        array_push($table_cols_arr['cols'],$col_arr);

    }
    array_push($databases_arr['struct'], $table_cols_arr);

}

$struct_pointer = fopen(LAF_ROOT_PATH  . '/assets/laf-structure.json', 'w+');
fwrite($struct_pointer, json_encode($databases_arr));
fclose($struct_pointer);
