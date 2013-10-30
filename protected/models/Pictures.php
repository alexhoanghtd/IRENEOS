<?php

/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class Pictures extends CTModel {

    public function getPicture($id) {
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_pictures WHERE id=' . $id);
        if ($row = $results->fetchArray()) {

            return $row;
        } else {
            return false;
        }
    }

    public function getProductPictures($productID) {
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_pictures WHERE product_id=' . $productID);
        if ($row = $results->fetchArray()) {

            return $row;
        } else {
            return false;
        }
    }

    public function getCategoryPictures($categoryID) {
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_pictures WHERE category_id=' . $categoryID);
        if ($row = $results->fetchArray()) {

            return $row;
        } else {
            return false;
        }
    }

    public function uploadPicture($file) {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $file["name"]);
        $extension = end($temp);
        if ((($file["type"] == "image/gif") 
                || ($file["type"] == "image/jpeg") 
                || ($file["type"] == "image/jpg") 
                || ($file["type"] == "image/pjpeg") 
                || ($file["type"] == "image/x-png") 
                || ($file["type"] == "image/png")) 
                && ($file["size"] < 20000) 
                && in_array($extension, $allowedExts)) {
            if ($file["error"] > 0) {
                echo "Return Code: " . $file["error"] . "<br>";
            } else {
                echo "Upload: " . $file["name"] . "<br>";
                echo "Type: " . $file["type"] . "<br>";
                echo "Size: " . ($file["size"] / 1024) . " kB<br>";
                echo "Temp file: " . $file["tmp_name"] . "<br>";

                if (file_exists("upload/" . $file["name"])) {
                    echo $file["name"] . " already exists. ";
                } else {
                    move_uploaded_file($file["tmp_name"], "upload/" . $file["name"]);
                    echo "Stored in: " . "upload/" . $file["name"];
                }
            }
        } else {
            echo "Invalid file";
        }
    }

}
