<?php get_header(); ?>
    <section id='content' class='container '>
        <h1>Search Results For: <?php echo $_GET["s"];  ?></h1>
        
 <?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
	?>
		<article class='news clearfix'>
			<?
			if( get_post_type()=="legsilators"){ ?>
					
								<div class='img'> <?php the_post_thumbnail('thumbnail') ?></div>
								
								<div class='copy'>
									<h2><a href='<?php  the_permalink(); ?>'><?php the_title(); ?></a></h2>
									<p>
										<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
										<span class='towns'><?php the_field('towns'); ?></span>
									</p>
									
									<?php 
									$cscore=getCurrentScore(get_the_id());
						
									$year=$cscore[0];
									$currentYear=$cscore[1];
									
									$lifetime=get_post_meta( get_the_id(), 'lifetime_score', true);
									?>
									<p><?php echo $year ?> Score: <strong><?php echo $currentYear; ?></strong> Lifetime Score: <strong><?php echo $lifetime; ?>%</strong></p>


								</div>
		<?	
			} else { ?>
					<h2 ><a href='<?php  the_permalink();  ?>'><?php the_title(); ?></a></h2>
		<?php if(has_post_thumbnail()){
				the_post_thumbnail('thumbnail');
			}
		
		the_excerpt();
			}
		
	
		?>
        </article>
        <?
	} // end while
} // end if
?>
    </section>
    
    <?php get_footer(); ?>