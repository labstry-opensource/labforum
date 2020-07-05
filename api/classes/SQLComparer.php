<?php

//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class SQLComparer{
    //Note: This class only handle structure changes of the db. Please do the data migration individually !
    public $pdoconnect;
    public $old_test_db_name = 'test_old_db';
    public $new_test_db_name = 'test_new_db';
    public $old_tables_arr;
    public $new_tables_arr;


    //Variable for creating differences
    public $tables_created_arr;
    public $tables_dropped_arr;

    public $diff_sql = '';

    public $old_sql;
    public $new_sql;

    public function __construct($pdoconnect, $old_sql, $new_sql)
    {
        $this->pdoconnect = $pdoconnect;
        $this->old_sql = $old_sql;
        $this->new_sql = $new_sql;
    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->pdoconnect->query('DROP DATABASE IF EXISTS'. $this->old_test_db_name);
        $this->pdoconnect->query('DROP DATABASE IF EXISTS'. $this->new_test_db_name);
    }

    public function getFullScript(){
        $this->executeOldSql($this->old_sql);
        $this->executeNewSql($this->new_sql);
        $this->getOldTables();
        $this->getNewTables();
        $tables_to_create = $this->getTablesToCreate();
        $tables_to_drop = $this->getTablesToDrop();

        if(isset($tables_to_create)){
            foreach($tables_to_create as $table){
                $this->showCreateTable($table);
            }
        }
        $this->showFieldDiffs($this->old_tables_arr);
        if(isset($tables_to_drop)){
            foreach ($tables_to_drop as $table) {
                $this->showDropTable($table);
            }
        }

        return $this->diff_sql;
    }

    public function getStructureChange(){
        $this->executeOldSql($this->old_sql);
        $this->executeNewSql($this->new_sql);
        $this->getOldTables();
        $this->getNewTables();
        $tables_to_create = $this->getTablesToCreate();
        if(isset($tables_to_create)){
            foreach($tables_to_create as $table){
                $this->showCreateTable($table);
            }
        }
        $this->showFieldDiffs($this->old_tables_arr);
        return $this->diff_sql;
    }

    public function getDroppedTable(){
        $this->executeOldSql($this->old_sql);
        $this->executeNewSql($this->new_sql);
        $this->getOldTables();
        $this->getNewTables();
        $tables_to_drop = $this->getTablesToDrop();
        if(isset($tables_to_drop)){
            foreach ($tables_to_drop as $table) {
                $this->showDropTable($table);
            }
        }
        return $this->diff_sql;
    }

    public function executeOldSql($sql){
        $this->pdoconnect->query('CREATE DATABASE IF NOT EXISTS ' . $this->old_test_db_name);
        $this->pdoconnect->query('USE '. $this->old_test_db_name);
        $stmt = $this->pdoconnect->prepare($sql);
        $stmt->execute();
    }

    public function executeNewSql($sql){
        $this->pdoconnect->query('CREATE DATABASE IF NOT EXISTS ' . $this->new_test_db_name);
        $this->pdoconnect->query('USE '. $this->new_test_db_name);
        $stmt = $this->pdoconnect->prepare($sql);
        $stmt->execute();
    }

    //Check newly created tables
    public function getOldTables(){
        $this->pdoconnect->query('USE '. $this->old_test_db_name);
        $stmt = $this->pdoconnect->prepare('SHOW TABLES');
        $stmt->execute();
        $resultset = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $this->old_tables_arr = $resultset;

        return $this->old_tables_arr;
}
    public function getNewTables(){
        $this->pdoconnect->query('USE '. $this->new_test_db_name);
        $stmt = $this->pdoconnect->prepare('SHOW TABLES');
        $stmt->execute();
        $resultset = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $this->new_tables_arr = $resultset;

        return $this->new_tables_arr;
    }
    protected function getTablesToCreate(){
        foreach($this->new_tables_arr as $new_table){
            //If the new table isn't in the old database, then create it.
            if(!in_array($new_table, $this->old_tables_arr)){
                $this->addTableCreated($new_table);
            }
        }
        return $this->tables_created_arr;
    }

    protected function getTablesToDrop(){
        foreach ($this->old_tables_arr as $old_table) {
            //If the old table isn't in the new database, then drop it.
            if(!in_array($old_table, $this->new_tables_arr)){
                $this->addTableDropped($old_table);
            }
        }
        return $this->tables_dropped_arr;
    }

    protected function addTableCreated($table_name){
        $this->tables_created_arr[] = $table_name;
    }

    protected function addTableDropped($table_name){
        $this->tables_dropped_arr[] = $table_name;
    }

    public function showCreateTable($table){
        $this->pdoconnect->query('USE '. $this->new_test_db_name);
        $stmt = $this->pdoconnect->prepare("SHOW CREATE TABLE `$table`");
        $stmt->execute();

        $resultset = $stmt->fetchAll(PDO::FETCH_NUM)[0];
        $this->diff_sql  .= $resultset[1].';' .PHP_EOL;
    }

    public function showDropTable($table){
        $this->diff_sql  .= "DROP TABLE `$table` ;";
    }

    private function showFieldDiffs($old_tables_arr){
        $mark_as_column_drop = array();
        $mark_as_column_add = array();
        $mark_as_column_alter = array();
        for($i = 0 ; $i < count($old_tables_arr); $i++){
            if(!in_array($old_tables_arr[$i], $this->new_tables_arr)) continue;
            $table = $old_tables_arr[$i];
            $old_table_description = $this->getOldTablesDescription($table);
            $new_table_description = $this->getNewTableDescription($table);

            $old_table_fields = $this->getFieldsFromDescription($old_table_description);
            $new_table_fields = $this->getFieldsFromDescription($new_table_description);

            //Mark drop fields that no longer exists
            foreach ($old_table_fields as $field){
                if(!in_array($field, $new_table_fields)){
                    $mark_as_column_drop[$table][] = $field;
                }
            }

            //Mark add fields that doesn't exists in old database.
            foreach ($new_table_fields as $index => $field){
                if(!in_array($field, $old_table_fields)){
                    $mark_as_column_add[$table][] = $new_table_description[$index];
                }
            }

            //Check fields for updated value
            foreach ($old_table_description as $old_description){
                foreach($new_table_description as $new_description){
                    if($old_description['Field'] === $new_description['Field']){
                        if(!$this->isRowEqual($old_description, $new_description)){
                            $mark_as_column_alter[$table][] = $old_description['Field'];
                        }
                    }
                }
            }
        }
        foreach($mark_as_column_drop as $table => $dropped_cols){
            //Create DROP COLUMN statement for every DROPPED COLUMNS
            foreach($dropped_cols as $col){
                $this->diff_sql .= 'ALTER TABLE `'. $table. '` DROP COLUMN `' . $col . '`;' . PHP_EOL;
            }
        }

        foreach($mark_as_column_add as $table => $added_cols){
            //Create ADD COLUMN statement for every ADDED COLUMNS
            foreach($added_cols as $col){

                if($col['Null'] === 'NO'){
                    $nullable = 'NOT NULL';
                }else{
                    $nullable = 'NULL';
                }

                $default = (empty($col['Default']) || $col['Null'] === 'NO') ? '' : 'DEFAULT \''. $col['Default'].'\'';


                $this->diff_sql .= "ALTER TABLE `$table` ADD COLUMN `" .
                    $col['Field'] ."` ". $col['Type']." $nullable $default ;" . PHP_EOL;
            }
        }
    }

    protected function getOldTablesDescription($table){
        if(!in_array($table, $this->old_tables_arr)) return;
        $this->pdoconnect->query('USE '. $this->old_test_db_name);
        $stmt = $this->pdoconnect->prepare('DESCRIBE '. $table);
        $stmt->execute();
        $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return  $resultset;
    }

    protected function getNewTableDescription($table){
        if(!in_array($table, $this->new_tables_arr)) return;
        $this->pdoconnect->query('USE '. $this->new_test_db_name);
        $stmt = $this->pdoconnect->prepare('DESCRIBE '. $table);
        $stmt->execute();
        $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return  $resultset;
    }

    private function getFieldsFromDescription($table_description){
        $fields = array();
        foreach($table_description as $row){
            $fields[] =  $row['Field'];
        }
        return $fields;
    }

    private function isRowEqual($row1, $row2){
        //Proprietary code is not open sourced :P. This is only a col to col comparison.
        if(count($row1) !== count($row2)) return false;

        foreach($row1 as $key => $col1){
            if($col1 !== $row2[$key]) return false;
        }
        return true;
    }
}