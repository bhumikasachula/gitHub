<style>
.center-div {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
	min-height: 80vh	
}

#btn_login {
    color: #fff!important;
    background-color: #0f0f0f;
    border-color: #0f0f0f;
    position: relative;
    letter-spacing: 0.02em;
    /* display: inline-flex; */
    align-items: center;
    width: 100%;
    margin-bottom: 10px;
    padding: 15px 80px 15px 80px;
    border-radius: 50px;
    text-align: center;
    font-size: 24px;
}
</style>

<?php
/*
Plugin Name: Sometyme
Description: Plugin for session recording tool
Version: 1.0
Author: Devise Software Solutions Pvt. Ltd.
*/

// Your plugin code goes here

function sometyme_settings_page() {
    add_menu_page('Sometyme', 'Sometyme', 'manage_options', 'sometyme', 'sometyme_form');
}

function sometyme_form() {
	$plugin_dir = plugin_dir_path(__FILE__);
    $jsFilePath = $plugin_dir . 'sometyme.js';
	
	
	$jsContent = "";
	 
		if (file_exists($jsFilePath)){
			$jsContent = file_get_contents($jsFilePath) or die(error_get_last()); 
		}
    ?>
    <div class="wrap center-div ">
		<div class="brand-logo text-center" style="margin-top: -40px;">
			<a href="https://app.sometyme.com/login" class="logo-link">
				<img class="logo-dark logo-img logo-img-lg" src="https://app.sometyme.com/assets/logo/svg/sometyme.svg" alt="sometyme" style="max-height: 210px">
			</a>
		</div>
		<div class="form-group">
			<a href="https://app.sometyme.com/login" target="_blank"><button type="button"   id="btn_login" class="btn btn-lg btn-primary btn-block">Sign In</button></a>
		</div>	
		<h2>Follow this instruction to Install Sometyme</h2>
		<ol>
			<li> Register with sometyme</li>
			<li> Add your website in Account setting</li>
			<li>Generate Script</li>
			
		</ol>
							       
		<form method="post" action=" " id="smForm" name="smForm">
		   <input type="textbox" id="smscript" name="smscript" value="<?php echo get_site_url();?>" readonly disabled="1" >		  
		   <input type="button" class="button-primary" name="getScript" id="getScript" value="<?php if( $jsContent!="")echo 'Reconfigure'; else echo 'Generate Script'; ?>">
		</form>
		
		<div id="sm-resultDiv"/>
    </div>
    <?php
}

add_action('admin_menu', 'sometyme_settings_page');


function localize_custom_script() {
    $custom_data = array(
        'website' => 'ffhfh.com'
    );

    wp_localize_script('custom-script', 'customSettings', $custom_data);
}

add_action('wp_enqueue_scripts', 'localize_custom_script');

function enqueue_jquery() {
    // Register jQuery from the WordPress core
	$custom_data = array(
        'sometymeId' => 'R4USBG6WQ5'
       
    ); 
    wp_deregister_script('jquery');
    wp_register_script('jquery', plugins_url('sometyme/sometyme.js'), array(), 1.0, true);

    // Enqueue jQuery
    wp_enqueue_script('jquery', plugins_url('sometyme/sometyme.js'),$custom_data);
}

add_action('wp_enqueue_scripts', 'enqueue_jquery');

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
       $(document).ready(function() {
		var webCode;
        $('#getScript').click(function(e) {
           e.preventDefault();
		   var smscript = $('#smscript').val();
		  
		   $.ajax({
                url: 'https://app.sometyme.com/mg_services/ws_user_account.asmx/Fn_get_website_script?website='+smscript, // Replace with your web service URL
                type: 'GET',
                success: function(data) { 
					
					if(data.is_success == false){
						 $('#sm-resultDiv').html("Please SignUp");
					}else{
							
						webCode = data.script_id;
					
						
						if(webCode != 'undefined'){
						  $.ajax({
								type: "GET",
								url: "<?php echo plugins_url('sometyme/generateScript.php');?>", // Replace with your PHP script
								data: 'smscript='+webCode ,
								success: function(response) {
									$('#sm-resultDiv').html(response);
									return false;
								}
							});
						}
					}					
                   
                    // Process the data returned from the web service
                },
               
            });
			
			
           
        });
		
		
    });
</script>
	
