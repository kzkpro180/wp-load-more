<?php

/**
 
 * @wordpress-plugin
 * Plugin Name:       WP Load More
 * Description:       A wordpress load more posts plugin
 * Version:           1.0.1
 * Author:            Kishor Khambu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-load-more
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}
$plugin_url = plugins_url('', __FILE__);

$purl = plugin_dir_url( __FILE__ );
$pdir = plugin_dir_path( __FILE__ );
require_once plugin_dir_path( __FILE__ ) . 'includes/config.php';
/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-load-more-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-load-more-deactivator.php';


register_activation_hook( __FILE__, array( 'Load_More_Activator', 'activate' ) );

register_deactivation_hook( __FILE__, array( 'Load_More_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-load-more.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.5
 */
function run_wp_load_more() {
  $plugin = new Load_More();
  $plugin->run();

}

run_wp_load_more();


//add ajaxurl on frontend

add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

//add jquery to wp_head
function insert_jquery(){
wp_enqueue_script('jquery', false, array(), false, false);
}
add_filter('wp_enqueue_scripts','insert_jquery',1);
