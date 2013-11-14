<?php

/**
 * Bill Model 
 * 
 * @author trungnt <trungnt@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class Bill extends CTModel {

    public function fieldRules() {
        return array(
            "id" => array(
                "maxLength" => 20,
                "minLength" => 1,
                "name" => "Identitier",
                "unique" => true,
                "required" => true,
            ),
            "customer_first_name" => array(
                "maxLength" => 300,
                "minLength" => 1,
                "name" => "First name",
                "required" => true,
            ),
            "customer_last_name" => array(
                "maxLength" => 300,
                "minLength" => 1,
                "name" => "Last name",
                "required" => true,
            ),
            "customer_email" => array(
                "maxLength" => 1000,
                "minLength" => 5,
                "name" => "Email",
                "required" => true,
                "regEx" => "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/",
            ),
            "tax" => array(
                "maxLength" => 100,
                "minLength" => 0,
                "name" => "Tax",
                "required" => false,
            ),
            "shipping_fee" => array(
                "maxLength" => 20,
                "minLength" => 0,
                "name" => "Shipping fee",
                "required" => false,
            ),
            "total" => array(
                "maxLength" => 1000000,
                "minLength" => 0,
                "name" => "Total",
                "required" => false,
            ),
        );
    }

    public static function placeOrder($data) {
        $bill = new Bill();
        $billDetail = new BillDetail();

        $data['tax'] = 10;
        $data['shipping_fee'] = 20;
        $price = CT::user()->bag()->totalCal();
        $data['total'] = $price + $price * $data['tax'] / 100 + $data['shipping_fee'];


        $bill->setData($data);
        if ($bill->validateCreate()) {
            // Insert into ic_bill
            $billId = $bill->create();

            //Prepare data to insert into ic_billdetail
            $db = CTSQLite::connect();
            $itemDetail = CT::user()->bag()->getItems();
            foreach ($itemDetail as $key => $item) {
                $proID = $item['productID'];
                $QuantityOrder = $item['quantity'];

                $attID = $item['attribute']['id'];
                $query = "SELECT * FROM ic_attribute WHERE id=" . $attID;
                $result = $db->query($query);
                while ($attInfo = $result->fetchArray()) {
                    $sizeID = $attInfo['size_id'];
                    $colorID = $attInfo['color_id'];
                    $QuantityInStore = $attInfo['quantity'];
                }

                $dataBillDetail = array(
                    "product_id" => $proID,
                    "size_id" => $sizeID,
                    "color_id" => $colorID,
                    "quantity" => $QuantityOrder,
                    "bill_id" => $billId);

                //Insert into ic_billdetail
                if ($QuantityOrder <= $QuantityInStore) {
                    $billDetail->setData($dataBillDetail);
                    $billDetail->create();
                    
                    //Clear Bag
                    CT::user()->clearBag();
                    
                    //Quantity after checkout in store
                    $q = $QuantityInStore-$QuantityOrder;
                    
                    $sqlQuery = "UPDATE ic_attribute SET quantity=" .$q. " WHERE id=" . $attID;
                    $r = $db->query($sqlQuery);
                } else {
                    //Show message if out of stock
                    $sql = "SELECT product_name FROM ic_product WHERE id=" . $proID;
                    $res = $db->query($sql);
                    $proName = $res->fetchArray();
                    echo "Your order: Product " . $proName['product_name'] . " ,size " . $item['attribute']['size']
                    . " ,color " . $item['attribute']['color'] . " ,quantity " . $QuantityOrder . " OUT OF STOCK";
                    echo "</br>";
                }
            }
            echo 'Create Bill sucessfully !<br>';

            //print_r($bill->getData());
            //print_r(CT::user()->bag()->listALl());
        }
    }

    static function getBillList($page) {
        $NumberProductOf1Page = 10;
        $pos = ($page - 1) * $NumberProductOf1Page;
        $db = CTSQLite::connect();

        // Count total number Products
        $SelectQuerry = 'SELECT * FROM ic_bill';
        $res = $db->query($SelectQuerry);
        $totalRecord = 0;
        while ($rows = $res->fetchArray()) {
            $totalRecord++;
        }
        //$totalPages = ceil($totalRecord / $NumberProductOf1Page);

        $getBillQuery = 'SELECT * FROM ic_bill limit ' . $pos . ',' . $NumberProductOf1Page;
        $results = $db->query($getBillQuery);
        $row_results = array();
        while ($row = $results->fetchArray()) {
            $row['currentPage'] = $page;
            $row['totalRecord'] = $totalRecord;
            array_push($row_results, $row);
        }

        return $row_results;
    }

}

