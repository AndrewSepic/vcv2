<?php 
// This is the Scorecard Page 
//
get_header(); ?>
<?php   $year=getCurrentYear(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/tablesorter-master/jquery.tablesorter.min.js"></script>
	<section id='pageBanner'>
		<div  class='inner container'><h1 ><?php the_title(); ?></h1></div>		
		</section>
    <section id='content' class='container clearfix'>
		<nav class='scoreboard'>
			<a href='#' data-tab='senate'>Senate Scorecard</a><a href='#' data-tab='house'>House Scorecard</a><a href='#' data-tab='bills'>Bill Descriptions</a>
			
			<h4 class='yearLabel'><?php echo $year; ?></h4>
		</nav>
		
		<div id='intro' class=' tabbed intro active clearfix'>
			<div class='content'><?php the_content(); ?></div>
			<nav>
				<p class='descriptor'>Download<br/>
PREVIOUS SCORECARDS</p>
				<?php the_field("pastScoreBoard") ?>
				</nav>
		</div>  
		
		
		<div id='senateTab' class='tabbed senate'>
			<?php printScoreCard("Senate",$year,$year); ?>
		</div>
		<div id='houseTab' class='tabbed house'>
			<?php  printScoreCard("House",$year,$year); ?> 
		</div>
		<div id='billsTab' class='tabbed bills'>
			<nav>
				<a href='#' data-chamber="house" class='active'>House Bills</a>
				<a href='#' data-chamber='senate'>Senate Bills</a>
			</nav>
				
				<div id="HouseBills" class='billList active house'>
								<h2>House Bills</h2>
<?
			$terms = get_terms( array( 'taxonomy' => 'scorecard', 'hide_empty' => true) );
			foreach($terms as $t ){
				$y= $t->name;
				
				printBills("House",$y, $year);
			}					
								
			  ?>
</div>
				<div  class='billList  senate'>
						<h2>Senate Bills</h2>

			<?php  
			$terms = get_terms( array( 'taxonomy' => 'scorecard', 'hide_empty' => true) );
			foreach($terms as $t ){
				$y= $t->name;
				printBills("Senate",$y,$year);
			}	
			?>
</div>
		</div>
		
		<footer id="search" class='clearfix'>
			<h2>FIND YOUR VERMONT LEGISLATORS</h2>
			<p>Enter your address to find your legistlative district and representative.</p>
			<p class='error'></p>
			<form method='get' action='/search'>
				<input type="text" id='address' name='address' placeholder="Address">
				<input type="text" id='city' name='city' placeholder="City">
				<a href='' id='submit'><img src='<?php echo  get_template_directory_uri();  ?>/img/formSubmit.png' /></a>
			</form>
		</footer>
        
    </section>
    <script>
    
   		 jQuery("#search input").click(function(){
   		 	jQuery(this).css('border','0');
   		 });
   		 
   		jQuery("#search #submit").click(function(){
   			var valid=true;
   			var error='';
   			if(jQuery('#address').val()==''){
   				jQuery('#address').css('border', 'solid 1px red');
   				valid=false;
   			}
   			if(jQuery('#city').val()==''){
   				jQuery('#city').css('border', 'solid 1px red');
   				valid=false;
   			}
   			
   			if(valid==true){
   				jQuery("#search form").submit();
   			} else {
   				jQuery("#search .error") .text("Please enter an address and city.");
   			}
   			
   			return false;
   		});
		
		/* read hash */
		if(window.location.hash) {
			
			if (location.hash) {               // do the test straight away
				window.scrollTo(0, 0);         // execute it straight away
				setTimeout(function() {
					window.scrollTo(0, 0);     // run it a bit later also for browser compatibility
				}, 1);
			}
			
			var selector = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			var tab = selector+"Tab";
			jQuery("nav.scoreboard  a ").removeClass("active");
    		jQuery("nav.scoreboard  a[data-tab='"+selector+"']").addClass('active');
    		jQuery(".tabbed.active").removeClass('active')
    		jQuery(".tabbed").hide();

    		jQuery("#"+tab).fadeIn("fast");
		 } 
    
    	jQuery("nav.scoreboard  a ").click(function(){
    		var selector=jQuery(this).attr("data-tab");
			var tab = selector+"Tab";
			window.location.hash = selector;
    		jQuery("nav.scoreboard  a ").removeClass("active");
    		jQuery(this).addClass('active');
    		jQuery(".tabbed.active").removeClass('active')
    		jQuery(".tabbed").hide();

    		jQuery("#"+tab).fadeIn("fast");
    		return false;
    	});
    	jQuery(document).ready(function() { 
		         jQuery(" table").tablesorter({ sortList: [[0,0],[0,1],[2,0],[0,3],[0,4]] });
		  }); 
		  
		  jQuery("#billsTab nav a").click(function(){
		  		 jQuery("#billsTab nav a").removeClass('active');
		  		 jQuery(this).addClass("active");
		  		 jQuery(".billList").hide();
		  		 var chamber=jQuery(this).attr("data-chamber");
		  		 jQuery(".billList."+chamber).fadeIn(1000);
		  		 
		  		return false;
		  });
		  
		 /*write cookie */
		function setCookie(cname, cvalue, exdays) {
		  var d = new Date();
		  d.setTime(d.getTime() + (exdays*24*60*60*1000));
		  var expires = "expires="+ d.toUTCString();
		  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}
		
		/*read cookie */
		function getCookie(cname) {
		  var name = cname + "=";
		  var decodedCookie = decodeURIComponent(document.cookie);
		  var ca = decodedCookie.split(';');
		  for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
			  c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
			  return c.substring(name.length, c.length);
			}
		  }
		  return "";
		}
			
		var showPopup=function(){
			if(getCookie("popup")){return false;}
			jQuery("#shadow").fadeIn("fast");
			jQuery("#popupForm").css("display","flex");
			setCookie("popup", 1, 1);
		}	
		  
		setTimeout(showPopup, 5000);
    	
    </script>
    <?php get_footer(); ?>