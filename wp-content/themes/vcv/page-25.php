<?php get_header(); ?>
    <section id='content' class='container clearfix '>
<?php

// check if the repeater field has rows of data
if( have_rows('people_group') ):

 	// loop through the rows of data
    while ( have_rows('people_group') ) : the_row();

        // display a sub field value
        echo "<h1>".get_sub_field('group_name')."</h1>";
					
					// check if the repeater field has rows of data
			if( have_rows('person') ):
			
			 	// loop through the rows of data
			    while ( have_rows('person') ) : the_row();
			
			        // display a sub field value
			        echo "<div class='bio'>";
			        $img=get_sub_field('photo');
					$src=$img['sizes']['thumbnail'];
					echo "<div class='img'><img src='$src'  width='150' /></div>";
					?>
			       <p><strong><?php  the_sub_field('name'); ?></strong><br/>
					<?php  the_sub_field('position'); ?> </p>
					<?php if(get_sub_field('bio')){ ?>
								<div class='story'>
									<?php if($src): ?>
									<div class='img'><img src='<?php echo $src; ?>'  width='150' /></div>
									<?php endif; ?>
									<?php   the_sub_field('bio'); ?>
								</div>
					<?php } ?>
					</div>
					 <?
			
			    endwhile;
			
			else :
			
			    // no rows found
			
			endif;
					
		

    endwhile;

else :

    // no rows found

endif;

?>
    </section>
    <script>
    jQuery(document).ready(function(){
    	jQuery(".bio").hoverIntent(
    		function(){
    			jQuery(this).find('.story').fadeIn("fast");
    		},
    		function(){
    			jQuery(this).find('.story').fadeOut("fast");
    		}
    	);
    	});
    </script>
    <?php get_footer(); ?>