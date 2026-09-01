<?
/*
 * Plugin Name: PVID generator
 * Description: PVID will generate a new value on each pageview. It will be collected by all data services (GA4, GAM, etc) and serve as the primary key to re-stitch transaction level data in the warehouse.
 * Author: BioNews
 * Author URI: https://bionews.com
 * Version: 1.7.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !class_exists( 'PVID_Generator_Updater' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'admin/updater.php' );
}
$updater = new PVID_Generator_Updater( __FILE__ );
$updater->set_username( 'BioNewsInc' );
$updater->set_repository( 'PVID-Generator' );
// Your auth code goes here for private repos
$updater->authorize( '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');
$updater->initialize();

function bionews_add_pvid_script() {
    // The JavaScript is enclosed in a single quoted PHP string
    $script = "
        (function() {
            var random_number = Math.floor(10000000 + Math.random() * 90000000);
            var epoch_timestamp = Math.floor(Date.now() / 1000);
            window.pvid = epoch_timestamp + '' + random_number;
        })();
    ";

    echo '<script id="bionews-pvid-generator">' . $script . '</script>';
}
add_action( 'wp_head', 'bionews_add_pvid_script', -1000 );
?>