<?php

session_start();

include dirname(__FILE__ ) . '/../../autoload.php';

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'LabforumInstaller'){
    $data['error'] = 'Not installing, thus not initializing db';
    $apitools->outputContent($data);
}

$pdoconnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$apitools = new APITools();
$table_struct = json_decode(file_get_contents(LAF_ROOT_PATH . '/assets/laf-structure.json'), true);
$sql_statement = '';

if(!isset($table_struct['laf_settings'])){
    $data['error'] = 'Database and forum version undefined. Installation cannot be proceeded';
    $apitools->outputContent($data);
}

foreach ($table_struct['struct'] as $table){
    $table_name = $table['table'];
    $primary_key = array();
    $sql_builder = 'CREATE TABLE `'. $table_name . '` (';
    foreach($table['cols'] as $index => $col){
        $sql_builder .=  '`' .$col['field'] . '` '. $col['type'] . ' ' .(($col['null'] === false) ? ' NOT NULL ' : '');
        if(isset($col['default']) || is_null($col['default'])){
            if($col['default'] === 'CURRENT_TIMESTAMP'){
                $sql_builder .= ' DEFAULT ' . $col['default'] . ' ';
            }else if($col['default'] === null){
                if($col['null'] !== false){
                    $sql_builder .= ' DEFAULT NULL ';
                }
            }else{
                $sql_builder .= ' DEFAULT \'' . $col['default'] . '\' ';
            }
        }
        if(!empty($col['extra'])){
            if(preg_match('/^DEFAULT_GENERATED(.+)?/', $col['extra'])){
                $extra = preg_split('/DEFAULT_GENERATED/', $col['extra'])[1];
                $sql_builder .= $extra;
            }else{
                $sql_builder .= $col['extra'];
            }
        }
        if($index !== count($table['cols'] ) -1){
            $sql_builder .= ', ';
        }
        if($col['key'] === 'PRIMARY KEY'){
            array_push($primary_key, $col['field']);
        }
    }
    if(!empty($primary_key)){
        $sql_builder .= ', PRIMARY KEY (`' . implode('` , `', $primary_key) . '`)';
    }
    $sql_builder .= ');' . PHP_EOL;

    $sql_statement .= $sql_builder;
}



try{
    $pdoconnect->beginTransaction();
    $pdoconnect->exec($sql_statement);
    $stmt = $pdoconnect->prepare('INSERT INTO `laf_settings` VALUES (:laf_api, :laf_version, 1, :laf_release_date, :db_version, :channel)');
    $stmt->bindParam(':laf_api', $table_struct['laf_settings']['laf_api']);
    $stmt->bindParam(':laf_version', $table_struct['laf_settings']['laf_version']);
    $stmt->bindParam(':laf_release_date', $table_struct['laf_settings']['laf_release_date']);
    $stmt->bindParam(':db_version', $table_struct['laf_settings']['db_version']);
    $stmt->bindParam(':channel', $table_struct['laf_settings']['channel']);
    $stmt->execute();

    $pdoconnect->commit();
}
catch(PDOException $e){
    $data['error'] = $e->getMessage();
    $apitools->outputContent($data);
    $pdoconnect->rollBack();
}

$data['success'] = true;
$apitools->outputContent($data);


