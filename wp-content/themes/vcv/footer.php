 <footer class='layout'>
        
        <section id='SocialMediaBar' class='clearfix'>
        	<div  class='container '>
	            <form action="//vermontconservationvoters.us14.list-manage.com/subscribe/post?u=6a6bb07fe0e42b79b3d6aa90e&amp;id=b54e872c56" method="post">
	                <!--<label>Join Us</label>
	                <input placeholder="Email Address ..."  name='EMAIL' type='email' />-->
					<a class='btn' id='footerJoinUs' href='#'>Join us</a>
	               </form>
	                <div class='socialMedia'>
	                	Get Connected 
	                    <a href='https://www.facebook.com/VermontConservationVoters/' class='facebook' target='_blank'></a>
	                    <a href='https://twitter.com/search?q=vermont%20conservation%20voters&src=typd' class='twitter' target="_blank"></a>
	                </div>
            </div>
        </section>
        
        <section id='footerInfo' class='container clearfix'>
            <div id='col1' class='col'>
                <h2>Vemont Conservation Voters</h2>
                <address>
                    <strong>M:</strong> PO Box 744, Montpelier, VT 05601<br/>
                    <strong>P:</strong> 802-224-9090<br/>
                    <strong>E:</strong> <a href='mailto:info@vermontconservationvoters.org' target='_blank'>info @ vermontconservationvoters.org</a>
                </address>
            </div>
            <div id='col2' class='col'>
                <h2>Site Links</h2>
                <nav>
                    <ul>
                         	<?
            	$args=array(
            	'menu'=>'Primary', 
				'container'=>false,
				 'items_wrap'      => '%3$s'
				);
                wp_nav_menu( $args );
                ?>
                    </ul>
                </nav>
            </div>
            <div id='col3' class='col'>
                <h2>Support Our Work</h2>
                <a href='https://secure.everyaction.com/cHC6GZ1vyEG2YKfnZYPEQg2' target='_blank' class='btn donateLink'>Donate</a>
            </div>
        </section>
    
    </footer>
	<div id='popupForm'>
		<div class='inner'>
			<header class='closer'><a href='#' class='close'>close <i class="fas fa-times"></i></a></header>
			<script type='text/javascript' src='https://d1aqhv4sn5kxtx.cloudfront.net/actiontag/at.js' crossorigin='anonymous'></script>
				 <div class="ngp-form"
					 data-form-url="https://actions.everyaction.com/v1/Forms/Y7yG-U3C0EOwwJoYQ7UoIA2"
					 data-fastaction-endpoint="https://fastaction.ngpvan.com"
					 data-inline-errors="true"
					 data-fastaction-nologin="true"
					 data-databag-endpoint="https://profile.ngpvan.com"
					 data-databag="everybody"
					 data-mobile-autofocus="false" >
				</div>
		</div>		
	</div>
	<div id='shadow'></div>
	
<?php wp_footer();  ?>
</body>
</html>