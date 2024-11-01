jQuery(document).ready(function($)
{	
	//$('.woocommerce-product-gallery__image').zoom({href: this.src});
	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;
	 if(!isMobile)
	 {
	 		 
	 	$(document).on('click','.tracker',function()
		 { 	
		 	
			var image_path = $(".carousel-inner").find('.active').find('img').attr('src');
			$('#myModal').modal('show');
		});
	 }
	 
	

});