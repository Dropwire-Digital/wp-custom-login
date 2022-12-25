<?php
/* 
Plugin Name: Dropwire Custom Login Page
 
Plugin URI: https://dropwire.digital
 
Description: Modify Login Page to Custom Branding

Version: 1.1.0
 
Author: Adam Burns
 
Author URI: https://dropwire.digital
 
License: GPLv2 or later
 
Text Domain: dw-custom-login
 
*/
if ( !defined( 'ABSPATH' ) ) {
    die;
}

include plugin_dir_path( __FILE__ ) . '\admin\settings.php';

$options = get_option('dwCustLogIn_options');
$highlightcolor = $options['colour1'];
$buttonText = $options['image'];

$dwcssPayload= "<style type='text/css'>
/*Logo*/

#login h1 a{
    background-image: url('" . $options['image'] . "');
        background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
}
#loginform {
    border-color: " . $highlightcolor . ";
    border-radius: 10px;
    
  
}

#loginform label {
    color: black;
    font-family: Open Sans,Arial,sans-serif;
}
.login input {
    border-radius: 20px;

}

.login input:focus {
    border-color: " . $highlightcolor . ";

}

.login .button.wp-hide-pw {
    color:" . $highlightcolor . ";
}


/*Submit Button*/

#wp-submit {
    padding: 15px 30px;
    background-color:" . $highlightcolor . ";
    color:" . $buttonText . ";
    border-width: 0px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    margin-top: 40px;
    width: 100%;
    font-family: Open Sans, Arial, sans-serif;
    line-height: 1.7em;
}
</style>
";

function custom_login_css() {
    global $dwcssPayload;
    /*wp_enqueue_style( 'custom_login_css', 0, array() );*/
    echo $dwcssPayload;
}
add_action( 'login_enqueue_scripts', 'custom_login_css', 10 );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );
