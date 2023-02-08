<?php
require("GoogleApi.php");
//require("scorecardFunctions.php");

function mytheme_enqueue_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri(),array(),'3.0' );
	wp_enqueue_script( 'scripts', get_template_directory_uri()."/js/script.js" , false, '3.0', true );
	
	wp_enqueue_script( 'jQuery' );
	//wp_enqueue_script( 'jquery-ui-core' );
	//wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'hoverIntent' );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_style' );


add_action( 'after_setup_theme', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'primary', __( 'Primary Menu', 'theme-slug' ) );
} 

add_theme_support( 'post-thumbnails' ); 

add_action( 'init', 'create_post_type' );
function create_post_type() {
	
	$labels = array(
		'name'              => _x( 'Actions', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Action', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Actions', 'textdomain' ),
		'all_items'         => __( 'All Actions', 'textdomain' ),
		'parent_item'       => __( 'Parent Action', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Action:', 'textdomain' ),
		'edit_item'         => __( 'Edit Action', 'textdomain' ),
		'update_item'       => __( 'Update Action', 'textdomain' ),
		'add_new_item'      => __( 'Add New Action', 'textdomain' ),
		'new_item_name'     => __( 'New Action Name', 'textdomain' ),
		'menu_name'         => __( 'Take Action', 'textdomain' ),
	);
	
  register_post_type( 'actions',
    array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'menu_icon'=>'dashicons-testimonial',
      'supports'=>array('title','editor','excerpt','thumbnail', 'page-attributes')
    )
  );
 
 $labels = array(
		'name'              => _x( 'Legislators', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Legislator', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Legislators', 'textdomain' ),
		'all_items'         => __( 'All Legislators', 'textdomain' ),
		'parent_item'       => __( 'Parent Legislator', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Legislator:', 'textdomain' ),
		'edit_item'         => __( 'Edit Legislator', 'textdomain' ),
		'update_item'       => __( 'Update Legislator', 'textdomain' ),
		'add_new_item'      => __( 'Add New Legislator', 'textdomain' ),
		'new_item_name'     => __( 'New Legislator', 'textdomain' ),
		'menu_name'         => __( 'Legislators', 'textdomain' ),
	);
	
  register_post_type( 'legsilators',
    array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'menu_icon'=>'dashicons-groups',
      'supports'=>array('title','editor','excerpt','thumbnail', 'custom-fields') ,
	  	'rewrite'           => array( 'slug' => 'legislators' ),
    )
  );
  
  	$labels = array(
		'name'              => _x( 'Chambers', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Chamber', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Chambers', 'textdomain' ),
		'all_items'         => __( 'All Chambers', 'textdomain' ),
		'parent_item'       => __( 'Parent Chamber', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Chamber:', 'textdomain' ),
		'edit_item'         => __( 'Edit Chamber', 'textdomain' ),
		'update_item'       => __( 'Update Chamber', 'textdomain' ),
		'add_new_item'      => __( 'Add New Chamber', 'textdomain' ),
		'new_item_name'     => __( 'New Chamber', 'textdomain' ),
		'menu_name'         => __( 'Chambers', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'chamber' ),
	);

	register_taxonomy( 'chamber', array( 'legsilators', 'bills' ), $args );
	
  
  
  $labels = array(
		'name'              => _x( 'Bills', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Bill', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Bills', 'textdomain' ),
		'all_items'         => __( 'All Bills', 'textdomain' ),
		'parent_item'       => __( 'Parent Bill', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Bill:', 'textdomain' ),
		'edit_item'         => __( 'Edit Bill', 'textdomain' ),
		'update_item'       => __( 'Update Bill', 'textdomain' ),
		'add_new_item'      => __( 'Add New Bill', 'textdomain' ),
		'new_item_name'     => __( 'New Bill Name', 'textdomain' ),
		'menu_name'         => __( 'Bills', 'textdomain' ),
	);
	
  register_post_type( 'bills',
    array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'menu_icon'=>'dashicons-media-text',
      'supports'=>array('title','editor','excerpt','thumbnail') 
    )
  );
  
    $labels = array(
		'name'              => _x( 'Scorecards', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Scorecard', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Scorecards', 'textdomain' ),
		'all_items'         => __( 'All Scorecards', 'textdomain' ),
		'parent_item'       => __( 'Parent Scorecard', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Scorecard:', 'textdomain' ),
		'edit_item'         => __( 'Edit Scorecard', 'textdomain' ),
		'update_item'       => __( 'Update Scorecard', 'textdomain' ),
		'add_new_item'      => __( 'Add New Scorecard', 'textdomain' ),
		'new_item_name'     => __( 'New  Scorecard', 'textdomain' ),
		'menu_name'         => __( 'Scorecards', 'textdomain' ),
	);
  
  $args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'scorecard' ),
	);

	register_taxonomy( 'scorecard', array( 'bills' ), $args );
  
}

 $labels = array(
		'name'              => _x( 'Issues', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Issue', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Issues', 'textdomain' ),
		'all_items'         => __( 'All Issues', 'textdomain' ),
		'parent_item'       => __( 'Parent Issue', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Issue:', 'textdomain' ),
		'edit_item'         => __( 'Edit Issue', 'textdomain' ),
		'update_item'       => __( 'Update Issue', 'textdomain' ),
		'add_new_item'      => __( 'Add New Issue', 'textdomain' ),
		'new_item_name'     => __( 'New  Issue', 'textdomain' ),
		'menu_name'         => __( 'Issues', 'textdomain' ),
	);
	
  register_post_type( 'issues',
    array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'menu_icon'=>'dashicons-list-view',
      'supports'=>array('title','editor','excerpt','thumbnail') 
    )
  );

function get_district($postId) {
	$meta=get_post_meta($postId, 'division_id');
	$division_id= $meta[0];
	$div_a=explode(":",$division_id);
	$district=ucfirst(end($div_a));
	return $district;
}

function getCurrentScore($postid,$scoreYear){
	
	$year=$scoreYear;
	
	$currentScore_en=get_post_meta( $postid , 'ScorecardScores', false);
	if (isset($currentScore_en[0])) {
		($currentScore_en[0]).$scoreYear;
	}
	$currentScore=json_decode($currentScore_en[0], true);

	
	if(count($currentScore)>0 && $scoreYear){
		
		$key="year".$scoreYear;
		if(array_key_exists($key, $currentScore)===false){
			return false;
		}	
		 $cscore= $currentScore[$key];
		 if(is_numeric($cscore)) {
			$cscore=round($cscore)."%";
		 } else if( $cscore=="p" || $cscore=='P') {
			$cscore="P";
		 } else {
			$cscore=false; 
		 } 
	
		 return array($year, $cscore);
		 
	}
}

function getCurrentYear(){
	$years=array();
	$terms = get_terms( array( 'taxonomy' => 'scorecard', 'hide_empty' => true) );
	foreach($terms as $t ){
		array_push($years, $t->name);
	}
	 $year= end($years);
	
	return $year;
	
}

function printBills($chamber,$year,$default){ 
	
	$active='';
	if($year==$default){
			$active=' active ';
	} 
	
echo "<section class='scorecardYear$year scorecardYear $active'>";

	
$args=array(
					'post_type'=>'bills',
					'order'=>'title',
					'orderby'=>'asc',
					'tax_query' => array(
						array(
							'taxonomy' => 'scorecard',
							'field'    => 'slug',
							'terms'    => $year,
						),
						array(
							'taxonomy' => 'chamber',
							'field'    => 'slug',
							'terms'    => $chamber,
						),
					),
				);
				
					$the_query = new WP_Query( $args );

					// The Loop
					if ( $the_query->have_posts() ) {
						
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							?>
							<div>
								<h3><?php the_field('bill_number'); ?> &ndash; <?php  the_title();  ?></h3>
								<?php the_content(); ?>
							</div>
							<?php
						}
						
						
						/* Restore original Post Data */
						wp_reset_postdata();
					}
	
	echo "</section>";
}

function sortByLastName($legislatorsObject){

	
	// Break Post Title into Last name/first name etc..
	foreach( $legislatorsObject as $legislator) {
		$name = $legislator->post_title;
		$exploded_name = explode(' ', $name);
		$last_name = array(end($exploded_name));
		array_pop($exploded_name);
		$last_name_first = array_merge($last_name, $exploded_name);
		$legislator->post_title = implode(', ', $last_name_first);
	}

	// Sort by last Name

	usort($legislatorsObject, function ($a, $b) {
		return strcmp($a->post_title, $b->post_title);
	});

	return $legislatorsObject;

}
	
	function printScoreCard($chamber,$scorecardYear,$default){
		
		$active='';
			if($scorecardYear==$default){
					$active=' active ';
			} 
			
		echo "<section class='scorecardYear$scorecardYear scorecardYear $active' >";
		?>
			<table border="0" cellspacing="0" cellpadding="0">
				<thead> 
				<tr>
					<th>Name <span></span></th>
					<th class='town'>District <span></span></th>
					<th>Party <span></span></th>
					<th><?php  echo $scorecardYear;  ?> Score <span></span></th>
					<th>Lifetime Score <span></span></th>
				</tr>
				</thead>
				<tbody>
								<?php
				$args=array(
					'post_type'=>'legsilators',
					'meta_key' => 'last_name',
    				'orderby'=> 'meta_value',
					'order'=> 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'chamber',
							'field'    => 'slug',
							'terms'    => $chamber,
						),
					),
				);
										
					$the_query = new WP_Query( $args );

					// ?>
					<!-- <pre> -->
						<?php 
					// 	var_dump($legislators);?> 
					 <!-- </pre> -->  <?php  

					// The Loop
					if ( $the_query->have_posts() ) {
						
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
														
						$cscore=getCurrentScore(get_the_id(), $scorecardYear);
							
						?><!-- <?php the_title(); ?>Get Current Score <?php print_r($cscore ? $cscore : "no score yet"); ?> --><?php	
						
						if (isset($cscore[0])) {
							$year = $cscore[0];
						}

						if (isset($cscore[1])) {
							$currentYear=$cscore[1];						
						}
						
						$lifetime=get_post_meta( get_the_id(), 'lifetime_score', true);
						
						if( get_field('second_party')=="null"){
							$secondParty='';
						}	
						else if( get_field('second_party')){ 
							$secondParty="<br/>".get_field('second_party');
						} else {
							$secondParty='';
						}

							// If they have a score for the current year & not set to private - show legislator
							if(isset($cscore[1]) && is_post_publicly_viewable() ){
											
								echo '<tr>
									<td nowrap><a href="'.get_permalink().'">' . get_field('last_name') . ", " . get_field('first_name') . '</a></td>
									<td class="town" >'. get_field('towns').'</td>
									<td nowrap>'. get_field('party').$secondParty.'</td>
									<td class="cscore" >'.$currentYear.'</td>
									<td class="lscore" >'.$lifetime.'%</td>
								</tr>';
							} 
						}
						
						/* Restore original Post Data */
						wp_reset_postdata();
					}
				?>
				</tbody>
			</table></section><?php
	}
	
	function getSingleBills($legsilatorID, $year,$default){
		
		$active='';
		if($year==$default){
				$active=' active ';
		} 
			
		echo "<section class='scorecardYear$year scorecardYear $active'>";
	?>
	
		<table width="100%" id='bills'>

        	<tr>

        		<th>BILL NO.</th>

        		<th>BILL NAME</th>

        		<th>VOTE</th>

        	</tr>

        		<?php

        		

        		$terms = wp_get_post_terms( $legsilatorID, 'chamber' ); 

				$chamber= $terms[0]->slug;

        		

        		$bills= json_decode(get_post_meta( $legsilatorID, "Bills", true ));
				
				// var_dump($bills);
				
				$args=array(

					'post_type'=>'bills',

					'tax_query' => array(

						array(

							'taxonomy' => 'chamber',

							'field'    => 'slug',

							'terms'    => $chamber,

						),
						array(
							'taxonomy' => 'scorecard',
							'field'    => 'slug',
							'terms'    => $year,
						),

					)

				);

				

					$the_query = new WP_Query( $args );



					// The Loop

					if ( $the_query->have_posts() ) {

						

						while ( $the_query->have_posts() ) {

							$the_query->the_post();

							

							$billno="bill".get_the_id();

							$checked=$bills->$billno;

							if($checked=="Yes"){

								$vote="<img src='". get_template_directory_uri()."/img/thumbs_up.gif' />";

							} else if ($checked=="No"){

								$vote="<img src='". get_template_directory_uri()."/img/thumbs_down.gif' />";

							} else if ($checked=="Absent"){

								$vote="<img src='". get_template_directory_uri()."/img/Absent.gif' />";

							} else if ($checked=="P"){

								$vote="<img src='". get_template_directory_uri()."/img/Presiding.gif' />";

							} else if ($checked=="N/A"){

								$vote="<img src='". get_template_directory_uri()."/img/NIO.gif' />";

							}  else if ($checked=="NIO"){

								$vote="<img src='". get_template_directory_uri()."/img/NIO.gif' />";

							} else if ($checked=="Abstain"){

								$vote="<img src='". get_template_directory_uri()."/img/Abstain.gif' />";

							}	else if ($checked=="Suspended"){

								$vote="<img src='". get_template_directory_uri()."/img/Suspended.gif' />";

							}

							

							echo '<tr>

								<td ><a href="'.get_permalink().'">' .get_field("bill_number") . '</a></td>

								<td>'. get_the_title().'</td>

								<td >'. $vote.' '.'</td>

							</tr>';

						}

						

						/* Restore original Post Data */

						wp_reset_postdata();

					}

				?>

        	

        </table></section>

	<?php }?>