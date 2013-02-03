<?php

class PageRenderer {
    
    public static function RenderPlugin() {
        if ( !current_user_can( 'edit_pages' ) )  {
		    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	    }

        
        if( isset($_GET[ 'rmf' ]) ) {
            $pageFunction = $_GET[ 'rmf' ];
            $menuId = $_GET[ 'menuid' ];

            switch ($pageFunction)
            {
                case 'manage-menu':
	                self::RenderManageMenu($menuId);
                  break;

                case 'edit-menu':
	                self::RenderEditMenu($menuId);
                  break;

                case 'delete-menu':
	                self::RenderDeleteMenu($menuId);
                  break;

                default:
	                self::RenderMainMenuPage();
            }
        }
        else {
	        self::RenderMainMenuPage();
        }
    }

    function RenderMainMenuPage() {
        // variables for the field and option names
        $hidden_field_name = 'mt_submit_hidden';
        $data_field_name = 'restuarant-menu_name';
        $data_field_description = 'restuarant-menu_description';

        // Read in existing option value from database
        // $opt_val = get_option( $opt_name );

        // See if the user has posted us some information
        // If they did, this hidden field will be set to 'Y'
        if( isset($_POST[ $data_field_name ]) ) {
            $name = $_POST[ $data_field_name ];
            $description = $_POST[ $data_field_description ];
            self::PostNewMenu($name, $description);
        }

        // Now display the settings editing screen
        echo '<div class="wrap">';

        // header
        echo "<h2>" . __( 'Menu Test Plugin Settings', 'restaurant-menu' ) . "</h2>";

        // settings form

        // Load all categories
        echo '<h3>Current Menus</h3>';
        $menus = RestaurantMenu_DatabaseManager::GetMenus();
        if (count($menus) > 0) {
            ?>
                <table class="wp-list-table widefat">
                    <thead>
                        <tr>
                            <th scope="col" class="manage-column column-name">Name</th>
                            <th scope="col" class="manage-column column-description">Description</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            foreach($menus as $menu) {
                echo '<tr>';
                echo    '<td>';
                echo        '<strong>' . $menu->title . '</strong>';
                echo        '<div class="row-actions-visible">';
                echo            '<span class="edit"><a href="' . get_settings('siteurl')."/wp-admin/edit.php?post_type=page&page=restaurant-menu&rmf=manage-menu&menuid=" . $menu->id . '">manage</a> | </span>';
                echo            '<span class="edit"><a href="' . get_settings('siteurl')."/wp-admin/edit.php?post_type=page&page=restaurant-menu&rmf=edit-menu&menuid=" . $menu->id . '">edit details</a> | </span>';
                echo            '<span class="delete"><a href="' . get_settings('siteurl')."/wp-admin/edit.php?post_type=page&page=restaurant-menu&rmf=delete-menu&menuid=" . $menu->id . '">delete</a></span>';
                echo        '</div>';
                echo    '</td>';
                echo    '<td class="column-description desc">' . $menu->description . '</td>';
                echo '</tr>';
            }
            ?>
                </table>
            <?php
        } else {
            echo '<p>No current menus to show.</p>';
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

    function PostNewMenu($name, $description) {
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

    function RenderManageMenu($menuId) {
        echo '<h2>Manage Menu ' . $menuId . '</h2>';
    }

    function RenderEditMenu($menuId) {
        echo '<h2>Edit Menu ' . $menuId . '</h2>';
    }

    function RenderDeleteMenu($menuId) {
        echo '<h2>Delete Menu ' . $menuId . '</h2>';
    }
}

?>