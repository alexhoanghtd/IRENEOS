<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Size
 *
 * @author Alex Hoang
 */
class Size extends CTModel {

    public static function getAll() {
        $querry = "SELECT * FROM ic_size";
        $db = CTSQLite::connect();
        $results = $db->query($querry);
        if ($results) {
            $sizes = array();
            while ($size = $results->fetchArray()) {

                array_push($sizes, array(
                    "id" => $size['id'],
                    "name" => $size['name']
                ));
            }
            return $sizes;
        } else {
            return false;
        }
    }

    public static function getSize($id) {
        $size = new Size($id);
        return $size->getVal('name');
    }

}
