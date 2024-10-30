<?php
    /*
    Plugin Name: MK Simple DB Cleaner
    Plugin URI: /logytia-simple-db-cleaner
    Description: Basic and Simple database cleaner with MySQL
    Version: 1.1.0
    Author: Adem Mert Kocakaya
    Author URI: http://www.pigasoft.com
    License: GNU
    */
    
        if ( ! defined( 'ABSPATH' ) ) exit; 
    
        add_action('admin_menu', 'logytia_simple_database_cleaner');
        
            function logytia_simple_database_cleaner() {
                add_menu_page('MK Simple DB Cleaner', 'MK Simple DB Cleaner', 'manage_options', 'logytia-simple-db-cleaner', 'logytia_simple_database_cleaner_mysql');
            }
 
            function logytia_simple_database_cleaner_mysql() {
	        wp_enqueue_style( 'logytia_custom_styles', plugins_url( 'assets/css/style.css', __FILE__ ), '', '1.0' );
	        wp_enqueue_style( 'bootstrap_styles', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ), '', '1.0' ); ?>
            
                <html>
                    <head>
                        <meta name="author" content="Adem Mert Kocakaya">
                        <meta name="description" content="Pigasoft Infinity Techology and  Software INC.">
                        <meta http-equiv="content" content-type="text/html; charset=iso-8859-9">
                        <title>MK Simple Database Cleaner</title>
                    </head>
                    <body>
                        <? include (plugin_dir_path(__FILE__) . 'includes/admin.php');  ?>
                    </body>
                </html>
                
<?php } ?>