<?php

function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

// create custom plugin settings menu
add_action('admin_menu', 'importer_create_menu');

function importer_create_menu() {

add_submenu_page('edit.php?post_type=bills','Scorecard Editor', 'Scorecard Editor', 		'administrator', 'scorecardEditor', 'ScorecardEditor_page'  );

	//create new top-level menu
	 add_submenu_page('edit.php?post_type=legsilators','Legislator Importer', 'Legislator Importer', 'administrator', "legislator_importer", 'legislatorScore_page'  );

}

// create custom plugin settings menu
add_action('admin_menu', 'scorecard_editor_menu');

function scorecard_editor_menu() {
// Nothing here?
}


function legislatorScore_page() {
	require('legislatorSearchAdmin.php');
 }

function ScorecardEditor_page(){
	require('scorecardEditor.php');
}

//load file
add_action( 'wp_ajax_ajax_check_legislator', 'ajax_check_legislator' );
function ajax_check_legislator(){

	$location=$_POST['location'];
	$locationSafe=urlencode($location);
	$apiKey="AIzaSyCjOv-KLgr46lzBoXj2KN5bb7u1vBZeVOs	";
	$query="https://www.googleapis.com/civicinfo/v2/representatives/".$locationSafe."?key=".$apiKey;
	////
	////

	$legislatorOutput=false;
	 // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $query);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

		$json=json_decode($output);

		$officialsOutput=array();

		foreach($json->officials as $official){
			/*$processed=array();
			$processed['name']= $official->name;

			$processed["party"]=$official->party;
			if(count($processed->phones)>0){
				$processed["phones"]=implode(", ",$processed->phones);
			} else {
				$processed["phones"]='';
			}
			if(count($official->urls)>0){
				$processed["urls"]=implode(", ",$processed->urls);
				} else {
				$processed["urls"]='';
			}
			$processed["photoUrl"]=$official->photoUrl;


			$processed["emails"]=implode(", ",$official->emails);
			$channels=$official->channels;
			$processed["facebook_id"]='';
			$processed["twitter_id"]='';

			if(count($channels)>0){
				foreach($channels as $c ){
				//	print_r($c);
					$type=$c->type;
					$id=$c->id;

				if($type=="Facebook"){
						$processed["facebook_id"] =$id;
					} else if($type=="Twitter"){
						$processed["twitter_id"] =$id;
					}
				}
			}	//end if $channels
			*/

			// $args = array(
			// 	'post_type' => 'legsilators',
			// 	'title'=>$official->name
			// );
			// $query = new WP_Query( $args );
			// $count = $query->post_count;

			// //look for missing legislators
			// if($count==0){
			// 		array_push($officialsOutput, $official);
			// }

		}

        // close curl resource to free up system resources
        curl_close($ch);

		echo json_encode(array(divisionID=>$location, officials=>$officialsOutput));

	wp_die();
	exit();

}

function print_legislators_list(){

	echo "<table>";
	foreach ($divisdionIds as $id) {
			$result=runDivisionQuery($id);
	}
	echo "</table>";

}

function checkRemoteFile($url) {
    if (file_exists($url)) {
	 return true;
	} else {
	   return false;
	}
}

add_action( 'wp_ajax_ajax_new_legislator', 'ajax_new_legislator' );
function ajax_new_legislator(){
	$data=$_POST['data'];

	$chamber=get_chamber($data['divisionID']);
	$towns=getTowns($data['divisionID']);

	$postarr=array(
		'post_title'=>$data['name'],
		'post_status'=>'publish',
		'post_type' =>'legsilators',
		'tax_input' =>array("chamber"=>$chamber),
		"meta_input"=>array(
			"image"=>$data['pic'],
			"party"=>$data['party'],
			"division_id"=>$data['divisionID'],
			"towns"=>$towns,
			"phones"=>$data['phones'],
			"email"=>$data['email'],
			"facebook_id"=>$data['facebook_id'],
			"twitter_id"=>$data['twitter_id'],
			"websites"=>$data['websites']
		)
	);


	$post_id=wp_insert_post(  $postarr, true );

	wp_set_object_terms( $post_id, $chamber, 'chamber' );
	$attachmentID=loadFeatureImage($data['pic']);
	set_post_thumbnail( $post_id, $attachmentID );

	//echo $post_id;
	exit;
}

     function loadFeatureImage($url){
     	if($url){
     		$uploaddir = wp_upload_dir();
			$filename=end(explode('/',$url));
			$uploadfile = $uploaddir['path'] . '/' . $filename;

			$contents= file_get_contents($url);
			$savefile = fopen($uploadfile, 'w');
			fwrite($savefile, $contents);
			fclose($savefile);

			$wp_filetype = wp_check_filetype(basename($filename), null );

			$attachment = array(
			    'post_mime_type' => $wp_filetype['type'],
			    'post_title' => $filename,
			    'post_content' => '',
			    'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment, $uploadfile );

			$imagenew = get_post( $attach_id );
			$fullsizepath = get_attached_file( $imagenew->ID );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			return $attach_id;
     	}
     }

	function get_chamber($divisionID){
		$lower=array(
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
		"ocd-division/country:us/state:vt/sldl:windham-bennington",
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
		"ocd-division/country:us/state:vt/sldl:windsor-rutland"
		);

		$upper=array(
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
		);

		if( in_array($divisionID, $upper) ==true ){
			return "Senate";
		}

		if( in_array($divisionID, $lower) ==true ){
			return "House";
		}

	}

	function getTowns($divisionID){

			$towns=false;

			switch ($divisionID) {

				case "ocd-division/country:us/state:vt/sldl:addison-1":
             		return "Middlebury";
                break;
				case "ocd-division/country:us/state:vt/sldl:addison-2":
                      return "Cornwall, Goshen, Hancock, Leicester, Ripton, Salisbury";
                break;
				case "ocd-division/country:us/state:vt/sldl:addison-3":
                          return "Addison, Ferrisburgh, Panton, Vergennes, Waltham";
                break;
				case "ocd-division/country:us/state:vt/sldl:addison-4":
                          return "Bristol, Lincoln, Monkton, Starksboro";
                break;
				case "ocd-division/country:us/state:vt/sldl:addison-5":
                          return "Bridport, New Haven, Weybridge";
                break;
				case "ocd-division/country:us/state:vt/sldl:addison-rutland":
                          return "Orwell, Shoreham, Whiting, Benson";
                break;
				case "ocd-division/country:us/state:vt/sldl:bennington-1":
                          return "Pownal, Woodford";
                break;
				case "ocd-division/country:us/state:vt/sldl:bennington-2-1":
                          return "Bennington";
                break;
				case "ocd-division/country:us/state:vt/sldl:bennington-2-2":
                          return "Bennington";
                break;
				case "ocd-division/country:us/state:vt/sldl:bennington-3":
                          return "Glastenbury, Shaftsbury, Sunderland";
                break;
				case "ocd-division/country:us/state:vt/sldl:bennington-4":
                          return "Arlington, Manchester, Sandgate, Sunderland";
                break;
				case "ocd-division/country:us/state:vt/sldl:bennington-rutland":
                          return "Dorset, Landgrove, Peru, Danby, Mount Tabor";
                break;
				case "ocd-division/country:us/state:vt/sldl:caledonia-1":
                          return "Barnet, Ryegate, Waterford";
                break;
				case "ocd-division/country:us/state:vt/sldl:caledonia-2":
                          return "Hardwick, Stannard, Walden";
                break;
				case "ocd-division/country:us/state:vt/sldl:caledonia-3":
                          return "St. Johnsbury";
                break;
				case "ocd-division/country:us/state:vt/sldl:caledonia-4":
                          return "Burke, Lyndon, Sutton";
                break;
				case "ocd-division/country:us/state:vt/sldl:caledonia-washington":
                          return "Danville, Peacham, Cabot";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-10":
                          return "Milton";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-1":
                          return "Richmond";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-2":
                          return "Williston";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-3":
                          return "Jericho, Underhill";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-4-1":
                          return "Charlotte, Hinesburg";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-4-2":
                          return "Hinesburg";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-5-1":
                          return "Shelburne";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-5-2":
                          return "Shelburne, St. George";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-1":
                          return "Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-2":
                          return "Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-3":
                          return "Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-4":
                          return "Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-5":
                          return "Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-6":
                          return "Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-6-7":
                          return "Burlington, Winooski";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-7-1":
                          return "South Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-7-2":
                          return "South Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-7-3":
                          return "South Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-7-4":
                          return "South Burlington";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-8-1":
                          return "Essex";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-8-2":
                          return "Essex";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-8-3":
                          return "Essex, Westford";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-9-1":
                          return "Colchester";
                break;
				case "ocd-division/country:us/state:vt/sldl:chittenden-9-2":
                          return "Colchester";
                break;
				case "ocd-division/country:us/state:vt/sldl:essex-caledonia":
                          return "Kirby, Brunswick, Concord, Granby, Guildhall, Lunenburg, Maidstone, Victory";
                break;
				case "ocd-division/country:us/state:vt/sldl:essex-caledonia-orleans":
                          return "Newark, Averill, Avery's Gore, Bloomfield, Brighton, Canaan, East Haven, Ferdinand, Lemington, Lewis, Norton, Warner's Grant, Warren's Gore, Westmore
";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-1":
                          return "Georgia";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-2":
                          return "Fairfax";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-3-1":
                          return "St. Albans";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-3-2":
                          return "St. Albans";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-4":
                          return "Sheldon, Swanton";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-5":
                          return "Berkshire, Franklin, Highgate, Richford";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-6":
                          return "Bakersfield, Fairfield, Fletcher";
                break;
				case "ocd-division/country:us/state:vt/sldl:franklin-7":
                          return "Enosburg, Montgomery";
                break;
				case "ocd-division/country:us/state:vt/sldl:grand_isle-chittenden":
                          return "Albergh, Grand Isle, Isle LaMotte, Milton, North Hero, South Hero";
                break;
				case "ocd-division/country:us/state:vt/sldl:lamoille-1":
                          return "Stowe";
                break;
				case "ocd-division/country:us/state:vt/sldl:lamoille-2":
                          return "Belvidere, Hyde Park, Johnson, Wolcott";
                break;
				case "ocd-division/country:us/state:vt/sldl:lamoille-3":
                          return "Cambridge, Waterville";
                break;
				case "ocd-division/country:us/state:vt/sldl:lamoille-washington":
                          return "Elmore, Morristown, Woodbury, Worcester";
                break;
				case "ocd-division/country:us/state:vt/sldl:orange-1":
                          return "Chelsea, Corinth, Orange, Vershire, Washington, Williamstown";
                break;
				case "ocd-division/country:us/state:vt/sldl:orange-2":
                          return "Bradford, Fairlee, West Fairlee";
                break;
				case "ocd-division/country:us/state:vt/sldl:orange-caledonia":
                          return "Groton, Newbury, Topsham";
                break;
				case "ocd-division/country:us/state:vt/sldl:orange-washington-addison":
                          return "Granville, Braintree, Brookfield, Randolph, Roxbury";
                break;
				case "ocd-division/country:us/state:vt/sldl:orleans-1":
                          return "Brownington, Charleston, Derby, Holland, Morgan";
                break;
				case "ocd-division/country:us/state:vt/sldl:orleans-2":
                          return "Coventry, Irasburg, Newport, Troy";
                break;
				case "ocd-division/country:us/state:vt/sldl:orleans-caledonia":
                          return "Sheffield, Wheelock, Albany, Barton, Craftsbury, Glover, Greensboro";
                break;
				case "ocd-division/country:us/state:vt/sldl:orleans-lamoille":
                          return "Eden, Jay, Lowell, Troy, Westfield";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-1":
                          return "Ira, Poultney";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-2":
                          return "Clarendon, Proctor, Tinmouth, Wallingford, West Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-3":
                          return "Castleton, Fair Haven, Hubbardton, West Haven";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-4":
                          return "Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-5-1":
                          return "Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-5-2":
                          return "Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-5-3":
                          return "Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-5-4":
                          return "Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-6":
                          return "Brandon, Pittsford, Sudbury";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-bennington":
                          return "Rupert, Middletown Springs, Pawlet, Tinmouth, Wells";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-windsor-1":
                          return "Chittenden, Killington, Mendon, Bridgewater";
                break;
				case "ocd-division/country:us/state:vt/sldl:rutland-windsor-2":
                          return "Mount Holly, Shrewsbury, Ludlow";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-1":
                          return "Berlin, Northfield";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-2":
                          return "Barre";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-3":
                          return "Barre";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-4":
                          return "Montpelier";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-5":
                          return "East Montpelier, Middlesex";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-6":
                          return "Calais, Marshfield, Plainfield";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-7":
                          return "Duxbury, Fayston, Moretown, Waitsfield, Warren";
                break;
				case "ocd-division/country:us/state:vt/sldl:washington-chittenden":
                          return "Bolton, Buels Gore, Huntington, Waterbury";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-1":
                          return "Guilford, Vernon";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-2-1":
                          return "Brattleboro";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-2-2":
                          return "Brattleboro";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-2-3":
                          return "Brattleboro";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-3":
                          return "Athens, Brookline, Grafton, Rockingham, Westminster, Windham";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-4":
                          return "Dummerston, Putney, Westminster";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-5":
                          return "Marlboro, Newfane, Townshend";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-6":
                          return "Halifax, Whitingham, Wilmington";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-bennington,vt-lower-windham-bennington":
                          return "Readsboro, Searsburg, Stamford, Dover, Somerset, Wardsboro, Whitingham";
                break;
				case "ocd-division/country:us/state:vt/sldl:windham-bennington-windsor":
                          return "Winhall, Jamaica, Londonderry, Stratton, Weston";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-1":
                          return "Hartland, West Windsor, Windsor";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-2":
                          return "Cavendish, Weathersfield";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-3-1":
                          return "Andover, Baltimore, Chester, Springfield";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-3-2":
                          return "Springfield";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-4-1":
                          return "Barnard, Hartford, Pomfret";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-4-2":
                          return "Hartford";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-5":
                          return "Plymouth, Reading, Woodstock";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-orange-1":
                          return "Tunbridge, Royalton";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-orange-2":
                          return "Strafford, Thetford, Norwich, Sharon";
                break;
				case "ocd-division/country:us/state:vt/sldl:windsor-rutland" :
						return "Pittsfield, Bethel, Rochester, Stockbridge";
				break;
				/* senate */
				case "ocd-division/country:us/state:vt/sldu:addison":
                          return "Addison";
                break;
				case "ocd-division/country:us/state:vt/sldu:bennington":
                          return "Bennington";
                break;
				case "ocd-division/country:us/state:vt/sldu:caledonia":
                          return "Caledonia";
                break;
				case "ocd-division/country:us/state:vt/sldu:chittenden":
                          return "Chittenden";
                break;
				case "ocd-division/country:us/state:vt/sldu:essex-orleans":
                          return "Essex-Orleans";
                break;
				case "ocd-division/country:us/state:vt/sldu:franklin":
                          return "Franklin";
                break;
				case "ocd-division/country:us/state:vt/sldu:grand_isle-chittenden":
                          return "Grand Isle/Chittenden";
                break;
				case "ocd-division/country:us/state:vt/sldu:lamoille":
                          return "Lamoille";
                break;
				case "ocd-division/country:us/state:vt/sldu:orange":
                          return "Orange";
                break;
				case "ocd-division/country:us/state:vt/sldu:rutland":
                          return "Rutland";
                break;
				case "ocd-division/country:us/state:vt/sldu:washington":
                          return "Washington";
                break;
				case "ocd-division/country:us/state:vt/sldu:windham":
				      return "Windham";
				break;
				case "ocd-division/country:us/state:vt/sldu:windsor":
					return "Windsor";
				break;

			}

	}

	//load file
add_action( 'wp_ajax_ajax_update_bills', 'ajax_update_bills' );
function ajax_update_bills(){
	$data==($_POST['data']);
	$legislatorID=$_POST['data']['legislatorID'];
	$bills=$_POST['data']['bills'];

	$currentYear=$_POST['data']['currentYear'];
	$currentScore=$_POST['data']['currentScore'];

	$updatedBills=$_POST['data']['bills'];
	$legislatorID=$_POST['data']['legislatorID'];		//Get all bills and update/add where necesary.
	$existingBills=get_post_meta( $legislatorID, 'Bills', true );
	$allBills=json_decode($existingBills, true);

	//merge bills
	foreach ($bills as $k=>$v){
		$allBills[$k]=$v;
	}

	$billsJSON=json_encode($allBills);

	//echo "current score:".$currentScore;

	//update Current Year Score
	$scores=updateCurrentScores($currentYear, $currentScore, $legislatorID );
	//echo "Scores:".$scores;
	//echo "legislatorID: $legislatorID";
	$res=update_post_meta($legislatorID, "Bills", $billsJSON);

	echo $res;

	wp_die();
	exit();

}

function updateCurrentScores($currentYear, $currentScore, $legislatorID ){
	$scores=get_post_meta( $legislatorID, "ScorecardScores",  true );

	if($scores){
		$scores_a=json_decode($scores);
		$c="year".$currentYear;
		$scores_a->$c=$currentScore;
	} else {
		$scores_a=array("year".$currentYear=>$currentScore);
	}
	$scoresJSON=json_encode($scores_a);
	$res=update_post_meta($legislatorID, "ScorecardScores", $scoresJSON);

	$res="$legislatorID, ScorecardScores, $scoresJSON";

	return $res;
}

	//Update Lifetime Score
add_action( 'wp_ajax_ajax_update_lifetime_score' , 'ajax_update_lifetime_score');
function ajax_update_lifetime_score(){
	$score=$_POST['LifetimeScore'];
	 $legislatorID=$_POST['legislatorID'];

	$res=update_post_meta($legislatorID, "lifetime_score", $score);

	echo "L ID: ".$legislatorID;

	wp_die();
	exit();
}

/*************************************************/
/************* legislator search ******************/
/************************************************/

//ajax_legislator_search
add_action( 'wp_ajax_ajax_legislator_search' , 'ajax_legislator_search');
function ajax_legislator_search(){
	$city=ucwords($_POST['city']);
	$address=ucwords($_POST['address']);

	$districtData=startLegislatorSearch($address, $city);

	$senateDistrictCode=$districtData[0];
	$senateDistrictName=$districtData[1];
	$houseDistrictCode=$districtData[2];
	$houseDistrictName=$districtData[3];

		echo "<h2>Senate</h2>";
		print_results_by_district($senateDistrictCode, $city, "Senate");

		echo "<h2>House</h2>";

		print_results_by_district($houseDistrictCode, $city, "House");

	wp_die();
	exit();
}

function startLegislatorSearch($address, $city){
				$searchAddress= $address.', '.$city.", VT";

				echo "<h3 id='results_title'>Results for $searchAddress</h3>";
        $searchAddress=urlencode($searchAddress);

				$apiKey="AIzaSyCjOv-KLgr46lzBoXj2KN5bb7u1vBZeVOs";
				$query="https://www.googleapis.com/civicinfo/v2/representatives?address=".$searchAddress."&key=".$apiKey;

				/*$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $query);
        curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
				curl_setopt($ch, CURLOPT_POST, 1);

				// I swore a lot over these next two lines
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$json = curl_exec($ch);*/
           $query="https://www.googleapis.com/civicinfo/v2/representatives?address=".$searchAddress."&key=".$apiKey;
           $request_body = json_encode(array('address' => $searchAddress));

            $ch = curl_init();
        		curl_setopt($ch, CURLOPT_URL, $query);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
        		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $json = curl_exec($ch);



				curl_close($ch);

				if($json){
        //  echo $output;
				} else {
					echo "No Result Found";
				}

        //exit;
					$obj=json_decode($json);
					$divisions=$obj->divisions;

					$senateDistrictCode='';
					$senateDistrictName='';
					$houseDistrictCode='';
					$houseDistrictName='';

					if($divisions){
						foreach ($divisions as $div => $data) {

							$name=$data->name;
							if( strstr ( strtolower($name), "house")){
								$houseDistrictCode=$div;
								$houseDistrictName=$name;
							}
							else if( strstr ( strtolower($name), "senate")){
								$senateDistrictCode=$div;
								$senateDistrictName=$name;
							}

						}

					}

					return array(
					$senateDistrictCode,
					$senateDistrictName,
					$houseDistrictCode,
					$houseDistrictName
					);
				}

function print_results_by_district($district, $city, $chamber){

						$count=0;
						$args = array(
							'post_type' => 'legsilators',
              'post_status' => 'publish',
							'meta_query' => array(
								array(
									'key'     => 'division_id',
									'value'   => $district,
									'compare' => '=',
								),
							),
						);

					$query = new WP_Query( $args );

					$count=$count+($query->post_count);
					//	echo $count;
					if ( $query->have_posts() ) {

						while ( $query->have_posts() ) {
							$query->the_post();

							?>

							<article class='searchResult clearfix'>
								<div class='img'> <?php the_post_thumbnail('thumbnail') ?></div>

								<div class='copy'>
									<h3><a href='<?php  the_permalink(); ?>'  data-id='<?php the_id();  ?>' data-email='<?php the_field('email'); ?>' data-facebook='<?php the_field('facebook_id'); ?>' data-phone='<?php the_field('phones'); ?>'><?php the_title(); ?></a></h3>
										<?php if ($chamber=="Senate"): ?>
										<p>
										<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
										<?php
										if( get_field('second_party') && get_field('second_party') !="null"){ ?>
											<span class='party second'><?php echo substr(get_field('second_party'),0,1); ?></span>
										<?php } ?>
										<span class='towns'><strong>District: </strong><?php the_field('towns'); ?></span>
									</p>
									<?php else: ?>
									<p>
										<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
										<?php
										if( get_field('second_party')  && get_field('second_party') !="null"){ ?>
											<span class='party second'><?php echo substr(get_field('second_party'),0,1); ?></span>
										<?php } ?>
										<span class='towns'><strong>District: </strong><?php echo get_district(get_the_id()); ?></span> <em style='font-size:.8em;'>&ndash; <?php the_field('towns'); ?></em>
									</p>

									<?php endif; ?>

									<?php
									$cscore=getCurrentScore(get_the_id(), date('Y'));

									$year=$cscore[0];
									$currentYear=$cscore[1];

									$lifetime=get_post_meta( get_the_id(), 'lifetime_score', true);
									?>
									<p><?php echo $year ?> Score: <strong><?php echo $currentYear; ?></strong> Lifetime Score: <strong><?php echo $lifetime; ?>%</strong></p>


								</div>
							</article>
						<?php
							wp_reset_postdata();

							}
						}

					if($count==0){
						searchTown($city, $chamber);
					}
}

function searchTown($city, $chamber){

	$senateDistrictList=array();

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:addison
']=explode(",", "Addison,Bridport,Bristol,Buels Gore,Cornwall,Ferrisburgh,Goshen,Granville,Hancock,Huntington,Leicester,Lincoln,Middlebury,Monkton,New Haven,Orwell,Panton,Ripton,Salisbury,Shoreham,Starksboro,Vergennes,Waltham,Weybridge,Whiting");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:bennington']=explode(",","Arlington,Bennington,Dorset,Glastenbury,Landgrove,Manchester,Peru,Pownal,Readsboro,Rupert,Sandgate,Searsburg,Shaftsbury,Stamford,Sunderland,Wilmington,Winhall,Woodford");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:caledonia']=explode(",","Barnet,Bradford,Burke,Danville,Fairlee,Groton,Hardwick,Kirby,Lyndon,Newark,Newbury,Orange,Peacham,Ryegate,Sheffield,St. Johnsbury,Stannard,Sutton,Topsham,Walden,Waterford,West Fairlee,Wheelock");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:chittenden']=explode(",","Bolton,Burlington,Charlotte,Essex,Hinesburg,Jericho,Milton,Richmond,Shelburne,South Burlington,St. George,Underhill,Westford,Williston,Winooski");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:essex-orleans']=explode(",","Albany,Averill,Avery's Gore,Barton,Bloomfield,Brighton,Brownington,Brunswick,Canaan,Charleston,Concord,Coventry,Craftsbury,Derby,East Haven,Ferdinand, Glover,Granby,Greensboro,Guildhall,Holland,Irasburg,Jay,Lemington,Lewis,Lowell,Lunenburg,Maidstone,Montgomery,Morgan,Newport,Norton,Richford,Troy,Victory,Warner's Grant,Warren's Gore,Westfield,Westmore,Wolcott
");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:franklin']=explode(",","Alburg,Bakersfield,Berkshire,Enosburg,Fairfax,Fairfield,Fletcher,Franklin,Georgia,Highgate,Sheldon,St. Albans,Swanton");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:grand_isle-chittenden']=explode(",","Colchester,Grand Isle,Isle La Motte,North Hero,South Hero");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:lamoille']=explode(",","Belvidere,Cambridge,Eden,Elmore,Hyde Park,Johnson,Morristown,Stowe,Waterville");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:orange']=explode(",","Braintree,Brookfield,Chelsea,Corinth,Randolph,Strafford,Thetford,Tunbridge,Vershire,Washington,Williamstown");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:rutland']=explode(",","Benson,Brandon,Castleton,Chittenden,Clarendon,Danby,Fair Haven,Hubbardton,Ira,Killington,Mendon,Middletown Springs,Mount Tabor,Pawlet,Pittsfield,Pittsford,Poultney,Proctor,Rutland,Shrewsbury,Sudbury,Tinmouth,Wallingford,Wells,West Haven,West Rutland");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:washington']=explode(",","Barre,Berlin,Cabot,Calais,Duxbury,East Montpelier,Fayston,Marshfield,Middlesex,Montpelier,Moretown,Northfield,Plainfield,Roxbury,Waitsfield,Warren,Waterbury,Woodbury,Worcester");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:windham']=explode(",","Athens,Brattleboro,Brookline,Dover,Dummerston,Grafton,Guilford,Halifax,Jamaica,Marlboro,Newfane,Putney,Rockingham,Somerset,Stratton,Townshend,Vernon,Wardsboro,Westminster,Whitingham,Windham");

	$senateDistrictList['ocd-division/country:us/state:vt/sldu:windsor']=explode(",","Andover,Baltimore,Barnard,Bethel,Bridgewater,Cavendish,Chester,Hartford,Hartland,Londonderry,Ludlow,Mount Holly,Norwich,Plymouth,Pomfret,Reading,Rochester,Royalton,Sharon,Springfield,Stockbridge,Weathersfield,West Windsor,Weston,Windsor,Woodstock");

	if($chamber=="House"){
		$args = array (
			'post_type' => 'legsilators',
			'meta_query' => array(
				array(
					'key'     => 'towns',
					'value'   => $city,
					'compare' => 'LIKE',
					),
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'chamber',
						'field'    => 'slug',
						'terms'    => 'House',
						'operator' => 'IN',
					),
			)
		);

	} else if($chamber=="Senate"){

			foreach($senateDistrictList as $dist=>$towns) {
				if(in_array($city, $towns)){
					$senateDistrictID=$dist;
				}
			}

			$args = array (
				'post_type' => 'legsilators',
				'meta_query' => array(
					array(
						'key'     => 'division_id',
						'value'   => $senateDistrictID,
						'compare' => '=',
						),
					),
					'tax_query' => array(
						array(
							'taxonomy' => 'chamber',
							'field'    => 'slug',
							'terms'    => 'Senate',
						)
					)
			);

	}


	$query = new WP_Query( $args );

	$count=$count+($query->post_count);

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			$towncheck=true;
			if($chamber=="House"){
				$towncheck= townCheck(get_field('towns'),$city);
			} else {
				$towncheck=true;
			}

			if  (get_field("currently_in_office")!="false" && $towncheck==true ) { ?>

				<article class='searchResult clearfix'>

					<div class='img'> <?php the_post_thumbnail('thumbnail') ?></div>

					<div class='copy'>
						<?php
						$phone=explode(",", get_field('phones'));
						?>
						<h3><a href='<?php  the_permalink(); ?>' data-id='<?php the_id();  ?>' data-email='<?php the_field('email'); ?>' data-facebook='<?php the_field('facebook_id'); ?>' data-phone='<?php  echo $phone[0]; ?>'><?php the_title(); ?></a></h3>
						<?php if ($chamber=="Senate"): ?>
							<p>
							<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
							<?php
							if( get_field('second_party')){ ?>

								<span class='party second'><?php echo substr(get_field('second_party'),0,1); ?></span>
							<?php } ?>
							<span class='towns'><strong>District:  </strong><?php the_field('towns'); ?></span>
						</p>
						<?php else: ?>
						<p>
							<span class='party'><?php echo substr(get_field('party'),0,1); ?></span>
							<?php
							if( get_field('second_party')){ ?>
								<span class='party second'><?php echo substr(get_field('second_party'),0,1); ?></span>
							<?php } ?>

							<span class='towns'><strong>District: </strong><?php echo get_district(get_the_id()); ?></span>
							<em style='font-size:.8em;'>&ndash; <?php the_field('towns'); ?></em>
						</p>

						<?php endif; ?>
						<br />
						<?php
						$cscore=getCurrentScore(get_the_id(), date('Y'));

						$year=$cscore[0];
						$currentYear=$cscore[1];

						$lifetime=get_post_meta( get_the_id(), 'lifetime_score', true); ?>
						<p><?php echo $year ?> Score: <strong><?php echo $currentYear; ?></strong> Lifetime Score: <strong><?php echo $lifetime; ?>%</strong></p>
					</div>
				</article>
			<?php 
			}
		}
	}
}

function townCheck($towns ,$city) {

	$check=false;
	$towns_a=explode(", ", $towns);
	foreach($towns_a as $t){

		if($city==trim($t)){
			$check=true;
		}
	}

	return $check;
}


?>