<?php

class SQLComparer{
    //Note: This class only handle structure changes of the db. Please do the data migration individually !
    public $pdoconnect;
    public $old_test_db_name = 'test_old_db';
    public $new_test_db_name = 'test_new_db';
    public $old_tables_arr;
    public $new_tables_arr;


    //Variable for creating differences
    public $tables_created_arr;
    public $diff_sql;

    public function __construct($pdoconnect, $old_sql, $new_sql)
    {
        $this->pdoconnect = $pdoconnect;
        $this->executeOldSql($old_sql);
        $this->executeNewSql($new_sql);
        $this->getOldTables();
        $this->getNewTables();
        $tables_to_create = $this->getTablesToCreate();

        foreach($tables_to_create as $table){
            $this->showCreateTable($table);
        }
        $this->showFieldDiffs($this->old_tables_arr);

    }

    public function executeOldSql($sql){
        $this->pdoconnect->query('CREATE DATABASE IF NOT EXISTS test_old_db');
        $this->pdoconnect->query('USE test_old_db');
        $stmt = $this->pdoconnect->prepare($sql);
        $stmt->execute();
    }

    public function executeNewSql($sql){
        $this->pdoconnect->query('CREATE DATABASE IF NOT EXISTS test_new_db');
        $this->pdoconnect->query('USE test_new_db');
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
    public function getTablesToCreate(){
        foreach($this->new_tables_arr as $new_table){
            //If the new table isn't in the old database
            if(!in_array($new_table, $this->old_tables_arr)){
                $this->addTableCreated($new_table);
            }
        }
        return $this->tables_created_arr;
    }

    public function addTableCreated($table_name){
        $this->tables_created_arr[] = $table_name;
    }

    public function showCreateTable($table){
        $this->pdoconnect->query('USE '. $this->new_test_db_name);
        $stmt = $this->pdoconnect->prepare('SHOW CREATE TABLE '. $table);
        $stmt->execute();

        $resultset = $stmt->fetchAll(PDO::FETCH_NUM)[0];
        $this->diff_sql  .= $resultset[1].';' .PHP_EOL;
    }

    private function showFieldDiffs($old_tables_arr){
        $mark_as_column_drop = array();
        $mark_as_column_add = array();
        $mark_as_column_change = array();

        foreach($old_tables_arr as $table){
            $old_table_description = $this->getOldTablesDescription($table);
            $new_table_description = $this->getNewTableDescription($table);

            for($i = 0; $i < max(count($old_table_description), count($new_table_description)); $i++){
                //Handle column drop
                if(isset($old_table_description[$i]) && !isset($new_table_description[$i])){
                    $mark_as_column_drop[$table][] = $old_table_description[$i]['Field'];
                }

                //Handle column add
                if(!isset($old_table_description[$i]) && isset($new_table_description[$i])){
                    $mark_as_column_add[$table] = $old_table_description[$i];
                }

                //Handle column change
                if(isset($old_table_description[$i]) && isset($new_table_description[$i])){
                    foreach($old_table_description as $key => $old_value){
                        foreach ($new_table_description as $new_key => $new_value){

                        }
                    }
                }

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

}