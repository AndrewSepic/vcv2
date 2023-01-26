<!doctype html>

<html lang="en">
<head>
	<title><?php wp_title(); ?></title>
  <meta charset="utf-8">
  	<script src="https://use.typekit.net/yfo2xgh.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://kit.fontawesome.com/fc01fefdc5.js"></script>
 <?php wp_head(); ?>

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body <?php  body_class();  ?>>
    <header class=' layout  clearfix'>
    	<div class="container" >
        <h1 id="logo"><a href='/index.php'><span>Vermont Conservation Voters</span></a></h1>
        <nav id='secondary'>
            <ul>
                <li>
                    <form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
                        <input type="text" size="18" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="term" />
                        <a href='#' id="searchsubmit"  ></a>
                    </form>
                </li>
                <li class='facebook'><a href='https://www.facebook.com/VermontConservationVoters/' target='blank'></a></li>
                <li class='twitter'><a href="https://twitter.com/VoteGreenVT" target='blank'></a></li>
                <li class="mobileToggle"><a href=""><b></b><b></b><b></b></a></li>
            </ul>
        </nav>    
        <nav id='primary'>
            <ul id="menu">
            	<?php 
                    $args=array(
                    'menu'=>'Primary', 
                    'container'=>false,
                    'items_wrap'      => '%3$s'
                    );
                    wp_nav_menu( $args );
                ?>
                <li class='sm'><a href='#' class='btn joinUs' id="topJoinBtn">Join Us</a></li>
                <li class='sm'><a href='https://secure.everyaction.com/cHC6GZ1vyEG2YKfnZYPEQg2' target='_blank' class='btn donate'>Donate</a></li>
            </ul>
        </nav>
    </div>
     <div id="joinBar" class="clearfix">
        		<div  class='container '>
        			        			
		            <form action="//vermontconservationvoters.us14.list-manage.com/subscribe/post?u=6a6bb07fe0e42b79b3d6aa90e&amp;id=b54e872c56" method="post" >
		                <label>Join Us</label>
		                <input placeholder="Email Address..."  name='EMAIL' type='text' />
		               </form>
		                <div class='explainer'>
		                	When you sign up to join VCV in our work, you will receive action alerts and information.
		                </div>
		                <a href="" class="close"></a>
	            </div>
           </div>
 </header>