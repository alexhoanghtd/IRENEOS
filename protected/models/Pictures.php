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
        if( !$this->checkFileExisted($file) 
                 && $this->checkFileSize($file, 200) 
                 && $this->checkFileType($file)
                ){
             move_uploaded_file($file["tmp_name"], BASE_PATH."/images/products/" . $file["name"]);
             return "/images/products/". $file["name"];
        }else{
            return false;
        }
    }
    /**
     * Check if the File type is allowed
     * @param type $file
     * @return type
     */
    public function checkFileType($file){
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $file["name"]);
        $extension = end($temp);
        return (
                (//check file type
                   ($file["type"] == "image/gif") 
                || ($file["type"] == "image/jpeg") 
                || ($file["type"] == "image/jpg") 
                || ($file["type"] == "image/pjpeg") 
                || ($file["type"] == "image/x-png") 
                || ($file["type"] == "image/png")
                ) 
                && 
                in_array($extension, $allowedExts)
                ); 
    }
    /**check for the valid size of picture**/
    public function checkFileSize($file,$Kb){
        return ($file["size"] <= $Kb * 1024) ;
    }
    /**
     * check if fileName existed 
     */
    public function checkFileExisted($file){
        return file_exists(BASE_PATH."/images/products/" . $file["name"]);
    }
}
