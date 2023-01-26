<?php get_header(); ?>
    <section id='content' class='container '>
        <h1>News</h1>
        
 <?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
	?>
		<article class='news clearfix'>
		<h2><a href='<?php  the_permalink();  ?>'><?php the_title(); ?></a></h2>
		<time><?php the_date(); ?></time>
		<?php if(has_post_thumbnail()){
			the_post_thumbnail('thumbnail');
		}?>
        <?php the_excerpt(); ?>
        </article>
        <?
	} // end while
} // end if
?>
    </section>
    
    <?php get_footer(); ?>