jQuery(document).ready(function(){
		jQuery("#searchsubmit").click(function(){
			var term=jQuery("#term");
			if(term.width()==0){
				term.animate({
				    width: 200,
				  }, 250,
				  function(){
				  	 term.focus();
				  });
			}
			
		});
		
		jQuery("#primary li ").hoverIntent(
			function(){
				if(jQuery(document).width()>1023){
					jQuery(this).find('ul').slideDown('fast');
				}
			},
			function(){
				if(jQuery(document).width()>1023){
					jQuery(this).find('ul').slideUp('fast');
				}	
			}
		);
		
		jQuery("#topJoinBtn").click(function(){
			/*jQuery(this).addClass("active");*/			/*jQuery("#joinBar").fadeIn("fast");*/						jQuery("#shadow").fadeIn("fast");			jQuery("#popupForm").css("display","flex");
			return false;
		});
		jQuery("#footerJoinUs").click(function(){						jQuery("#shadow").fadeIn("fast");			jQuery("#popupForm").css("display","flex");			return false;		});		
		jQuery("#joinBar .close").click(function(){
			jQuery("#joinBar").fadeOut("fast");
			jQuery("#topJoinBtn").removeClass("active");
			return false;
		});
				
		jQuery(".mobileToggle a").click(function(){
			if(jQuery("nav#primary #menu").first().css("display")=="none"){
				jQuery("nav#primary ul#menu").first().slideDown("fast");
			} else {
				jQuery("nav#primary ul#menu").first().slideUp("fast");
			}
			return false;
		});			
		jQuery("#popupForm .inner .close").click(function(){			jQuery("#shadow").fadeOut("fast");			jQuery("#popupForm").fadeOut("fast");			return false;		});					jQuery("#shadow").click(function(){			jQuery("#shadow").fadeOut("fast");			jQuery("#popupForm").fadeOut("fast");			return false;		});				jQuery("#popupForm").click(function(e){			 if (e.target !== this)				return;			jQuery("#shadow").fadeOut("fast");			jQuery("#popupForm").fadeOut("fast");			return false;		});
});		