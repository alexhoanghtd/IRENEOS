<?php

/**
 * Admin Model 
 * 
 * @author trungnt <trungnt1@smartosc.com>
 * @created 14 Nov 2013
 * @copyright &copy; 2013 Creative Team 
 */
class Admin extends CTModel {

    static function countProductsUsers() {
        $db = CTSQLite::connect();

        // Count Products
        $getProductQuery = 'SELECT COUNT(*) FROM ic_product';
        $res_product = $db->query($getProductQuery);
        $row_pro = $res_product->fetchArray();

        //Count Users
        $getUserQuery = 'SELECT COUNT(*) FROM ic_user';
        $res_user = $db->query($getUserQuery);
        $row_user = $res_user->fetchArray();

        //Count Products which Quantity=0  
        $Query = 'SELECT COUNT(product_id) FROM (SELECT product_id,total FROM
(SELECT product_id,SUM(quantity) as total FROM ic_attribute GROUP BY product_id)) WHERE total = 0';
        $res = $db->query($Query);
        $row = $res->fetchArray();

        $row_result = array("numPro" => $row_pro[0], "numUser" => $row_user[0], "numProEnd" => $row[0]);

        return $row_result;
        $db->close();
        unset($db);
    }
    
    static function getBillList(){
        $db = CTSQLite::connect();
        $getBillQuery = 'SELECT * FROM ic_bill';
        $results = $db->query($getBillQuery);
        $row_results = array();
        while ($row = $results->fetchArray()) {
            array_push($row_results, $row);
        }
        
        return $row_results;
    }

}

?>
