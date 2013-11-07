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
            return $categoryID['id'];  
        }else{
            return false;
        }
    }
}