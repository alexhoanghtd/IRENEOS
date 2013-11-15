<?php

/**
 * User Model 
 * 
 * @author phucct
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class Collection extends CTModel {

    static function getCollection() {
        $db = CTSQLite::connect();
        $getCollectionQuery = 'SELECT id, name FROM ic_collection';
        $results = $db->query($getCollectionQuery);
        $result_rows = array();
        while ($row = $results->fetchArray()) {
            $result_rows[$row['id']] = $row;
        }
        return $result_rows;
        $db->close();
        unset($db);
    }

    public function getCollectionList() {
        $db = CTSQLite::connect();
        $query = 'SELECT id FROM ic_collection';
        $result = $db->query($query);
        $data = array();
        if ($result) {
            while ($id = $result->fetchArray()) {
                $collection = new Collection($id[0]);
                $collectionData = $collection->getData();
                $pic = new Pictures();
                $pic->setVal('collection_id', $id[0]);
                if ($pics = $pic->select()) {
                    $collectionData['url'] = $pics[0]->getVal('url');
                }
                array_push($data, $collectionData);
            }
            
        }
        return $data;   
    }

    public function getCollectionIdByName($name) {
        $db = CTSQLite::connect();
        $query = 'SELECT id FROM ic_collection WHERE name =:name';
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

    public function deleteCollection($id) {
        $collection = new Collection();
        $collection->get($id);
        $results = $collection->delete();

        if ($results) {
            return $results;
            echo "Delete collection Success!!!";
        } else {
            echo "Delete collection fail";
            return false;
        }
        $db->close();
        unset($db);
    }

    public function deleteFile($id) {
        $db = CTSQLite::connect();
        $getUrlQuery = 'SELECT * FROM ic_pictures WHERE collection_id=' . $id;
        $results = $db->query($getUrlQuery);
        if ($row = $results->fetchArray()) {
            unlink(BASE_PATH . $row['url']);
        }
        $db->close();
        unset($db);
    }

    public function getCollectionProducts($id) {
        $db = CTSQLite::connect();
        $query = 'SELECT * FROM ic_collection_product WHERE collection_id =:id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
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
            // get picture URL of product
            for ($i = 0; $i <= $count - 1; $i++) {
                $getPicQuery = 'SELECT * FROM ic_pictures WHERE type=1 AND product_id=' . $row_results[$i]['id'];
                $covers = $db->query($getPicQuery);
                $cover = $covers->fetchArray();
                $coverURL = $cover['url'];
                $row_results[$i]['coverURL'] = $coverURL;
            }

            return $row_results;
            $db->close();
            unset($db);
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

    public function generateFolderName() {
        $name = $this->getVal('name');
        if ($name) {
            return 'collection/' . $this->seoFriendLy($name);
        } else {
            return false;
        }
    }

    public function updatePicUrls() {
        $collectionID = $this->getVal('id');
        $newFolderName = "collection_cover";
        $pictures = Pictures::getCollectionPictureModels($collectionID);

        foreach ($pictures as $pic) {

            if ($pic->getVal('type') == 1) {
                $path = $pic->getVal('url');
            }
        }
        $fileName = explode('/', $path);
        print_r($fileName);
        $extension = explode('.', $fileName[3]);
        print_r($extension);
        $oldDir = BASE_PATH . $path;
        $newDir = BASE_PATH . "/images/" . $newFolderName . "/" . $_POST['collection']['name'] . "." . $extension[1];
        print_r($newDir);
        rename($oldDir, $newDir);

        foreach ($pictures as $pic) {
            $newUrl = "/images/" . $newFolderName . "/" . $_POST['collection']['name'] . "." . $extension[1];
            $pic->setVal('url', $newUrl);
            $pic->setVal('name', $_POST['collection']['name']);
            $pic->update();
        }
    }

    public function updatePictures($files) {
        
    }

}
