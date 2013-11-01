<?php

/**
 * User Model 
 * 
 * @author phucct
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class Collection extends CTModel {

    public function getCollection($id) {
        $db = CTSQLite::connect();
        $getCollectionQuery = 'SELECT * FROM ic_category WHERE is_collection = 1 AND id =' . $id;
        $result = $db->query($getCollectionQuery);
        if ($row = $result->fetchArray()) {
            return $row;
        } else {
            return false;
        }
    }

    public function updateCollection($id) {

    }

    public function createCollection($id) {
        
    }

    public function deleteCollection($id) {
        $db = CTSQLite::connect();
        $DeleteQuery = 'DELETE FROM ic_category WHERE is_collection = 1 AND id =' .$id;
        $result = $db->query($DeleteQuery);

        return $result;
    }

    public function getCollectionProducts($id) {
        
    }

}