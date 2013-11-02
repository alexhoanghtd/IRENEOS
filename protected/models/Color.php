<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Color
 *
 * @author Alex Hoang
 */
class Color extends CTModel {

    //put your code here

    public static function getAll() {
        $querry = "SELECT * FROM ic_color";
        $db = CTSQLite::connect();
        $results = $db->query($querry);
        if ($results) {
            $colors = array();
            while ($color = $results->fetchArray()) {
                array_push($colors, array(
                    "id" => $color['id'],
                    "name" => $color['name']
                ));
            }
            return $colors;
        } else {
            return false;
        }
        return false;
   }

}
