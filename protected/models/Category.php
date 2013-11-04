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
            // get URL from table ic_pictures
            $getPicQuery = 'SELECT * FROM ic_pictures WHERE type=1 AND category_id=' . $id;
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

    // Show all categories
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
            if (empty($row_results[$i]['id'])) {
                return $row_results;
            } else {
                $getPicQuery = 'SELECT * FROM ic_pictures WHERE type = 1 AND category_id=' . $row_results[$i]['id'];
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

    //Show all products in a category
    public function getCategoryProducts($id) {
        // get all productID in a categoryID
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

    public function deleteCategory($id) {
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

//    public function createCategory($data) {
//        $model = new Category();
//        $model->setData($data);
//        $results = $model->create();
//        
//        if ($results) {           
//            return $results;
//            echo "Successfully!!!";
//            $db->close();
//            unset($db);
//        } else {
//            echo "Can't excute";
//            return false;
//        }
//    }

    public function generateFolderName() {
        $name = $this->getVal('name');
        if ($name) {
            return 'categories/' . $this->seoFriendLy($name);
        } else {
            return false;
        }
    }

    public function seoFriendLy($productName) {
        $string = $productName;
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
        return strtolower(trim($string, '-'));
    }

    public function getCategoryIdByName($name) {
        $db = CTSQLite::connect();
        $query = 'SELECT id FROM ic_category WHERE name =:name';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $result = $stmt->execute();
        if (!$result) {
            return false;
        } else {
            $id = $result->fetchArray();
            return $id['id'];
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