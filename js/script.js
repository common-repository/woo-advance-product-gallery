jQuery.noConflict();
jQuery(document).ready(function($)
{	
	//$('.woocommerce-product-gallery__image').zoom({href: this.src});
	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;
	 if(!isMobile)
	 {
	 	
	 	// Instantiate EasyZoom instances
		//var $easyzoom = $('.woocommerce-product-gallery__image').easyZoom();

		// Get an instance API
		//var api = $easyzoom.data('easyZoom');
		//$('.woocommerce-product-gallery__image a').zoom();
 		
		 $('.woocommerce-product-gallery__image').find('img').each(function()
		 {
		 	$(this).addClass('zoom_image');
			$('.zoom_image').imagezoomsl({
					zoomrange : [ 2.12 , 12 ], 
	          magnifiersize : [ 530 , 340 ], 
	          scrollspeedanimate : 10 , 
	          loopspeedanimate : 5 , 
	          cursorshadeborder : "10px solid black" , 
	          magnifiereffectanimate : "slideIn" 
			});
			
		 })
	 }
	 
	

});