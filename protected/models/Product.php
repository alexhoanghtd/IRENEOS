<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Product extends CTModel {

    public function fieldRules() {
        return array(
            "id" => array(
                "maxLength" => 20,
                "minLength" => 1,
                "name" => "identitier",
                "unique" => true,
                "required" => true,
            ),
            "product_name" => array(
                "maxLength" => 200,
                "minLength" => 5,
                "name" => "Product name",
                "unique" => true,
                "required" => true,
            ),
            "product_description" => array(
                "maxLength" => 1000,
                "minLength" => 5,
                "name" => "Product description",
                "unique" => false,
                "required" => true,
            ),
            "price" => array(
                "maxLength" => 1000,
                "minLength" => 5,
                "name" => "Product price",
                "required" => true,
            ),
            "sale" => array(
                "maxLength" => 100,
                "minLength" => 0,
                "name" => "Product sale",
                "required" => false,
            ),
        );
    }

    public static function createProduct($productData, $files) {
        echo 'product data: ---------------------<br>';
        //INSERT PRODUCT DATA STUFFS
        $newProduct = new Product();
        $newProduct->setData($productData);
        $error = $newProduct->validateCreate();
        //print_r($newProduct->getTableStruct());
        if(!$error){
            if($newProduct->create()){
                
            }
        }else{
            //show error
        }
        //echo 'product Pictures: ---------------------<br>';
        //print_r($files);
    }

    public function getProductIdByName($name) {
        $db = CTSQLite::connect();
        $query = 'SELECT id FROM ic_product WHERE product_name =:name';
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

    public function generateFolderName() {
        $name = $this->getVal('product_name');
        if ($name) {
            return 'products/' . $this->seoFriendLy($name);
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

    /**
     * 
     * @param type $productID
     * @param type $newFolderName
     */
    public function updatePicUrls() {
        $productID = $this->getVal('id');
        $newFolderName = $this->generateFolderName();
        $pictures = Pictures::getCategoryPictureModels($productID);
        foreach ($pictures as $pic) {
            if ($pic->getVal('type') == 1) {
                $path = $pic->getVal('url');
            }
        }
        $folders = explode('/', $path);
        $oldDir = BASE_PATH;
        for ($i = 0; $i < 4; $i++) {
            $oldDir .= $folders[$i] . '/';
        }
        $newDir = BASE_PATH . '/images/' . $newFolderName . '/';
        if (rename($oldDir, $newDir)) {
            foreach ($pictures as $pic) {
                $newUrl = str_replace($folders[2] . '/' . $folders[3], $newFolderName, $pic->getVal('url'));
                $pic->setVal('url', $newUrl);
                $pic->setVal('name', $this->getVal('product_name'));
                $pic->update();
            }
        }
    }

    /**
     * upload new picture, store those picture into db
     * @param $_FILES $files
     */
    public function updatePictures($files) {
        $marsk = array();
        $uploadMarsk = array();
        $folderName = $this->generateFolderName();
        $pictures = Pictures::getProductPictureModels($this->getVal('id'));
        foreach ($pictures as $picture) {
            array_push($marsk, $picture);
        }
        foreach ($files as $file) {
            array_push($uploadMarsk, $file);
        }
        for ($i = 0; $i < 4; $i++) {
            if (!empty($uploadMarsk[$i]['name'])) {
                $uploadedTo = Pictures::uploadPicture($uploadMarsk[$i], $folderName);
                if (isset($marsk[$i])) {
                    $marsk[$i]->setVal('url', $uploadedTo);
                    if ($marsk[$i]->update()) {
                        echo 'updated picture to db <br/>';
                    } else {
                        echo 'failed to update picuture <br/>';
                    }
                } else {
                    $marsk[$i] = new Pictures();
                    $marsk[$i]->setVal('url', $uploadedTo);
                    $marsk[$i]->setVal('name', $this->getVal('product_name'));
                    $marsk[$i]->setVal('type', 2);
                    $marsk[$i]->setVal('product_id', $this->getVal('id'));
                    if ($marsk[$i]->create()) {
                        echo 'inserted new picture to db <br/>';
                    } else {
                        echo 'cant insert new picutre <br/>';
                    }
                }
            }
        }
    }

    /**
     * get attribute value coressponding to itself
     * @return boolean|array
     */
    public function getProductAttributes() {
        $attributeModel = new Attribute();
        $attributes = $attributeModel->getWhere("product_id=" . $this->getVal('id'));
        if ($attributes) {
            $attributeData = array();
            foreach ($attributes as $att) {
                $color = new Color($att->getVal('color_id'));
                $size = new Size($att->getVal('size_id'));

                $quantity = $att->getVal('quantity');
                array_push($attributeData, array(
                    "id" => $att->getVal('id'),
                    "color" => $color->getVal('name'),
                    "size" => $size->getVal('name'),
                    "quantity" => $att->getVal('quantity'),
                ));
            }
            return $attributeData;
        } else {
            return false;
        }
    }

    /**
     * get available attribute group
     * @param type $id
     */
    public function getProductSize($id = 0) {
        if ($id != 0) {
            $model = new Product($id);
        } else {
            $model = new Product($this->getVal('id'));
        }
    }

    /**
     * Update the category that the product belong to
     * @param type $categoryID
     */
    public function updateCategory($categoryID) {
        //echo 'about to update productid = '.$this->getVal('id').' with categoryid='.$categoryID;
        $categories = Category::getCategory();
        $categoryIDs = array_keys($categories);
        if ($categoryID > 0 && in_array($categoryID, $categoryIDs)) {
            if (!CategoryProduct::getProductCategory($this->getVal('id'))) {
                //if the product is not set to any categor
                CategoryProduct::addProductToCategory($this->getVal('id'), $categoryID);
            } else {
                //if the product already set to a category
                CategoryProduct::updateCategory($this->getVal('id'), $categoryID);
            }
        } else {
            echo 'the category you add is not valid';
        }
    }

}
