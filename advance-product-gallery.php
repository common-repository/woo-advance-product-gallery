<?php 
/*Plugin Name: WooCommerce Advance Product Gallery 
	Description: Zoom effect on product gallery images. also open images in full screen popup.
	Author: Acespritech Solutions Pvt. Ltd.
	Author URI: https://acespritech.com/
	Version: 2.1.0
	Domain Path: /languages/
	Requires WooCommerce: 2.2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


register_activation_hook(__FILE__, 'wapg_activation_logic');

function wapg_activation_logic() {
    //if dependent plugin is not active
    if (!class_exists( 'WooCommerce' ) ) {
	  	deactivate_plugins(plugin_basename(__FILE__));
	} 
}

	

add_action('wp_enqueue_scripts','wapg_zoom_script');
function wapg_zoom_script() 
{
   
    if ( is_product() )
    {
     	   	
	   	$zoom_setting = get_option("wapg_zoom_setting");

	   	if($zoom_setting == 'inner'){

	   	}
	   	elseif($zoom_setting == 'outer'){
	   		remove_theme_support( 'wc-product-gallery-zoom' );
	   		wp_enqueue_script( 'zoom-image1', plugins_url( '/js/zoomsl-3.0.js', __FILE__ ),array( 'jquery' ));

	   		wp_enqueue_script( 'zoom-image2', plugins_url( '/js/script.js', __FILE__ ),array( 'jquery' ));
	   	}

	   	$gallery_position = get_option("wapg_gallery_position");

	   	if($gallery_position == 'vertical-right'){
	   		wp_enqueue_style( 'gallery-vertical-right-css', plugins_url( '/css/vartical-right.css', __FILE__ ));
	   	}
	   	elseif($gallery_position == 'vertical-left'){
	   		wp_enqueue_style( 'gallery-vertical-left-css', plugins_url( '/css/vartical-left.css', __FILE__ ));
	   	}
	   	elseif($gallery_position == 'horizontal'){
	   		wp_enqueue_style( 'gallery-horizontal-css', plugins_url( '/css/horizontal.css', __FILE__ ));
	   	}


	   	wp_enqueue_style( 'zoom_style1', plugins_url( '/css/style.css', __FILE__ ));  
	   	wp_enqueue_style( 'dashicons' );

	   	wp_enqueue_script( 'wapg-zoom-pooper', plugins_url( '/js/popper.min.js', __FILE__ ),array( 'jquery' )); 

	   	wp_enqueue_script( 'wapg-zoom-image3', plugins_url( '/js/bootstrap.min.js', __FILE__ ),array( 'jquery' ));    
 		wp_enqueue_style( 'wapg-zoom_style', plugins_url( '/css/bootstrap.min.css', __FILE__ )); 

 		wp_enqueue_script( 'zoom-script2', plugins_url( '/js/script2.js', __FILE__ ),array( 'jquery' ));
	   	  
	   	
    } 
    
}


add_action('admin_menu', 'wapg_menu');
function wapg_menu()
{
	if(current_user_can('edit_others_posts'))
	{
    	add_menu_page('Advance Gallery', 'Advance Gallery', 'manage_options', 'image_zoom_setting', 'wapg_image_zoom_setting' , 'dashicons-format-gallery',  61);
    }
}

function wapg_image_zoom_setting(){

	$zoom_setting = esc_attr(get_option("wapg_zoom_setting"));
	$gallery_position = esc_attr(get_option("wapg_gallery_position"));
	@$action = sanitize_text_field($_GET['update']);
	if($action == 'success'){
		?>
		<div class="updated notice notice-success is-dismissible"><p>Settings Saved!</p></div>
	<?php }
	?>

	<h1>Advance Product Gallery Configuration</h1>
	<form method="post" action="">
		<table class="form-table">
			<tr>
				<th>Zoom Style</th>
				<td>
					<select name="zoom-style">
						<option selected="" disabled="">Select Option</option>
						<option <?php if($zoom_setting == 'inner'){ echo 'selected';} ?> value="inner">Default</option>
						<option <?php if($zoom_setting == 'outer'){ echo 'selected';} ?> value="outer">Outer</option>
					</select>
				</td>
			</tr>

			<tr>
				<th>Thumbnail Style</th>
				<td>
					<select name="gallery-style">
						<option selected="" disabled="">Select Option</option>
						<option <?php if($gallery_position == 'horizontal'){ echo 'selected';} ?> value="horizontal">Horizontal</option>
						<option <?php if($gallery_position == 'vertical-left'){ echo 'selected';} ?> value="vertical-left">Vertical Left</option>
						<option <?php if($gallery_position == 'vertical-right'){ echo 'selected';} ?> value="vertical-right">Vertical Right</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>
					<button name="save_zoom_setting" class="button-primary">Submit</button>
				</td>
				
			</tr>
		</table>
	</form>
	<?php

	if(isset($_POST["save_zoom_setting"])){
		

		$zoom_setting = sanitize_text_field($_POST["zoom-style"]);

		$gallery_position = sanitize_text_field($_POST["gallery-style"]);

		update_option("wapg_zoom_setting", $zoom_setting);
		update_option("wapg_gallery_position", $gallery_position);

		 

		$redirect = add_query_arg( 'page', 'image_zoom_setting', $redirect );

		
		wp_redirect( $redirect.'&update=success' );
		exit;

	}
}


add_action('woocommerce_after_single_product_summary', 'wapg_html_below_thumbnails', 9);
function wapg_html_below_thumbnails() 
{  
	

?>
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="col-sm-12">
          	<div class="w3-content">
          	<?php 
          		global $product;
				$product_id = $product->get_ID();
			    $product = new WC_product($product_id);
			    $attachment_ids = $product->get_gallery_image_ids();
			    $i = 1;

			    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
			    ?>

    			<img class="mySlides" src="<?php  echo $image[0]; ?>" data-id="<?php echo $product_id; ?>">
    			<?php

          		foreach( $attachment_ids as $attachment_id ) 
			        {
			          // Display the image URL
			          $Original_image_url = wp_get_attachment_url( $attachment_id );
			        
          	?>        		
				  <img class="mySlides" src="<?php echo $Original_image_url; ?>" >
				  
			<?php } ?>
				</div>	
				<div class="w3-center">
				  <div class="w3-section">
				    <button class="w3-button prev" onclick="plusDivs(-1)">❮</button>
				    <button class="w3-button next" onclick="plusDivs(1)">❯</button>
				  </div>
				  <div class="nav-image">
				  	<img class="nav-img" src="<?php  echo $image[0]; ?>" onclick="currentDiv(<?php echo $i; ?>)">
				  </div>
				  <?php 
				  foreach( $attachment_ids as $attachment_id ) 
			        {
			        	$Original_image_url = wp_get_attachment_url( $attachment_id );
				  	?> 
				  		<div class="nav-image">
				  			<img class="nav-img" onclick="currentDiv(<?php echo $i+1; ?>)" src="<?php echo $Original_image_url; ?>">
				  		</div>
				  	<?php $i++;
				  	}
				  	?>
				  
				</div>
          </div>
    	</div>
       
      </div>
  </div>
</div>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-red", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-red";
}
</script>
   
<?php
}

?>