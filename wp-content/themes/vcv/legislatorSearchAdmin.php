<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<div class="wrap">
	<h1>Legislator Bulk Editor</h1>
	<section id="status">
	
	</section>
	 <fieldset id='legislatorList'></fieldset>
	<script>
		var divisdionIds=[
		"ocd-division/country:us/state:vt/sldl:addison-1",
		"ocd-division/country:us/state:vt/sldl:addison-2",
		"ocd-division/country:us/state:vt/sldl:addison-3",
		"ocd-division/country:us/state:vt/sldl:addison-4",
		"ocd-division/country:us/state:vt/sldl:addison-5",
		"ocd-division/country:us/state:vt/sldl:addison-rutland",
		"ocd-division/country:us/state:vt/sldl:bennington-1",
		"ocd-division/country:us/state:vt/sldl:bennington-2-1",
		"ocd-division/country:us/state:vt/sldl:bennington-2-2",
		"ocd-division/country:us/state:vt/sldl:bennington-3",
		"ocd-division/country:us/state:vt/sldl:bennington-4",
		"ocd-division/country:us/state:vt/sldl:bennington-rutland",
		"ocd-division/country:us/state:vt/sldl:caledonia-1",
		"ocd-division/country:us/state:vt/sldl:caledonia-2",
		"ocd-division/country:us/state:vt/sldl:caledonia-3",
		"ocd-division/country:us/state:vt/sldl:caledonia-4",
		"ocd-division/country:us/state:vt/sldl:caledonia-washington",
		"ocd-division/country:us/state:vt/sldl:chittenden-10",
		"ocd-division/country:us/state:vt/sldl:chittenden-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-2",
		"ocd-division/country:us/state:vt/sldl:chittenden-3",
		"ocd-division/country:us/state:vt/sldl:chittenden-4-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-4-2",
		"ocd-division/country:us/state:vt/sldl:chittenden-5-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-5-2",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-2",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-3",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-4",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-5",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-6",
		"ocd-division/country:us/state:vt/sldl:chittenden-6-7",
		"ocd-division/country:us/state:vt/sldl:chittenden-7-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-7-2",
		"ocd-division/country:us/state:vt/sldl:chittenden-7-3",
		"ocd-division/country:us/state:vt/sldl:chittenden-7-4",
		"ocd-division/country:us/state:vt/sldl:chittenden-8-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-8-2",
		"ocd-division/country:us/state:vt/sldl:chittenden-8-3",
		"ocd-division/country:us/state:vt/sldl:chittenden-9-1",
		"ocd-division/country:us/state:vt/sldl:chittenden-9-2",
		"ocd-division/country:us/state:vt/sldl:essex-caledonia",
		"ocd-division/country:us/state:vt/sldl:essex-caledonia-orleans",
		"ocd-division/country:us/state:vt/sldl:franklin-1",
		"ocd-division/country:us/state:vt/sldl:franklin-2",
		"ocd-division/country:us/state:vt/sldl:franklin-3-1",
		"ocd-division/country:us/state:vt/sldl:franklin-3-2",
		"ocd-division/country:us/state:vt/sldl:franklin-4",
		"ocd-division/country:us/state:vt/sldl:franklin-5",
		"ocd-division/country:us/state:vt/sldl:franklin-6",
		"ocd-division/country:us/state:vt/sldl:franklin-7",
		"ocd-division/country:us/state:vt/sldl:grand_isle-chittenden",
		"ocd-division/country:us/state:vt/sldl:lamoille-1",
		"ocd-division/country:us/state:vt/sldl:lamoille-2",
		"ocd-division/country:us/state:vt/sldl:lamoille-3",
		"ocd-division/country:us/state:vt/sldl:lamoille-washington",
		"ocd-division/country:us/state:vt/sldl:orange-1",
		"ocd-division/country:us/state:vt/sldl:orange-2",
		"ocd-division/country:us/state:vt/sldl:orange-caledonia",
		"ocd-division/country:us/state:vt/sldl:orange-washington-addison",
		"ocd-division/country:us/state:vt/sldl:orleans-1",
		"ocd-division/country:us/state:vt/sldl:orleans-2",
		"ocd-division/country:us/state:vt/sldl:orleans-caledonia",
		"ocd-division/country:us/state:vt/sldl:orleans-lamoille",
		"ocd-division/country:us/state:vt/sldl:rutland-1",
		"ocd-division/country:us/state:vt/sldl:rutland-2",
		"ocd-division/country:us/state:vt/sldl:rutland-3",
		"ocd-division/country:us/state:vt/sldl:rutland-4",
		"ocd-division/country:us/state:vt/sldl:rutland-5-1",
		"ocd-division/country:us/state:vt/sldl:rutland-5-2",
		"ocd-division/country:us/state:vt/sldl:rutland-5-3",
		"ocd-division/country:us/state:vt/sldl:rutland-5-4",
		"ocd-division/country:us/state:vt/sldl:rutland-6",
		"ocd-division/country:us/state:vt/sldl:rutland-bennington",
		"ocd-division/country:us/state:vt/sldl:rutland-windsor-1",
		"ocd-division/country:us/state:vt/sldl:rutland-windsor-2",
		"ocd-division/country:us/state:vt/sldl:washington-1",
		"ocd-division/country:us/state:vt/sldl:washington-2",
		"ocd-division/country:us/state:vt/sldl:washington-3",
		"ocd-division/country:us/state:vt/sldl:washington-4",
		"ocd-division/country:us/state:vt/sldl:washington-5",
		"ocd-division/country:us/state:vt/sldl:washington-6",
		"ocd-division/country:us/state:vt/sldl:washington-7",
		"ocd-division/country:us/state:vt/sldl:washington-chittenden",
		"ocd-division/country:us/state:vt/sldl:windham-1",
		"ocd-division/country:us/state:vt/sldl:windham-2-1",
		"ocd-division/country:us/state:vt/sldl:windham-2-2",
		"ocd-division/country:us/state:vt/sldl:windham-2-3",
		"ocd-division/country:us/state:vt/sldl:windham-3",
		"ocd-division/country:us/state:vt/sldl:windham-4",
		"ocd-division/country:us/state:vt/sldl:windham-5",
		"ocd-division/country:us/state:vt/sldl:windham-6",
		"ocd-division/country:us/state:vt/sldl:windham-bennington,vt-lower-windham-bennington",
		"ocd-division/country:us/state:vt/sldl:windham-bennington-windsor",
		"ocd-division/country:us/state:vt/sldl:windsor-1",
		"ocd-division/country:us/state:vt/sldl:windsor-2",
		"ocd-division/country:us/state:vt/sldl:windsor-3-1",
		"ocd-division/country:us/state:vt/sldl:windsor-3-2",
		"ocd-division/country:us/state:vt/sldl:windsor-4-1",
		"ocd-division/country:us/state:vt/sldl:windsor-4-2",
		"ocd-division/country:us/state:vt/sldl:windsor-5",
		"ocd-division/country:us/state:vt/sldl:windsor-orange-1",
		"ocd-division/country:us/state:vt/sldl:windsor-orange-2",
		"ocd-division/country:us/state:vt/sldl:windsor-rutland",
		"ocd-division/country:us/state:vt/sldu:addison",
		"ocd-division/country:us/state:vt/sldu:bennington",
		"ocd-division/country:us/state:vt/sldu:caledonia",
		"ocd-division/country:us/state:vt/sldu:chittenden",
		"ocd-division/country:us/state:vt/sldu:essex-orleans",
		"ocd-division/country:us/state:vt/sldu:franklin",
		"ocd-division/country:us/state:vt/sldu:grand_isle-chittenden",
		"ocd-division/country:us/state:vt/sldu:lamoille",
		"ocd-division/country:us/state:vt/sldu:orange",
		"ocd-division/country:us/state:vt/sldu:rutland",
		"ocd-division/country:us/state:vt/sldu:washington",
		"ocd-division/country:us/state:vt/sldu:windham",
		"ocd-division/country:us/state:vt/sldu:windsor"
		];
		
		searchForNew();
		
		function searchForNew(){
			
			jQuery("#status").html("<h2>Searching districts for  legislator updates: <span id='c'>0</span> of "+divisdionIds.length+"</h2><div id='progressbar'></div>");
			var districtCounter=0;
			
			for( var i in divisdionIds ){
				jQuery.ajax({
				        type: 'POST',
				        url: ajaxurl,
				        data: {
				            'action': 'ajax_check_legislator' ,
				            'location':divisdionIds[i]
				        },
				        success: function(res){
				        	console.log(res);
				        	districtCounter++;
				        	jQuery("#status #c").text(districtCounter);
				        	jQuery( "#progressbar" ).progressbar({
							  	max: divisdionIds.length,
							  	value: districtCounter
							});
				        	var legislators= JSON.parse(res);
					        	for( var x in legislators.officials ){
					        		addLegislatorRow(legislators.officials[x],legislators. divisionID);
					      	  }
					      	  
					      	  if(districtCounter==divisdionIds.length){
					      	  	
					      	  	if(jQuery(".legislator").size()>0){
					      	  	  var btn="<p><button class='updateAll button button-primary button-large'>Add New Legislators</button></p>";
					      	  	  jQuery("#legislatorList").append(btn);
					      	  	  jQuery("#legislatorList").prepend(btn);
					      	  	} else {
					      	  		 jQuery("#legislatorList").prepend("<h3>No new updates</h3>");
					      	  	}
					      	  	   jQuery("#status").html(" ");
					      	  }
					      	  
				      	}
			    });
			}
		}
		
		function addLegislatorRow(legislator, divisionID){
			
			var fb='';
			var tw='';
			
			for (var ch in legislator.channels){
				if(legislator.channels[ch].type="Facebook"){
					fb=legislator.channels[ch].id;
				}
				else if(legislator.channels[ch].type="Twitter"){
					tw=legislator.channels[ch].id;
				}
			}
								
			var newArticle="<fieldset class='legislator'>"+
			"<h3>"+
			legislator.name+
			"</h3>"+
			"<p>Division ID: "+divisionID+"<input type='hidden' class='divisionID' value='"+
			divisionID+
			"' /></p>"+
			"<label>Party <input type='text' class='party' value='"+
			legislator.party+
			"' /></label>"+
			"<label>Phone Numbers <input type='text' class='phones' value='"+
			legislator.phones+
			"' /></label>"+
			"<label>URL's <input type='text' class='urls' value='"+
			legislator.urls+
			"' /> </label>"+
			"<label>Emails <input type='text' class='email' value='"+
			legislator.emails+
			"' /> </label>"+
			"<label>Facebook ID <input type='text' class='facebook_id' value='"+
			fb+
			"' /> </label>"+
			"<label>Twitter ID <input type='text' class='twitter_id' value='"+
			tw+
			"' /> </label>"+
			'<label>Photo URL <input type="text" class="img pic" value="'+legislator.photoUrl+'" class="regular-text" /></label>'+
			
			"</fieldset>";
			jQuery("#legislatorList").append(newArticle);
		}
			
		/* add new legislators */
		
	jQuery(document).on('click','.updateAll',function(){
				
			var num=jQuery(".legislator").size();
			jQuery("#status").html("<h2>Uploading legislators: <span id='c'>0</span> of "+num+"</h2><div id='progressbar'></div>");
			
			for( var nn =0; nn<num; nn++ ){ 
				
						var parent=jQuery(".legislator").eq(nn);
						
						var data={
							name: parent.find("h3").text(),
							divisionID: parent.find(".divisionID").val(),
							party: parent.find(".party").val(),
							phones: parent.find(".phones").val(),
							urls:parent.find(".urls").val(),
							email:parent.find(".email").val(),
							facebook_id:parent.find(".facebook_id").val(),
							twitter_id:parent.find(".twitter_id").val(),
							pic:parent.find(".pic").val(),
						};
				
						jQuery.ajax({
							        type: 'POST',
							        url: ajaxurl,
							        data: {
							            'action': 'ajax_new_legislator' ,
							            'data':data
							        },
							        success: function(res){
							        	console.log(res);
							        	jQuery( "#progressbar" ).progressbar({
										  	max: num,
										  	value: nn
										});
										parent.remove();
							      	}
						    });
				    
				   }
			});
		
	</script>
</div>