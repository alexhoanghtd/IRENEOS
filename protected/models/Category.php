<?php

/**
 * Category Model 
 * 
 * @author trungnt <trungnt1@smartosc.com>
 * @created 30 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class Category extends CTModel {

    public function getCategory($id) {
        $db = CTSQLite::connect();
        $getCategoryQuery = 'SELECT * FROM ic_category WHERE id=' . $id;
        $results = $db->query($getCategoryQuery);
        if ($row = $results->fetchArray()) {
            $getPicQuery = 'SELECT * FROM ic_pictures WHERE id=' . $row['cover_id'];
            $covers = $db->query($getPicQuery);
            $cover = $covers->fetchArray();
            $coverURL = $cover['url'];
            $row['coverURL'] = $coverURL;

            return $row;
        } else {
            return false;
        }
    }

    public function getCategoryProducts($id) {
        $db = CTSQLite::connect();
        $query = 'SELECT product_id FROM ic_category_product WHERE category_id =:id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        if (!$result) {
            return false;
        } else {
            $product_id = $result->fetchArray();
            $getProductQuery = 'SELECT * FROM ic_product WHERE id=' . $product_id['product_id'];
            $ProductId = $db->query($getProductQuery);
            if ($row = $ProductId->fetchArray()) {
                return $row;
            } else {
                return false;
            }
        }
    }

    public function createCategory($id) {
        $db = CTSQLite::connect();
        $Insertquery = $this->generateInsertQuery();
        $results = $db->query($InsertQuery);
        if ($row = $results->fetchArray()) {
            return $row;
        } else {
            return false;
        }
    }

    public function deleteCategory($id) {
        $db = CTSQLite::connect();
        $DeleteQuery = 'DELETE FROM ic_category WHERE id='.$id;
        $results = $db->query($DeleteQuery);
//        if ($row = $results->fetchArray()) {
//            return $row;
//        } else {
//            return false;
//        }
        
        return $results;
    }

    public function updateCategory($id) {
        
    }

}