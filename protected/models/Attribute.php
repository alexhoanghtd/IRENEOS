<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Attribute
 *
 * @author Alex Hoang
 */
class Attribute extends CTModel {

    public function fieldRules() {
        return array(
            "id" => array(
                "max-length" => 20,
                "min-length" => 1,
                "name" => "identitier",
                "unique" => true,
            ),
        );
    }

}
