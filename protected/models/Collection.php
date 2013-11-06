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
            $db->close();
            unset($db);
        } else {
            return false;
        }
    }

    public function getCollectionList() {
        $db = CTSQLite::connect();
        $getCollectionQuery = 'SELECT * FROM ic_category WHERE is_collection = 1';
        $result = $db->query($getCollectionQuery);
        $row_results = array();
        $count = 0;
        while ($row = $result->fetchArray()) {
            array_push($row_results, $row);
            $count++;
        }
        for ($i = 0; $i < $count; $i++) {
            if (empty($row_results[$i]['id'])) {
                return $row_results;
            } else {
                $getPicQuery = 'SELECT * FROM ic_pictures WHERE type = 1 AND category_id = ' . $row_results[$i]['id'];
                $covers = $db->query($getPicQuery);
                $cover = $covers->fetchArray();
                $coverUrl = $cover['url'];
                $row_results[$i]['coverUrl'] = $coverUrl;
            }
        }
        return $row_results;
        $db->close();
        unset($db);
    }

    public function updateCollection($data) {
        $model = new Collection();
        $model->setData($data);
        $result = $model->update();
        if($result){
            return $result;
            echo 'Successful';
            $db->close();
            unset($db);
        }
        else{
            echo 'Can not execute';
            return false;
        }
    }

    public function createCollection($id) {
        
    }

    public function deleteCollection($id) {
        $model = new Collection();
        $model->get($id);
        $result = $model->delete();
        if($result){
            return result;
            echo 'Successfull!';
            $db->close();
            unset($db);
        }
        else {
            echo 'Can not execute!';
            return false;
        }
    }

    public function getCollectionProducts($id) {
        $db = CTSQLite::connect();
        $getCollectionQuery = 'SELECT * FROM ic_category WHERE is_collection = 1';
        $results = $db->query($getCollectionQuery);
        while ($collectionId = $results->fetchArray()) {
            $query = 'SELECT * FROM ic_category_product WHERE category_id =:' . $collectionId['id'];
            $stmt = $db->prepare($query);
            $stmt->bindValue($collectionId['id'], $id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if (!$result) {
                return $row_results;
            } else {
                $row_results = array();
                $count = 0;
                // get all information of products
                while ($product_id = $result->fetchArray()) {
                    $getProductQuery = 'SELECT * FROM ic_product WHERE id=' . $product_id['product_id'];
                    $ProductId = $db->query($getProductQuery);
                    while ($row = $ProductId->fetchArray()) {
                        // push information of products into array row_results
                        array_push($row_results, $row);
                        $count++;
                    }
                }
                for ($i = 0; $i <= $count - 1; $i++) {
                    if (empty($row_results[$i]['cover_id'])) {
                        return $row_results;
                    } else {
                        $getPicQuery = 'SELECT * FROM ic_pictures WHERE type=1 AND id=' . $row_results[$i]['cover_id'];
                        $covers = $db->query($getPicQuery);
                        $cover = $covers->fetchArray();
                        $coverURL = $cover['url'];
                        $row_results[$i]['coverURL'] = $coverURL;
                    }
                }
                return $row_results;
                $db->close();
                unset($db);
            }
        }
    }

}