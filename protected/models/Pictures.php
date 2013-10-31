<?php

/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class Pictures extends CTModel {

    /**
     * 
     * @param int $id id of the picture you want to get
     */
    public function __construct($id=0) {
        parent::__construct();
        if($id != 0){
            $this->get($id);
        
        }
    }
    /**
     * get product picture urls
     * @param type $productID
     * @return boolean|array array of product picture url
     */
    public static function getProductPictures($productID) {
        $conn = CTSQLite::connect();
        $query = 'SELECT url FROM ic_pictures WHERE product_id ='.$productID;
        $result = $conn->query($query);
        if($result){
            $urls = array();
            while($url = $result->fetchArray()){
                array_push($urls, $url['url']);
            }    
            return $urls;
        }else{
            echo 'cant get product pictures <br/>';
            return FALSE;
        }
    }
    /**
     * Get an array of picture model belong to product with id = $productID
     * @param int $productID
     */
    public static function getProductPictureModels($productID){
        $conn = CTSQLite::connect();
        $query = 'SELECT id FROM ic_pictures WHERE product_id ='.$productID;
        $result = $conn->query($query);
        if($result){
            $pictures = array();
            while($picID = $result->fetchArray()){
                $picture = new Pictures($picID['id']);
                array_push($pictures,$picture);
            }
            return $pictures;
        }else{
            return false;
        }
    }

    public function getCategoryPictures($categoryID) {
    }

    public static function uploadPicture($file,$folderName) {
        if( self::checkFileSize($file, 400) && self::checkFileType($file)){
            if(self::checkFileExisted($file,$folderName)){
                
            } 
             move_uploaded_file($file["tmp_name"], BASE_PATH."/images/" .$folderName.'/'. $file["name"]);
             return "/images/".$folderName.'/'. $file["name"];
        }else{
            return false;
        }
    }
    /**
     * Check if the File type is allowed
     * @param type $file
     * @return type
     */
    public static function checkFileType($file){
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
    public static function checkFileSize($file,$Kb){
        return ($file["size"] <= $Kb * 1024) ;
    }
    /**
     * check if fileName existed 
     */
    public static function checkFileExisted($file,$folderName){
        return file_exists(BASE_PATH."/images/" .$folderName.'/'. $file["name"]);
    }
    
    public static function createPictureFoler($folderName){
        $dir = BASE_PATH.'/images/'.$folderName.'/';
        return mkdir($dir);
    }
}
