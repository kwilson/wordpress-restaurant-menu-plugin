<?php

class RestaurantMenu_Menu {

    // Menu ID
    private $_id = 1;

    // Menu title
    private $_title = "default title";

    // Menu items
    private $_menuItems = array(1,2,3,4,5);

    public function getId() {
        return $this->_id;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getMenuItems() {
        $menuItems = array();
        foreach($this->_menuItems as $item) {
            $menuItem = new RestaurantMenu_MenuItem();
            array_push($menuItems, $menuItem);
        }

        return $menuItems;
    }
}

?>
