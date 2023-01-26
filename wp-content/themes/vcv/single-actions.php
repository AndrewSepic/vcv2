<?php get_header(); ?>
    <section id='content' class='container clearfix'>
    	<h1>Take Action</h1>
        <?php 
        if(has_post_thumbnail()){
        	?><div class='copy'>
			 <h2><?php the_title(); ?></h2>
        	<?php the_content(); ?>
        	</div>
			<?	
        	the_post_thumbnail('medium');
		} else {
		?>	
			 <h2><?php the_title(); ?></h2>
        	<?php the_content(); ?>
		<?	
		}
			?>
    </section>
    
    <?php 
    $contactType=get_field("contact_type");
    $activeContacts="  active";
    if ($contactType=="search"): 
   		 	$activeContacts=" ";
    ?>
    	<div class="container" id='searchContainer'>
	    	<section id="search" class='clearfix'>
				<h2>FIND YOUR VERMONT LEGISLATORS</h2>
				<p>Enter your address to find your legistlative district and representative.</p>
				<p class='error'></p>
				<form method='get' action='/search' id="searchForm">
					<input type="text" id='address' name='address' placeholder="Address">
					<input type="text" id='city' name='city' placeholder="City">
					<a href='' id='submit'><img src='<?php echo  get_template_directory_uri();  ?>/img/formSubmit.png' /></a>
				</form>
			</section>
			<div id='searchResults'></div>
		</div>
    	<?php endif; ?>
    	
    <section id='contacts'  class='container clearfix <?php  echo $activeContacts;  ?> '>
    	<?
    	$modes=get_field("contacts");
    	?>
    	<nav> 
    		<ul>
    			<?php if(in_array("Facebook", $modes)): ?>
    			<li><a href='facebook_text' class='facebook' >Facebook</a></li>
    			<?php endif; ?>
    			<?php if(in_array("Phone", $modes)): ?>
    			<li><a href='phone_text' class='phone'>Make a Phone Call</a></li>
    			<?php endif; ?>
    			<?php if(in_array("Email", $modes)): ?>
    			<li><a href='email_text' class='email'>Send an Email</a></li>
    			<?php endif; ?>
    			<?php if(in_array("Petition", $modes)): ?>
    			<li><a href='petition_text' class='petition'>Sign a Petition</a></li>
    			<?php endif; ?>
    		</ul>
    	</nav>
    	
		<?php if(get_field('contact_name')): ?>
    	<div id='intro_text' class='info'>
    		<h2>Contact <span class='contactName'><?php  the_field('contact_name'); ?></span></h2>
    	</div>
		<?php endif; ?>
    	
    	<?php if(in_array("Facebook", $modes)): ?>
    	<div id='facebook_text' class='info'>
    		<h2>Contact <span class='contactName'><?php  the_field('contact_name'); ?></span> on Facebook</h2>
    		<?php $fbLinkText=str_replace("https://","",get_field('facebook_address')); ?>
    		 <p><a href="<?php the_field('facebook_address'); ?>" target='blank'  class='featureLink fblink'><?php echo $fbLinkText; ?></a></p>
    		<?php  the_field('facebook_text'); ?>
    	</div>
    	<?php endif; ?>
    	<?php if(in_array("Phone", $modes)): ?>
    	<div id='phone_text' class='info'>
    		<h2>Call <span class='contactName'><?php  the_field('contact_name'); ?></span></h2>
    		<p class='featureLink' >CALL: <a href='tel:<?php  the_field('phone_number'); ?>' class='featureLink phoneNumber' ><?php  the_field('phone_number'); ?></a></p>
    		<?php  the_field('phone_number_text'); ?>
    	</div>
    	<?php endif; ?>
    	<?php if(in_array("Email", $modes)): ?>
    	<div id='email_text' class='info'>
    		<h2>Contact <span class='contactName'><?php  the_field('contact_name'); ?></span> by Email</h2>
    		<?php  the_field('email_text'); ?>
    		<p  class='featureLink'>EMAIL: <a href="mailto:<?php the_field('email_address'); ?>" class='featureLink emailLinkA'><?php the_field('email_address'); ?></a></p>
    		<form id="takeActionForm">
    			<input type="text" id="fname"   placeholder="First Name" />
    			<input type="text" id="lname"  placeholder="Last Name" />
    			<input type="text" id="email" placeholder="Your Email" />
    			<input type="text" id="zip"  placeholder="Zip Code" />
    			<input type="text" id="county"  placeholder="County" />
    			<label>Please personalize the subject below:</label>
	    		<input type="text" id="subject"   value="<?php the_field('email_subject'); ?>" />
    			<label>Please personalize the message below:</label>
    			<textarea id="message"><?php the_field('email_message'); ?></textarea>   			
    		</form>
    		<nav id="emailMenu">
    			<a  id='emailLink' class='emailLink btn' href='' target='_blank'>Email</a>
    		</nav>
    	</div>
    	<?php endif; ?>
    	
    	<?php if(in_array("Petition", $modes)): ?>
    	<div id='petition_text' class='info'>
    		<h1>Petition</h1>
    		<?php  
    		the_field("petition_text");
			echo html_entity_decode(get_field("mailchimp_form"));
			 ?>
    		
    	</div>
    	<?php endif; ?>
    </section>
    <script>
    
    	jQuery("#emailLink").click(function(e){
    		
    		var fname=jQuery("#fname").val();
    		var lname=jQuery("#lname").val();
    		var email=jQuery("#email").val();
    		var zip=jQuery("#zip").val();
    		var county=jQuery("#county").val();
    		var subject=jQuery("#subject").val();
    		var message=jQuery("#message").val();
    		var error='';
    		var body=fname+'  '+lname+'\n \r'+email+'\n\r '+zip+'\n\r '+county+'\n\r '+message;
    		    		
    	if(email.length<1){
    			error="A last name is required";
    			e.preventDefault();
    		
    			return false;
    		
    		} else {
    			var emailA=email.split('@');
    			var isp=emailA[1];
    			var link;
    			
    			var to=jQuery('#email_text  .featureLink a').text();
    			
    			switch (isp) {
    				
    				case "gmail.com" :
    					link="https://mail.google.com/mail/u/0/?view=cm&fs=1&to="+to+"&su="+subject+"&body="+body+"%0A&tf=1";
    				break;
    				
    				case "aol.com" :
    					link="https://mail.aol.com/webmail-std/en-us/composemessage?to="+to+"&subject="+subject+"&body="+body+"";
    				break;
    				
    				case "hotmail.com" :
    						link="https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=13&ct=1474663237&rver=6.4.6456.0&wp=MBI_SSL_SHARED&wreply=https:%2F%2Fmail.live.com%2Fdefault.aspx%3Frru%3Dcompose%26to%3D"+to+"%26subject%3D"+subject+"%26body%3D%250a%250a"+body+"%250a&lc=1033&id=64855&mkt=en-us&cbcxt=mai";
    				break;
    				
    				case "yahoo.com" :
    						link="https://login.yahoo.com/config/login_verify2?.intl=us&.src=ym&.done=http%3a%2f%2fcompose.mail.yahoo.com%2f%3fto%3d"+to+"%26subj%3d"+subject+"%26body%3d"+body;
    				break;
    				
    				default:
    					link="mailto"+to+"?subject="+subject+"&body=%0A%0A"+body+"%0a";
    			}
    			
    			jQuery(this).attr("href",link);
    			
    			return true;
    		}
    		
    	});
    	
    	 jQuery(".info").first().addClass("active");
    	 jQuery("#contacts nav a").click(function(){
    	 	jQuery("#contacts nav a").removeClass("active");
    	 	jQuery(this).addClass("active");
    	 	
    	 	var href=jQuery(this).attr('href');
    	 	jQuery("#contacts .info").hide();
    	 	jQuery("#contacts .info#"+href).fadeIn('fast');
    	 	return false;
    	 });
    	 
    	 var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		
    	 jQuery("#searchForm #submit").click(function(){
    	 		
    	 		var address=jQuery("#searchForm #address").val();
    	 		var city=jQuery("#searchForm #city").val();
    	 	
    	 		jQuery.ajax({
				        type: 'POST',
				        url: ajaxurl,
				        data: {
				            'action': 'ajax_legislator_search' ,
				            'address':address,
				            "city":city
				        },
				        success: function(res){
				        	jQuery("#searchResults").html(res);
				      	}
				 });
    	 		
    	 		return false;
    	 });
    	 
    	 jQuery(document).on("click", "#searchResults a", function(){
    	 	var legislatorID=jQuery(this).attr("data-id");
    	 	var name=jQuery(this).text();
    	 	var fb=jQuery(this).attr("data-facebook");
    	 	var email=jQuery(this).attr("data-email");
    	 	var phone=jQuery(this).attr("data-phone");
    	 	
    	 	  jQuery(".fblink").text("facebook.com/"+fb).attr('href', 'http://facebook.com/'+fb);
    	 	  jQuery(".phoneNumber").text(phone).attr('href', 'tel:'+phone);
    	 	  jQuery(".contactName").text(name);
    	 	  jQuery(".emailLinkA").text(email).attr('href', 'mailto:'+email);
    		jQuery("#searchContainer").hide("fast");
    		
    		if (fb.length==0){
    			jQuery("nav .facebook").hide(); 
    		}
    		
    		if (phone.length==0){
    			jQuery("nav .phone").hide(); 
    		}
    		
    		if (email.length==0){
    			jQuery("nav .email").hide(); 
    		}
    		
    		jQuery("#contacts").fadeIn("fast");
    	
    	 	return false;
    	 } );

    	 
    </script>
    <?php get_footer(); ?>