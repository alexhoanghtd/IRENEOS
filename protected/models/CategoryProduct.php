<?php
class CategoryProduct{
    public static function getProductCategory($productID){
        $query  = "SELECT ic_category.id FROM ";
        $query .= "ic_category INNER JOIN ic_category_product ";
        $query .= "ON ic_category_product.category_id = ic_category.id ";
        $query .= "WHERE ic_category_product.product_id =".$productID;
        
        $db = CTSQLite::connect();
        $result = $db->query($query);
        if($result){
            $categoryID = $result->fetchArray();
            $db->close();
            unset($db);
            return $categoryID['id'];  
        }else{
            $db->close();
            unset($db);
            return false;
        }
    }
    /**
     * Update the category field in 
     * @param type $productID
     * @param type $categoryID
     * @return boolean TRUE if update successfully
     *                 FALSE if update failed
     */
    public static function updateCategory($productID, $categoryID){
        $query  = "UPDATE ic_category_product";
        $query .= " SET category_id = ".$categoryID;
        $query .= " WHERE product_id = ".$productID;
        
        $db = CTSQLite::connect();
        if($db->exec($query)){
            $db->close();
            unset($db);
            return true;
        }else{
            $db->close();
            unset($db);
            return false;
        }
        
    }
}