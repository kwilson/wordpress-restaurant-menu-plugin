<?php
/*
Plugin Name: Restaurant Menu
Plugin URI: https://github.com/kwilson/wordpress-restaurant-menu-plugin
Description: Restaurant menu manager.
Version: 1.0
Author: Kevin Wilson
Author URI: http://kwilson.me.uk
License: GPL2
*/

include('assets/inc/class.RestaurantMenu.php');
//include('assets/inc/class.RestaurantMenu.DatabaseManager.php');
include('assets/inc/functions.template-tags.php');

global $restaurantmenu_db_version;
$restaurantmenu_db_version = "1.0";

// Install DB
include_once dirname( __FILE__ ).'/assets/inc/class.RestaurantMenu.DatabaseManager.php';
register_activation_hook(__FILE__, array('RestaurantMenu_DatabaseManager', 'Install'));

// Add menu
add_action( 'admin_menu', 'add_plugin_menu' );

// Register the plugin page under 'Pages'
function add_plugin_menu() {
    add_pages_page( 'Restaurant Menu', 'Restaurant Menu', 'edit_pages', 'restaurant-menu', 'render_plugin' );
}

// Render the plugin contents
function render_plugin() {
	if ( !current_user_can( 'edit_pages' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	// variables for the field and option names
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name = 'restuarant-menu_name';
    $data_field_description = 'restuarant-menu_description';

    // Read in existing option value from database
    // $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $data_field_name ]) ) {

        // Read their posted value
        $name = $_POST[ $data_field_name ];
        $description = $_POST[ $data_field_description ];

        // Save the posted value in the database
        $res = RestaurantMenu_DatabaseManager::InsertMenu($name, $description);
        if ($res) {
            // Put an settings updated message on the screen
            ?>
            <div class="updated"><p><strong><?php _e('Settings saved.', 'restaurant-menu' ); ?></strong></p></div>
            <?php
        } else {
            // Put an settings updated message on the screen
            ?>
            <div class="updated"><p><strong><?php _e('Failed.', 'restaurant-menu' ); ?></strong></p></div>
            <?php
        }
    }

    // Now display the settings editing screen
    echo '<div class="wrap">';

    // header
    echo "<h2>" . __( 'Menu Test Plugin Settings', 'restaurant-menu' ) . "</h2>";

    // settings form

    // Load all categories
    $menus = RestaurantMenu_DatabaseManager::GetMenus();
    foreach($menus as $menu) {
        echo "<p>" . $menu->title . "</p>";
    }
    ?>

    <h3>Create Menu</h3>
    <form name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

        <p><label for="<?php echo $data_field_name; ?>"><?php _e("Menu Name:", 'restaurant-menu' ); ?></label> 
            <input type="text" name="<?php echo $data_field_name; ?>">
        </p>

        <p><label for="<?php echo $data_field_name; ?>"><?php _e("Description:", 'restaurant-menu' ); ?></label> 
            <textarea name="<?php echo $data_field_description; ?>"></textarea>
        </p>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Add New Menu') ?>" />
        </p>

    </form>
    </div>

    <?php 
}

?>