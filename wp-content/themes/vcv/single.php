<?php get_header(); ?>
    <section id='content' class='container clearfix '>
        <h1>News</h1>
        
 <?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
	?>
		<h2><?php the_title(); ?></h2>
		<time><?php the_date(); ?></time>
		<?php if(has_post_thumbnail()){
			the_post_thumbnail('large');
		}?>
        <?php the_content(); ?>
       
        <?
	} // end while
} // end if
?>
        
    </section>
    <?php get_footer(); ?>