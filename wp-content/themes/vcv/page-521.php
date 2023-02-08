<?php get_header(); 
// Legislator Search Results from GET Request on page-10.php 
?>
    <section id='content' class='container '>
        <h1><?php the_title(); ?></h1>

			<?php
			$address=ucwords($_GET['address']);
			$city=ucwords($_GET['city']);

			$districtData=startLegislatorSearch($address, $city);
			$senateDistrictCode=$districtData[0];
			$senateDistrictName=$districtData[1];
			$houseDistrictCode=$districtData[2];
			$houseDistrictName=$districtData[3];

				echo "<h2>Senate</h2>";

				print_results_by_district($senateDistrictCode, $city, "Senate");

				echo "<h2>House</h2>";

				print_results_by_district($houseDistrictCode, $city, "House");

			 ?>

    </section>
    <?php get_footer(); ?>
