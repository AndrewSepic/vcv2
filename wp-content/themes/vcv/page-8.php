<?php 
// Issues Page
	get_header(); ?>
    <section id='content' class='container clearfix'>
        <h1><?php the_title(); ?></h1>
                <?php the_post_thumbnail('medium'); ?>
		<div id='intro' class='intro'>
			<div class="content">
        		<?php the_content(); ?>
			</div>
			<nav>
				<p class='descriptor'>
					<?php the_field('past_issues_title'); ?>
				</p>
				<?php the_field('past_issues'); ?>
			</nav>
		</div>
    </section>
    <section id='actions' class='container '>
    
    <?php
    
    $args = array(
		'post_type' => 'issues',
		'posts_per_page' => '-1',
		'orderby'=>  'menu_order',
		'order'=>'asc'
	);

	// The Query
	$the_query = new WP_Query( $args );
	
	// The Loop
	if ( $the_query->have_posts() ) {
	
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			?>
				<!-- action -->
	    	<div class='action' class='clearfix'>
	    		<?php  
	    		$icon =get_field('icons');  
				$src=$icon['url'];
	    		?>

			 	<div class='img'><img src='<?php echo $src;  ?>' height='70'></div> 
			 	<div class='description'>
			 		<header>
				   		<h2><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h2>
				   		<a href='#' class='toggle'><span></span></a>
		    			<div class='clearme'></div>
		    		</header>
		    		<footer>
		    			<?php the_excerpt();  ?>
		    			<a href='<?php the_permalink(); ?>'  class='readmorelink'>Read more &raquo;</a>
		    		</footer>
	    		</div>
	    		<div class='clearme'></div>
	    	</div>
	    	<?php
		}
		
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
?>
   	
    </section>
    <footer class='container content'>
    	<?php the_field("footer_content"); ?>
    </footer>
    
    <script>
    	/*jQuery(".action h2 a").click(function(){
    		toggleFooter(this);
       		return false; 		
    	});*/
    	jQuery(".action .toggle").click(function(){
    		toggleFooter(this);
    		return false;
    	});
    	function  toggleFooter(self){
    		var footer=jQuery(self).parent().parent().parent().find('footer');
    		var toggle=jQuery(self).parent().parent().parent().find('.toggle');
    		if(footer.css("display")=="none"){
    			 footer.slideDown('fast');
    			 toggle.addClass('down');
    		} else {
    			footer.slideUp('fast');
    			toggle.removeClass('down');
    		}
    	}
    </script>
    <?php get_footer(); ?>