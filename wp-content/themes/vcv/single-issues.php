<?php get_header(); ?>
    <section id='content' class='container clearfix '>        
 <?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		
		$icon =get_field('icons');  
		$src=$icon['url'];
	?>
		<h1><div class='img'><img src='<?php  echo $src ?> ' width="70"' align='middle'  /></div><?php the_title(); ?></h1>
		
        <?php the_content(); ?>
   
    </section>
    
    <footer class='container content'>
    	<?php the_field("footer_content"); ?>
    </footer>
    
            <?php
	} // end while
} // end if
?>
    <?php get_footer(); ?>