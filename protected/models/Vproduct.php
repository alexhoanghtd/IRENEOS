<?php

class Vproduct {

    public static function insert($rowid, $name, $description) {
        $query = "INSERT INTO ic_vproduct(rowid,name,description)";
        $query .= " VALUES(:rowid,:name,:description)";
        $db = CTSQLite::connect();
        $stmt = $db->prepare($query);
        $stmt->bindValue(':rowid', $rowid);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->execute();
        if ($db->changes() > 0) {
            $db->close();
            unset($db);
            return true;
        } else {
            $db->close();
            unset($db);
            return false;
        }
    }

    public static function update($rowid, $name, $description) {
        $query = "UPDATE ic_vproduct SET ";
        $query .= " name = :name,";
        $query .= " description = :description";
        $query .= " WHERE rowid = :rowid";
        $db = CTSQLite::connect();
        $stmt = $db->prepare($query);
        $stmt->bindValue(':rowid', $rowid);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->execute();
        if ($db->changes() > 0) {
            $db->close();
            unset($db);
            return true;
        } else {
            $db->close();
            unset($db);
            return false;
        }
    }

    public static function deleteByID($rowid) {
        $query = "DELETE FROM ic_vproduct WHERE rowid = ".$rowid;
        $db = CTSQLite::connect();
        $result = $db->exec($query);
        $db->close();
        unset($db);
        return $result;
    }

    public static function search($name) {
        $query = "SELECT rowid,name FROM ic_vproduct WHERE name MATCH '".$name."*'";
        $db = CTSQLite::connect();
//        $stmt = $db->prepare($query);
//        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
//        $result = $stmt->execute();
        $result = $db->query($query);
        if($result){
            $products = array();
            while($product = $result->fetchArray()){
                array_push($products,$product);
            }
            return $products;
        }else{
            return false;
        }
    }

}
