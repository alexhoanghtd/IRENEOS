<?php
class HeaderContent{
    public function __construct() {
    }

    private function renderMenu() {
        ob_start(); 
        $viewFile = BASE_PATH . '/protected/widgets/views/headerContent.php';
        include($viewFile);
        $returned = ob_get_contents();
        ob_end_clean();
        return $returned;
    }
    public function show() {
        echo $this->renderMenu();
    }
}
