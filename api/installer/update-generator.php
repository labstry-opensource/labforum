<?php

include dirname(__FILE__) . '/../../laf-config.php';
include LAF_ROOT_PATH . '/api/classes/connect.php';
include LAF_ROOT_PATH . '/api/classes/APITools.php';
include LAF_ROOT_PATH . '/api/classes/LabforumUpdater.php';

//Note: The post array could be very large. That's why we use json to send it :D
$_POST = json_decode($_POST['json'], true);

$updater = new LabforumUpdater($pdoconnect);
$apitools = new APITools();

$current_db_api = intval($updater->getCurrentVersion()['db_version']);

//Check whether post has contents.
if(empty($_POST)){
    $data['error'] = "Please specify changes";
    $apitools->outputContent($data);
}
$db_change_arr = array(
    'from_db_api' => $current_db_api ,
    'to_db_api' => $current_db_api + 1,
    'delta' => array(),
);

foreach ($_POST['table'] as $table){
    $table_arr = array(
        'name' => $table['original_name'],
    );
    $has_changes = false;

    //If drop table, we set drop flag to true, then render the next element

    if($table['drop'] === '1'){
        $table_arr['drop'] = true;
        array_push($db_change_arr, $table_arr);
        continue;
    }

    //Finding the difference between the original and the new
    if($table['original_name'] !== $table['new_name']){
        $table_arr['rename_to'] = $table['new_name'];
        $has_changes = true;
    }

    if(!isset($table['cols'])){
        die('Cannot create table with no fields');
    }
    $generate_col_index = 0;
    foreach($table['cols'] as $col_key => $col){
        $is_col_same = true;
        if(!isset($col['null'])) $col['null'] = 'false';

        foreach($col as $key => $field){
            //We don't need to loop twice. Just search for non-original fields
            if(preg_match('/original\_(.+)?/', $key)) continue;
            if(isset($col['original_' .$key]) && $field !== $col['original_'.$key]){
                $is_col_same = false;
                break;
            }

        }

        if(isset($col['drop']) && $col['drop'] === '1'){
            //Add flag when dropping column
            $table_arr['cols'][$generate_col_index]['original_name'] = $col['original_field'];
            $table_arr['cols'][$generate_col_index]['drop'] = true;
            $generate_col_index++;
            $has_changes = true;

        }else if(!$is_col_same){
            $table_arr['cols'][$generate_col_index] = $col;
            $generate_col_index++;
            $has_changes = true;
        }
    }
    if($has_changes) array_push($db_change_arr['delta'], $table_arr);
}
$apitools->outputContent($db_change_arr);