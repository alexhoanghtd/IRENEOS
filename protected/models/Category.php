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
            $db->close();
            unset($db);
        } else {
            return false;
        }
    }

    public function getCategoryList() {
        $db = CTSQLite::connect();
        $getCategoryQuery = 'SELECT * FROM ic_category';
        $results = $db->query($getCategoryQuery);
        $row_results = array();
        $count = 0;
        while ($row = $results->fetchArray()) {
            array_push($row_results, $row);
            $count++;
        }

        for ($i = 0; $i <= $count - 1; $i++) {
            $getPicQuery = 'SELECT * FROM ic_pictures WHERE id=' . $row_results[$i]['cover_id'];
            $covers = $db->query($getPicQuery);
            $cover = $covers->fetchArray();
            $coverURL = $cover['url'];
            $row_results[$i]['coverURL'] = $coverURL;
        }
        return $row_results;
        $db->close();
        unset($db);
    }

    public function getCategoryProducts($id) {
        $db = CTSQLite::connect();
        $query = 'SELECT * FROM ic_category_product WHERE category_id =:id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        if (!$result) {
            return false;
        } else {
            $row_results = array();
            $count = 0;
            while ($product_id = $result->fetchArray()) {
                $getProductQuery = 'SELECT * FROM ic_product WHERE id=' . $product_id['product_id'];
                $ProductId = $db->query($getProductQuery);
                while ($row = $ProductId->fetchArray()) {
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

    public function deleteCategory($id) {
//      $db = CTSQLite::connect();
//      $DeleteQuery = 'DELETE FROM ic_category WHERE id=' .$id;
//      $results = $db->query($DeleteQuery);
        $model = new Category();
        $model->get($id);
        $results = $model->delete();
        if ($results) {
            return $results;
            echo "Successfully!!!";
            $db->close();
            unset($db);
        } else {
            echo "Can't excute";
            return false;
        }
    }

    public function createCategory($data) {
        $model = new Category();
        $model->setData($data);
        $results = $model->create();
        if ($results) {
            return $results;
            echo "Successfully!!!";
            $db->close();
            unset($db);
        } else {
            echo "Can't excute";
            return false;
        }
    }

    public function updateCategory($data) {
        $model = new Category();
        $model->setData($data);
        $results = $model->update();
        if ($results) {
            return $results;
            echo "Successfully!!!";
            $db->close();
            unset($db);
        } else {
            echo "Can't excute";
            return false;
        }
    }

}