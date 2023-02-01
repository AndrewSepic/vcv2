<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<div class="wrap">
	<h1>Scorecard Editor</h1>
	<section id="status"></section>		<section id='YearSelector'>
	<form action='' method='POST' style='margin-top: 20px;'><label><strong>Scorecard Year</strong></label><select name='currentYear'>
<?php $scorecardYears = get_terms( 'scorecard', array(    'hide_empty' => false,) );foreach($scorecardYears as $v){			$name=$v->name;		echo "<option>$name</option>";		}	?></select><input type='submit' value='GO'></form>
	<?php 	//set year to POST year from form above or use last year entered	/*if($_POST['currentYear']){		 $currentYear=sanitize_text_field($_POST['currentYear']);			 echo "POSTED":	} else {		echo "DEFAULT";		$scorecardYears = get_terms( 'scorecard', array(			'hide_empty' => false,		) );		 $currentYear= $scorecardYears[(count($scorecardYears)-1)]->name; 	}		echo "<h1>$currentYear Scorecard</h1>"; */		?>		<?php  if($_POST['currentYear']){		$currentYear=sanitize_text_field($_POST['currentYear']);		} else {			$c=count($scorecardYears)-1;			$currentYear= $scorecardYears[$c]->name;	}		?>	<h1 style='border-bottom:solid 1px black; margin:20px 0;'><?=$currentYear ?> Scorecard</h1></section>
	<section class='scorecard' data-year='<?php echo $currentYear; ?>' >
		<h2>House</h2>
		<?php
		
		$houseBills=getBills("House", $currentYear);
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
		'orderby'=> 'title',
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
			
			$status=get_post_status( get_the_ID() );
			echo "<!-- LEGISLATOR ID: ".get_the_id()." Status: ".get_post_status( get_the_ID() )."-->"; 
			if($status=="private"){continue;}
			
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
	
	<!--<p><button class='updateAll button button-primary button-large'>Update Scorecard</button></p>--> 
	
	<h2 style='margin-top:60px;'>Senate</h2>	
	
	<?php	
	
		$senateBills=getBills("Senate", $currentYear);
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
		"post_status "=>'publish',
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
			
			$status=get_post_status( get_the_ID() );
			echo "<!-- LEGISLATOR ID: ".get_the_id()." Status: ".get_post_status( get_the_ID() )."-->"; 
			if($status=="private"){continue;}
			
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
	
<script>
	
			jQuery(document).on('change','select',function(){
				
				console.log("Select Changed");
					
				var parent=jQuery(this).parent().parent();
				var currentScore=updateCurrentScore(parent); 
				var currentYear=parent.parent().parent().parent().attr('data-year');
							
				var bills={};
				var L=parent.find("select").length;
				for (var i =0; i<L; i++ ){
					var input=parent.find("select").eq(i);
					var key=input.attr('data-bill');
					var value=input.val();
					bills[key]=value;
				}
										
				/* end for loop*/
				console.log(bills);
				var data={
					legislatorID:parent.find(".personID").val(),
					bills: bills,
					currentYear: currentYear,
					currentScore: currentScore
				};
				
				console.log(data);

				jQuery.ajax({
					        type: 'POST',
					        url: ajaxurl,
					        data: {
					            'action': 'ajax_update_bills' ,
					            'data':data
					        },
					        success: function(res){
								console.log(res);
					      	}
				    });
				    /* end Ajax */
				  
			});
			
			function updateCurrentScore(parent) {
				var L=parent.find("select").length;
				
				var nos=0;
				var yeses=0;
				var percent='';
					
				for (var i =0; i<L; i++ ){
					var input=parent.find("select").eq(i);
					var key=input.attr('data-bill');
					var value=input.val();
					
					if(value=="No" || value=="Absent" || value=="Abstain"){
						nos++;
					} else if ( value=="Yes"){
						yeses++;
					} else if(value=="P"){
						percent="P";
					}
				}	
				
				if(percent!="P"){
					total=nos+yeses;
					if(total>0){
						percent=((yeses/total)*100).toFixed(1);
					} else {
						percent="NIO";
					}
				}
				
				parent.find(".currentScore").val(percent);
				
				return percent;
				
			} 
			
			jQuery(document).on('change','.lifetimeScore ',function(){
				var parent=jQuery(this).parent().parent();
				var LifetimeScore=jQuery(this).val();
								
				jQuery.ajax({
					        type: 'POST',
					        url: ajaxurl,
					        data: {
					            'action': 'ajax_update_lifetime_score' ,
					            'LifetimeScore':LifetimeScore,
					           'legislatorID':parent.find(".personID").val(),							   					        },
					        success: function(res){
								console.log(res);
					      	}
				    });
				    /* end Ajax */
				  
			});
				
</script>

<?php

function getBills($chamber, $currentYear){
	$args = array(
	'post_type' => 'bills',
	'posts_per_page'=>-1,
	'tax_query' => array(
		array(
			'taxonomy' => 'chamber',
			'field'    => 'slug',
			'terms'    => $chamber
		),		array(			'taxonomy' => 'scorecard',			'field'    => 'name',			'terms'    => $currentYear		),
	),
);
	$query = new WP_Query( $args );
	
	$inputs=array();
	if ( $query->have_posts() ) {
		
		
		
		while ( $query->have_posts() ) {
			$query->the_post();
			
			if(isset($bills)===false){
				$bills='';
			}
				$bills.="<th>".get_field('bill_number')." <br/><em> ".get_the_title() ."</em></th>";
				array_push($inputs, get_the_ID());
			
		}
	
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	if(isset($bills)){
		return array($bills, $inputs);
	}	
}

function buildInputs($inputs, $billsA){
	foreach($inputs as $i){
		
		$b="bill".$i;
		$sel=$billsA->$b;
		$selected=array("NIO"=>"","Yes"=>"","No"=>"","Absent"=>"","Abstain"=>"","P"=>"","Suspended"=>"" );
		
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
 

?>