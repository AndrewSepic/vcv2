<?php

add_action( 'wp_ajax_ajax_updateBillTable', 'ajax_updateBillTable' );
function ajax_updateBillTable(){
	$currentYear = $_POST['currentYear'];
	printBillTables($currentYear);
	wp_die();
}

//function scorecard_editor_menu(){}

function printBillTables($currentYear){
	
		?> 
		<section class='scorecard' data-year='<?php echo $currentYear; ?>' >
		<h2>House</h2>
		<?
	
		$houseBills=getBills("House",$currentYear);
		$bills=$houseBills[0];
		$inputs=$houseBills[1];
	
		$header="<table class='scorecard'>
			<tr>
				<th>Name</th>".$bills.
				"<th>Scorecard Score</th>".
				"<th>Lifetime Score</th>".
			"</tr>";
			
		echo $header;	
	
		$args = array(
		'post_type' => 'legsilators',
		'orderby'=>'title',
		'order'=>'asc',
		'tax_query' => array(
			array(
				'taxonomy' => 'chamber',
				'field'    => 'slug',
				'terms'    => 'House',
			),
			'posts_per_page'=>-1
		)
		);
	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
		
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id=get_the_id();
			
			$bills=get_post_meta($post_id, "Bills" );
			$billsA=json_decode( $bills[0]);
			
			echo '<tr>';
			echo '<td nowrap>'. get_the_title() . '<input type="hidden" class="personID" value="'.$post_id.'"></td>'.buildInputs($inputs, $billsA);
			
			$currentScore="";
			$cscores=get_post_meta($post_id,"ScorecardScores" );
			if($cscores){
				$cscores_a=json_decode($cscores[0]);
				$y="year".$currentYear;
				$currentScore=$cscores_a->$y;
				if(!is_numeric($currentScore)){
					//$currentScore='';
				}
			}
			
			$score=get_post_meta($post_id,"lifetime_score" );
			echo '
			<td nowrap><input type="text" class="currentScore score"  value="'.$currentScore.'" >%</td>
			<td nowrap><input type="text" class="lifetimeScore score"  value="'.$score[0].'" >%</td>
			</tr>';
		}
	
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	?>
	</table>

	<h2 style='margin-top:60px;'>Senate</h2>	
	
	<?	
	
		$senateBills=getBills("Senate",$currentYear);
		$bills=$senateBills[0];
		$inputs=$senateBills[1];
	
		$header="<table class='scorecard'>
				<tr>
					<th>Name</th>".$bills.
					"<th>Current Score</th>".
					"<th>Lifetime Score</th>".
				"</tr>";
	
	echo $header;
	
		$args = array(
		'post_type' => 'legsilators',
		'orderby'=>'title',
		'order'=>'asc',
		'tax_query' => array(
			array(
				'taxonomy' => 'chamber',
				'field'    => 'slug',
				'terms'    => 'Senate',
			),
			'posts_per_page'=>-1
		)
		);
	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
		
		while ( $query->have_posts() ) {
			$query->the_post();
				
			$bills=get_post_meta(get_the_ID(), "Bills" );
			$billsA=json_decode( $bills[0]);
			
			echo "<!-- LEGISLATOR ID: ".get_the_id()."-->"; 
			echo '<tr>';
			echo '<td nowrap>' . get_the_title() . '<input type="hidden" class="personID" value="'.get_the_id().'"></td>'.buildInputs($inputs, $billsA);
			
			$post_id=get_the_id();
			$score=get_post_meta($post_id,"lifetime_score" );
			
			$currentScore="";
			$cscores=get_post_meta($post_id,"ScorecardScores" );
			if($cscores){
				$cscores_a=json_decode($cscores[0]);
				$y="year".$currentYear;
				$currentScore=$cscores_a->$y;
				if(!is_numeric($currentScore)){
					$currentScore='';
				}
			}
			
			$score=get_post_meta($post_id,"lifetime_score" );
			echo '
			<td nowrap><input type="text" class="currentScore score"  value="'.$currentScore.'" >%</td>
			<td nowrap><input type="text" class="lifetimeScore score"  value="'.$score[0].'" >%</td>
			</tr>';
		}
	
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	?>
	</table>
	<!--<p><button class='updateAll button button-primary button-large'>Update Scorecard</button></p>-->
	</div>
	
</section>
<?
}


function getBills($chamber, $currentYear){
	$args = array(
	'post_type' => 'bills',
	'posts_per_page'=>-1,
	'tax_query' => array(
		array(
			'taxonomy' => 'chamber',
			'field'    => 'slug',
			'terms'    => $chamber
		),
		array(
			'taxonomy' => 'scorecard',
			'field'    => 'slug',
			'terms'    => $currentYear
		),
	),
);
	$query = new WP_Query( $args );
	
	$inputs=array();
	if ( $query->have_posts() ) {
		
		
		
		while ( $query->have_posts() ) {
			$query->the_post();
				
			$bills.="<th>".get_field('bill_number')." <br/><em> ".get_the_title() ."</em></th>";
			array_push($inputs, get_the_ID());
		}
	
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	
	return array($bills, $inputs);
}

function buildInputs($inputs, $billsA){
	foreach($inputs as $i){
		
		$b="bill".$i;
		$sel=$billsA->$b;
		$selected=array();
		$selected[$sel]=" selected='selected' "	;	

		//$res.="<td><input ".$checked."  type='checkbox' data-bill='bill".$i."' ></td>";
		$res.="<td nowrap>
		<select  type='checkbox' data-bill='bill".$i."'>
		<option value=''>---</option>
		<option".$selected["NIO"].">NIO</option>
		<option".$selected["Yes"].">Yes</option>
		<option".$selected["No"].">No</option>
		<option".$selected["Absent"].">Absent</option>
		<option".$selected["Abstain"].">Abstain</option> 
		<option".$selected["P"].">P</option>
		<option".$selected["Suspended"].">Suspended</option> 
		</td>";
		
		 
	}
	
	return $res;
	
}