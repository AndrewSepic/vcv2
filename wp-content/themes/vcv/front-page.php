<?php get_header(); ?>
    <section id='banner'>
    	<nav></nav>
    	<div id="arrows">
    	<a href='' id='prev' class='nav'></a>
    	<a href='' id='next' class='nav'></a>
    	</div>
    	<div id="slideshow">
  <?php  	
    	// check if the repeater field has rows of data
if( have_rows('slideshow') ):

 	// loop through the rows of data
    while ( have_rows('slideshow') ) : the_row();
	 	$img=get_sub_field('image'); 
		$offset=get_sub_field("offset");
		if($offset>0){
			$offset="margin-top:".$offset."px;";
		} else {
			$offset='';
		}
		
	?>
	<div class='slide' style="background-image: url(<?php echo $img["url"]; ?>)">
		<div class='table' style="<?php  //echo $offset;  ?>">
	    <div class='container '>
        <?php 
        // display a sub field value
        the_sub_field('text');
		  ?>
      	</div>
      	</div>
      </div>
      <?php
    endwhile;

endif;
?>

	      </div>
  
    </section>
    
    <section id="icons">
    	<div class='container '>
				
				<div class='intro'><?php the_field("leader_intro"); ?></div>
				<div class='clearfix'>
<?php

// check if the repeater field has rows of data
if( have_rows('intro_features') ):

 	// loop through the rows of data
    while ( have_rows('intro_features') ) : the_row();

        // display a sub field value
        $icon=get_sub_field('icon');
		$src=$icon['url'];
?>
		<div class='feature'>
		 	<a href='<?php the_sub_field("link"); ?>' class='imgHolder'><img src="<?php echo $src;  ?>" height='70' /></a>
		  	<h3><?php  the_sub_field('title'); ?></h3>
		   	<p><?php  the_sub_field('text'); ?></p>
		  </div>
<?php
    endwhile;

endif;

?>
		        </div>
		</div>	        
        
    </section>
    
    <section id="ourWork">
		<div class='container '>

	        <h2>
	            <span class='line'></span>
	            <?php the_field('our_work_title'); ?>
	            <span class='line'></span>
	        </h2>
	        
	        <?php the_field('our_work_content'); ?>
	        
	        <div id='buttons'>
	            <a href='<?php  the_field('button_1_Link'); ?>'><?php the_field('button_1_text'); ?></a>
	            <a href='<?php  the_field('button_2_link'); ?>'><?php the_field('button_2_text'); ?></a>
	        </div>

        </div>
    </section>
    
    <section id="coreIssues">
    	<div class='container '>

	        <h2>
	            <span class='line'></span><?php the_field("core_issues_title"); ?><span class='line'></span>
	        </h2>
	        
	        <div class='intro'><?php  the_field('core_issues_text'); ?></div>
	        	        
	        <div id='campaignIcons' class='clearfix'>
	            <?php

// check if the repeater field has rows of data
if( have_rows('features') ):

 	// loop through the rows of data
    while ( have_rows('features') ) : the_row();

        // display a sub field value
        $icon=get_sub_field('icon');
		$src=$icon['url'];
?>
		<div class='feature'>
		 	<div class='icon_circle_holder'><div class='img'><a href='<?php  the_sub_field('link');  ?>'><img src="<?php echo $src;  ?>" height='70' /></a></div></div>
		   	<p><?php  the_sub_field('text'); ?></p>
		  </div>
<?php
    endwhile; 

endif;

?>
	        </div>
	        </div>
    </section>
    
    <script>
    	
    	setUpCircles();
    	setInterval(function(){ switchSlide(); }, 10000);
    	var pause=false;
    	
    	jQuery("#next").click(function(){
    		advanceSlide();
    		return false;
    	});
    	
    	jQuery("#prev").click(function(){
    		reverseSlide();
    		console.log("prev");
    		return false;
    	});
    	
    	var activeSlide=jQuery(".slide").first();
    	
    	function setUpCircles(){
    		var num=jQuery(".slide").length;
    		for(var x=0; x<num;x++){
 				var active='';
    			if (x==0){
    				active=' active ';
    			}
    			jQuery("#banner nav").append("<a href='' class='indicator"+active+"'></a>");
    		}
    	}
    	
    	function switchSlide(){
    		advanceSlide();
    	}
    	
    	function advanceSlide(){
    		
    		if(pause==false){
    			
    			var pos=jQuery(activeSlide).index();
	    		var i=pos+1;
	    		var L=jQuery(".indicator").length-1;
	    		if(i>L){ i=0; }

	    		jQuery(".indicator").removeClass("active");
	    		jQuery(".indicator").eq(i).addClass("active");
	    		
	    		var next=activeSlide.next();
	    		if(next.length==0){
	    			next=jQuery(".slide").first();
	    		}
	    		
				pause=true;
	    		activeSlide.fadeOut("600");
	    		next.fadeIn("600", function(){
	    			pause=false;
	    		});
	    		activeSlide=next;
    			
    		}
    		
    	}
    	
    	function reverseSlide(){
    		
    		if(pause==false){
    			
    			var pos=jQuery(activeSlide).index();
	    		var i=pos+1;
	    		var L=jQuery(".indicator").length-1;
	    		if(i>L){ i=0; }

	    		jQuery(".indicator").removeClass("active");
	    		jQuery(".indicator").eq(i).addClass("active");
	    		
	    		var next=activeSlide.prev();
	    		if(next.length==0){
	    			next=jQuery(".slide").last();
	    		}
	    		
				pause=true;
	    		activeSlide.fadeOut("600");
	    		next.fadeIn("600", function(){
	    			pause=false;
	    		});
	    		activeSlide=next;
    		}
    	}
    	
    var cheight=0;
    	jQuery(".feature img").hover(
    		function(){
	    		cheight=jQuery(this).height();
	    		var enlarged=cheight*1.1;
	    		jQuery(this).animate({
				    left: "-5px",
				    height: enlarged
			  }, 200);
    		},
    		function(){
    			
    			jQuery(this).animate({
				    left: "0",
				    height: cheight
			  }, 200);
    		}
    	);
    	
    	jQuery("#campaignIcons .feature img").hover(
    		function(){
    			var parent=jQuery(this).parent().parent();
    			cheight=jQuery(this).height();
	    		var enlarged=cheight*1.1;
	    			parent.animate({
				    left: "-5px",
				    height: enlarged,
				    width: enlarged
			  }, 200);
    		},
    		function(){
    			var parent=jQuery(this).parent().parent();
    				parent.animate({
				    left: "0",
				    height: cheight,
				    width:cheight
			  }, 200);
    		}
    	);
    	
    </script>

    <?php get_footer(); ?>