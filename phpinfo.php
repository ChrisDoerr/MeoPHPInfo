<?php
/**
  Plugin Name:  Meo PHP Info
  Description:  Just display the PHP info data.
  Version:      1.0.0
  Author:       Chris Doerr
  Author URI:   http://www.meomundo.com/
  License:      GPL2
*/

function phpinfo_getData() {

  ob_start();
  
  phpinfo();
    
  $content = ob_get_contents();
  
  ob_end_clean();
  
  return $content;

}

function phpinfo_showInfo() {

  $content = phpinfo_getData();

  $DOC  = new DOMDocument();
  
  $DOC->loadHTML( $content );  
  
  $body = $DOC->getElementsByTagName('body');
  
  if( $body && 0 < $body->length ) {
    
    $body = $body->item(0);
    
    echo '<div id="PHPInfo">';
    echo $DOC->savehtml( $body );
    echo '</div>';
    
  }
  
};

function phpinfo_loadBackendStyles() {

  wp_enqueue_style( 'phpinfo_backendStyles' );

}

function phpinfo_adminMenu() {
  
  $page = add_menu_page( 'PHP Info', 'PHP Info', 'manage_options', 'meophpinfo', 'phpinfo_showInfo' );

  add_action( 'admin_print_styles-' . $page, 'phpinfo_loadBackendStyles' );
  
}
function phpinfo_adminInit() {
  
  $pluginUrl = plugin_dir_url( __FILE__ );

  wp_register_style( 'phpinfo_backendStyles', $pluginUrl . 'styles.css' );

}

add_action( 'admin_init', 'phpinfo_adminInit' );
add_action( 'admin_menu', 'phpinfo_adminMenu' );
