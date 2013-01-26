<?php
    
include('class.RestaurantMenu.Menu.php');
include('class.RestaurantMenu.MenuItem.php');

class RestaurantMenu {

    /**
     * Return an array of menus for the specified area.
     *
     * @param string $areaname The name of the content area
     */
    public static function GetMenusForArea($areaname) {	
	    $ids = array(1,2,3);

        $menus = array();
        foreach($ids as $menuid) {
            $menu = self::GetMenu($menuid);
            array_push($menus, $menu);
        }

        return $menus;
    }

    /**
     * Gets the menu with the specified ID.
     *
     * @param int $menuId The ID of the menu
     */
    public static function GetMenu($menuid) {
        $menu = new RestaurantMenu_Menu();
        return $menu;
    }
}

?>