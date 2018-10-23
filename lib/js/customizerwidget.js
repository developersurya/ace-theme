jQuery(document).ready(function($) {
    /* Move widgets to their respective sections */
    /* Move Newsletter widgets to Home page panel */
    wp.customize.section( 'sidebar-widgets-left-trip-advisor-widget' ).panel( 'home_page' );
    wp.customize.section( 'sidebar-widgets-left-trip-advisor-widget' ).priority( '32' );
    /* Move Stat Counter widgets to Home page panel */
    wp.customize.section( 'sidebar-widgets-right-trip-advisor-widgets' ).panel( 'home_page' );
    wp.customize.section( 'sidebar-widgets-right-trip-advisor-widgets' ).priority( '33' );
    
    });