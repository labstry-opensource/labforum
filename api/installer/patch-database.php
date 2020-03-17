<?php
include dirname(__FILE__) . '/../../laf-config.php';
include LAF_ROOT_PATH . '/api/classes/connect.php';
include LAF_ROOT_PATH . '/api/classes/LabforumUpdater.php';
include LAF_ROOT_PATH . '/api/classes/APITools.php';

$updater = new LabforumUpdater($pdoconnect);
$apitools = new APITools();

$update_struct = json_decode(file_get_contents(LAF_ROOT_PATH . '/assets/labforum-update-patch.json'), true);

$current_version = intval($updater->getCurrentVersion()['db_version']);
$updating_to_version = intval($update_struct['to_db_api']);
$updating_from_version = intval($update_struct['from_db_api']);

//- If updating version is smaller than current version,
// then we stop patching by preventing database inconsistency.

//- If updating version equals the current version, we don't have to proceed.
//- If we are on a different version than the patcher is on, then the config must be incorrect.

if($current_version > $updating_to_version){
    $data['error'] = "Downgrading is not allowed. Please downgrade manually. ";
    $apitools->outputContent($data);
}else if($current_version === $updating_to_version){
    $data['error'] = "Nothing to do.";
    $apitools->outputContent($data);
}

if($current_version !== $updating_from_version){
    $data['error'] = 'DB version doesn\'t match the patcher. Please check whether you have the correct version of the patcher.';
    $apitools->outputContent($data);
}

$sql_builder = '';
foreach($update_struct['delta'] as $table){
    //Looping each table to generate SQL for executing.

    if(isset($table['drop']) && $table['drop'] === true){
        //If we are dropping table, then we just drop it without looping the columns.
        $sql_builder .= 'DROP TABLE `'. $table['name'].'`; ';
    }else{
        if(isset($table['cols'])){
            foreach($table['cols'] as $index => $col){
                if(isset($col['drop']) && $col['drop'] === true){
                    $sql_builder .= 'ALTER TABLE `'. $table['name'].'` DROP COLUMN `'.$col['original_name'] .'`; ';
                    continue;
                    //Note: We don't have to proceed to check columns because we are dropping the whole table
                }
                if(isset($col['original_field']) && isset($col['original_type']) && isset($col['type']) &&
                    isset($col['field'])){
                    // We are updating column
                    $sql_builder .= 'ALTER TABLE `' . $table['name'].'` CHANGE `'. $col['original_field'].'` `'. $col['field'].'` '
                        . $col['type'] . (($col['null'] === 'false') ? ' NOT NULL ': '');

                    if(isset($col['default']) || is_null($col['default'])){
                        if($col['default'] === 'CURRENT_TIMESTAMP'){
                            $sql_builder .= ' DEFAULT ' . $col['default'] . ' ';
                        }else if($col['default'] === null){
                            if($col['null'] !== 'false'){
                                $sql_builder .= ' DEFAULT NULL ';
                            }
                        }else{
                            $sql_builder .= ' DEFAULT \'' . $col['default'] . '\' ';
                        }
                    }
                    $sql_builder .= ';';
                }
            }
        }
        if(isset($table['rename_to'])){
            $sql_builder .= 'RENAME TABLE `' . $table['name'] . '` TO `'. $table['rename_to'] . '`; ';
        }
    }
}

//Start transaction as we have to unify the database version. Once upgraded, the db version changed together.

try {
    $pdoconnect->beginTransaction();
    $pdoconnect->exec($sql_builder);
    $stmt = $pdoconnect->prepare('UPDATE `laf_settings` SET db_version = :db_version');
    $stmt->bindValue(':db_version', $updating_to_version, PDO::PARAM_INT);
    $stmt->execute();
    $pdoconnect->commit();

}catch(PDOException $e){
    $pdoconnect->rollBack();
    $data['error'] = 'Unknown error occurred';
    $apitools->outputContent($data);
}

unlink(LAF_ROOT_PATH . '/assets/labforum-update-patch.json');

$data['success'] = true;
$apitools->outputContent($data);
