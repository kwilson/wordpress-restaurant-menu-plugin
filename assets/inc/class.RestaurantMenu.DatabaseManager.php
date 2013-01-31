<?php

class RestaurantMenu_DatabaseManager {

    public static function GetMenus() {
        global $wpdb;
        $table_name = self::ResolveTableName("menu"); 

        $menus = $wpdb->get_results( 
	        "
	        SELECT * 
	        FROM $table_name
	        ORDER BY displayOrder
	        "
        );

        return $menus;
    }

    public static function InsertMenu($title, $description) {
        global $wpdb;
        $table_name = self::ResolveTableName("menu"); 

        return $wpdb->insert( 
	        $table_name, 
	        array( 
		        'title' => $title, 
		        'description' => $description,
                'displayOrder' => 1 
	        ), 
	        array( 
		        '%s', 
		        '%s', 
		        '%d' 
	        ) 
        );
    }
    
    /**
     * Installs or upgrades the required tables.
     */
    public static function Install() {
        global $restaurantmenu_db_version;

        // Menu
        $table_name = self::ResolveTableName("menu");      
        $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    title tinytext NOT NULL,
                    description text,
                    displayOrder tinyint NOT NULL,
                    UNIQUE KEY id (id)
                );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Category
        $table_name = self::ResolveTableName("category");      
        $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    title tinytext NOT NULL,
                    description text,
                    displayOrder tinyint NOT NULL,
                    isVisible bool DEFAULT true NOT NULL,
                    menuid mediumint(9) NOT NULL,
                    UNIQUE KEY id (id)
                );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Menu Item
        $table_name = self::ResolveTableName("menuitem");      
        $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    title tinytext NOT NULL,
                    description text,
                    displayOrder tinyint NOT NULL,
                    isVisible bool DEFAULT true NOT NULL,
                    categoryid mediumint(9) NOT NULL,
                    UNIQUE KEY id (id)
                );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
 
        add_option("restaurantmenu_db_version", $restaurantmenu_db_version);
    }

    /**
     * Gets a table name, resolved with the WP and plugin prefixes.
     *
     * @param string $name The name of the table
     */
    private static function ResolveTableName($name) {
        global $wpdb;
        $prefix = "restaurantmenu_";
        return $wpdb->prefix . $prefix . $name;
    }
}

?>