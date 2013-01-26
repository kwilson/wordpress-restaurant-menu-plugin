<?php
    
include('assets/inc/class.RestaurantMenu.php');
include('assets/inc/class.RestaurantMenu.Menu.php');
include('assets/inc/class.RestaurantMenu.MenuItem.php');

/**
 * Gets the content for the specified area ID.
 *
 * @param string $areaid The ID of the content
 */
function restaurantmenu_getareacontent($areaid) {
    $resturants = RestaurantMenu::GetMenusForArea($areaid);
    foreach($resturants as $menu) {
        echo "<h2>" . $menu->getTitle() . "</h2>";

        $menuitems = $menu->getMenuItems();
        echo "<dl>";
        foreach($menuitems as $menuitem) {
            echo "<dt>" . $menuitem->getTitle() . "</dt>";
        }

        echo "</dl>";
    }
}

?>