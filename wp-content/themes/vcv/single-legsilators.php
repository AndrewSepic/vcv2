<?php get_header(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/tablesorter-master/jquery.tablesorter.min.js"></script>
	<section id='pageBanner'>
		<div  class='inner container'><h1 >Legislative Scorecard</h1></div>		
		</section>
    <section id='content' class='container clearfix'>
		
		<?php 
				$chamber=wp_get_post_terms( get_the_id(), 'chamber' );	
				$chamber=$chamber[0]->name;
			 ?>
		
		<header id='bio' class='clearfix'>
			<section class='main clearfix'>
				<div class='img'>
				<?php the_post_thumbnail('thumbnail'); ?>
				</div>
				<div class='copy'>
					<h2><?php the_title(); ?></h2>
					
					<?php if ($chamber=="Senate"): ?>
						<p>
						<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
						<?php 
						if( get_field('second_party')){ ?>
							<span class='party second'><?php echo substr(get_field('second_party'),0,1); ?></span>
						<?php }
						 ?>
						<span class='towns'><?php the_field('towns'); ?></span>
					</p>
					<?php else: ?>
					<p>
						<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
						<?php 
						if( get_field('second_party')){ ?>
							<span class='party second'><?php echo substr(get_field('second_party'),0,1); ?></span>
						<?php }
						 ?>
						<span class='towns'><?php echo get_district(get_the_id()); ?></span>
					</p>
					<p>
						<span class='towns'><?php the_field('towns'); ?></span>
					</p>
					
					<?php endif; ?>
					<?						$year=getCurrentYear();
						$cscore=getCurrentScore(get_the_id(),$year );
						$year=$cscore[0];
						$currentYear=$cscore[1];
						
						$lifetime=get_post_meta( get_the_id(), 'lifetime_score', true);
					?>
					<p id="scores"><span><?php echo $year; ?>  Score: <strong><?php echo $currentYear; ?></strong> </span><span>Lifetime Score:  <strong><?php echo $lifetime ?>%</strong> </span></p>
					</div>
				</section>	
				<aside class='contactInfo'>
					<h2>Contact your legislator</h2>
				<?
				$phones=	get_field("phones");
				$email= 	get_field("email");
				$fb=	get_field("facebook_id");
				$tw=	get_field("twitter_id");
				$websites=	get_field("websites");
				
				if($phones){
					$phone=explode(',',$phones);
					foreach($phone as $p){
					echo "<a href='tel:$p' class='phone'>$p</a>";
					}
				}

				if($email){
					$email=explode(',',$email);
					foreach($email as $e){
						//if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
								echo "<a href='mailto:$e' class='email'>$e</a>";
						//}
					}
					
					if($fb){
						$link="
						<a href='http://facebook.com/$fb' target='_blank' class='fb'>
						
						 facebook.com/$fb</a>";
						echo $link;
					}
					
					if($tw){
						$link="
						<a href='http://twitter.com/$tw' target='_blank' class='tw'>
						<img src='".get_template_directory_uri()."/img/twitter.png' align='bottom' width='18' >
						twitter.com/$tw
						</a>";
						echo $link;
					}
				}
				?>	
				</address>
		</header>
        
       <?php /* bills */	   	   $terms = get_terms( array( 'taxonomy' => 'scorecard', 'hide_empty' => true) );	   	   $years=array();	   foreach($terms as $t ){		   $y= $t->name;		   array_push($years, $y);	   }	   	   rsort($years,SORT_NUMERIC);	   	   echo "<nav class='tabs'>";	   foreach($years as $y ){			$active='';			if($y==$year){			   $active='active';		   }		   		   echo "<a href='' data-year='$y' class='tab $active'>".$y." Bills</a>";	   }	   echo "</nav>";	   		foreach($terms as $t ){			$y= $t->name;						 getSingleBills(get_the_id(), $y, $year);;		}		  	   
        ?>
     			<div id="key" class='clearfix'>
     				<div id="pro"><img src='<?php echo get_template_directory_uri(); ?>/img/thumbs_up_big.gif' />
     				Pro-Environment Vote
     				</div>
     				
     				<div>
     				<img src='<?php echo get_template_directory_uri(); ?>/img/thumbs_down_big.gif' />
     				Anti-Environment Vote
     				</div>
     				
     				<div>
     				<img src='<?php echo get_template_directory_uri(); ?>/img/NIO.gif' />
     				Not in Office
     				</div>
     				
     				<div>
     				<img src='<?php echo get_template_directory_uri(); ?>/img/Absent.gif' />
     				Absent
     				</div>
     				
     				<div>
     				<img src='<?php echo get_template_directory_uri(); ?>/img/Presiding.gif' />
     				Presiding
     				</div>
     				
     				<div>
     				<img src='<?php echo get_template_directory_uri(); ?>/img/Abstain.gif' />
     				Abstain
     				</div>
     				<div>
     				<img src='<?php echo get_template_directory_uri(); ?>/img/Suspended.gif' />
     				Suspended
     				</div>
     				
     			</div>
     			
    </section>
<script>	jQuery(".tab").click(function(){						jQuery(".tab.active").removeClass("active");		jQuery(this).addClass("active");		var y=jQuery(this).attr("data-year");		var activeSection='.scorecardYear'+y;		jQuery(".scorecardYear").removeClass("active");				jQuery(activeSection).addClass("active");				return false;	});</script>
    <?php get_footer(); ?>