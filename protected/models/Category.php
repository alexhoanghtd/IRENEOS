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
        } else {
            return false;
        }
        $db->close();
        unset($db);
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

    public function deleteCategory($id) {
        $category = new Category();
        $category->get($id);
        $results = $category->delete();

        if ($results) {
            return $results;
            echo "Delete category Success!!!";
        } else {
            echo "Delete category fail";
            return false;
        }
        $db->close();
        unset($db);
    }

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

    public function updatePicUrls() {
        $categoryID = $this->getVal('id');
        $newFolderName = "categories";
        $pictures = Pictures::getCategoryPictureModels($categoryID);

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
        $newDir = BASE_PATH . "/images/" . $newFolderName . "/" . $_POST['category']['name'] . "." . $extension[1];
        print_r($newDir);
        rename($oldDir, $newDir);

        foreach ($pictures as $pic) {
            $newUrl = "/images/" . $newFolderName . "/" . $_POST['category']['name'] . "." . $extension[1];
            $pic->setVal('url', $newUrl);
            $pic->setVal('name', $_POST['category']['name']);
            $pic->update();
        }
    }

    public function deleteFile($id) {
        $db = CTSQLite::connect();
        $getUrlQuery = 'SELECT * FROM ic_pictures WHERE category_id=' . $id;
        $results = $db->query($getUrlQuery);
        if ($row = $results->fetchArray()) {
            print_r($row);
            unlink(BASE_PATH . $row['url']);
        }
        $db->close();
        unset($db);
    }

    public function updatePictures($files) {
        $marsk = array();
        $uploadMarsk = array();
        $folderName = "categories";
        $pictures = Pictures::getCategoryPictureModels($this->getVal('id'));
        foreach ($pictures as $picture) {
            array_push($marsk, $picture);
        }
        foreach ($files as $file) {
            array_push($uploadMarsk, $file);
        }
        for ($i = 0; $i < 4; $i++) {
            if (!empty($uploadMarsk[$i]['name'])) {
                $uploadedTo = Pictures::uploadPicture($uploadMarsk[$i], $folderName);
                // Get extension of file upload       
                print_r($uploadMarsk[$i]['name']);
                $info = new SplFileInfo($uploadMarsk[$i]['name']);
                $extension = $info->getExtension();
                // Rename File upload followed by CategoryName
                $oriName = BASE_PATH . "/images/" . $folderName . "/" . $uploadMarsk[$i]['name'];
                $newName = BASE_PATH . "/images/" . $folderName . "/" . $_POST['category']['name'] . "." . $extension;
                rename($oriName, $newName);
                $url = "/images/" . $folderName . "/" . $_POST['category']['name'] . "." . $extension;
                if (isset($marsk[$i])) {
                    $marsk[$i]->setVal('url', $url);
                    if ($marsk[$i]->update()) {
                        echo 'updated picture to db <br/>';
                    } else {
                        echo 'failed to update picuture <br/>';
                    }
                } else {
                    $marsk[$i] = new Pictures();
                    $marsk[$i]->setVal('url', $url);
                    $marsk[$i]->setVal('name', $this->getVal('name'));
                    $marsk[$i]->setVal('type', 1);
                    $marsk[$i]->setVal('category_id', $this->getVal('id'));
                    if ($marsk[$i]->create()) {
                        echo 'inserted new picture to db <br/>';
                    } else {
                        echo 'cant insert new picutre <br/>';
                    }
                }
            }
        }
    }

}