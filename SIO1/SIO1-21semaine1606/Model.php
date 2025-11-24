<?php
namespace App\Models;
use App\Database\Database;

abstract class Model
{

    function all($table, $columns):void
    {
        $db = new Database();

        $ret = $db->query('SELECT * FROM ' . $table);
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
            foreach($columns as $key => $value) 
                echo $key . " = ". $row[$key] . "<br/>";
        }
       // echo "Operation done successfully\n";
        $db->close();
    }

    function packAll($table, $columns):array
    {
        $db = new Database();

        $ret = $db->query('SELECT * FROM ' . $table);
        
        //Create array to keep all results
        $data= array();

        // Fetch Associated Array (1 for SQLITE3_ASSOC)
        while ($res= $ret->fetchArray(1))
        {
            //insert row into array
            array_push($data, $res);
            }

        return $data;
    }

    function find($table, $column, $criteria):array
    {
        $db = new Database();
        $result = $db->querySingle("SELECT * FROM $table WHERE $column='$criteria'", true);

        //echo "Search done successfully\n";
//        $db->close();
        return $result;
    }

    public function insert($table, $columns, $records)
    {
        $db = new Database();

        $fields = implode(', ', array_keys($columns));
        $values = implode('\', \'', array_values($records));
        //var_dump($values);

        $db->query("INSERT INTO '$table'($fields) VALUES('$values')");
        //echo "Record inserted successfully\n";
        $db->close();
    }

    function update($table, $column, $change, $columnCriteria, $criteria)
    {
        $db = new Database();

        $query = $db->exec("UPDATE $table SET $column='$change' WHERE $columnCriteria='$criteria'");
        if ($query) {
            //echo 'Number of rows modified: ', $db->changes();
        }
    }

    function delete($table, $column, $criteria)
    {
        $db = new Database();
        $db->querySingle("DELETE FROM $table WHERE $column='$criteria'", true);
        
        //echo "Deletion done successfully\n";
        $db->close();
        //return $result;
    }
}

