<?php
/**
 * Base component class which
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 27 Oct 2013
 * @copyright &copy; 2013 Creative Team 
 */
class CTComponent{
    public function rules(){
        return array(
            CT_USER => "*",
            CT_VISITOR => "*",
            CT_ADMIN => "*",
            "allow" => "*",
        );
    }
}