<?php
/*
/*
Plugin Name:  Easyplugin
Plugin URI:   https://delreyagency.com/easyplugin
Description:  Easyplugin allows you to add any feature to your website with a textarea where you can paste your any code you want and the shortcode [easyplugin]
Version:      1.0
Author:       delreyagency.com
Author URI:   https://delreyagency.com
License:      GPL

DISCLAIMER

This SOFTWARE PRODUCT is provided "as is" and "with all faults."
THE PROVIDER makes no representations or warranties of any kind concerning the safety, 
suitability, lack of viruses, inaccuracies, typographical errors, or other harmful components 
of this SOFTWARE PRODUCT. There are inherent dangers in the use of any software, and you are
solely responsible. You are also solely responsible for the protection of your website and
backup of your data, and THE PROVIDER will not be liable for any damages you may suffer in 
connection with using, modifying, or distributing this SOFTWARE PRODUCT
*/

add_action( 'admin_menu', 'easyplugin_setup_menu' );

function easyplugin_setup_menu() {
    easyplugin_register_settings();
	add_menu_page( 'Easyplugin', 'Easyplugin', 'manage_options', 'easyplugin', 'easyplugin_init' );    
}

function easyplugin_register_settings() {
    register_setting( 'easyplugin-settings-group', 'easyplugin-code' );
}

function easyplugin_init() {
?>

<style>
#easyplugin  h1 {
  color: #23282d;
  font-size: 25px;
}

#easyplugin .box h1 {
  color: #ffffff;
  font-size: 25px;
}

#easyplugin .box {
    border: solid 2px #00a8ff;
    border-style: inset;
    padding: 30px;
    border-radius: 17px;
    width: 50%;
    background: #23282d;
    color: #fff;
    margin-bottom: 45px;
}
#easyplugin .code {
    background-color: #f1f1f1;
    padding: 10px;
    margin-top: 20px;
    border: solid 1px #c6c6c6;
    color: #23282d;
    font-size: 20px;
    width: 100%;
    height: 250px
}

#easyplugin .help {
    color: #00cc00;
    font-size: 20px;
}
</style>

<div class="wrap" id="easyplugin">
   <h1>Easyplugin</h1>
   <form method="post" action="options.php">
    <?php settings_fields( 'easyplugin-settings-group' ); ?>
    <?php do_settings_sections( 'easyplugin-settings-group' ); ?>
      <h2><span id="general-settings">General Settings</span></h2>
      <table class="form-table">
         <tbody>
            <tr>
               <td colspan="2" style="padding: 0">
                  <div class="box">
                    <br><br>
                     <H1>Paste your code here:</H1>
                     <textarea class="code" name="easyplugin-code"><?php echo htmlentities( get_option( 'easyplugin-code' ) ); ?></textarea>
                     <br><br>
                     Use the following Shortcode at any page or post of your website:
                     <br><br>
                     [easyplugin]
                     <br><br>
                     <a class="help" href="https://delreyagency.com/#contact" target="_blank">Click here to get help to create any feature or plugin for your website</a>.
                  </div>
               </td>
            </tr>
         </tbody>
      </table>
      <?php submit_button(); ?>
   </form>
</div>
<?php
}

function easyplugin_shortcode(){
    set_error_handler("customError");
    $code = get_option( 'easyplugin-code' );
     if(strpos($code,"<"."?php")!==false){
          ob_start();
          eval("?".">".$code);
          $code = ob_get_contents();
          ob_end_clean();
     }
     return $code;
}

add_shortcode( 'easyplugin', 'easyplugin_shortcode' );
