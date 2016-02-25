<?php

require_once( locate_template( "inc/mobile_detect.php" ) );
$detect = new Mobile_Detect;

$mobile_class = ( $detect->isMobile() ) ? "isMobile" : "notMobile";

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	<body <?php body_class( $mobile_class ); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<header class="header clr" role="banner">
				
				<div id="masthead" class="clr">
					
					<div class="container">

						<div class="logo">
							<a href="<?php echo home_url(); ?>">
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" class="logo-img" alt="">
							</a>
						</div>
						<!-- /logo -->	
	
						<nav id="nav" class="nav clr" role="navigation">
							<button class="nav-trigger">
								<span class="nav-trigger-container">
									<span></span><span></span><span></span><span></span>
								</span>
							</button>
							
							<?php html5blank_nav(); ?>
						</nav>
						<!-- /nav -->

					</div>

				</div>

				<div class="banner">

				<?php if ( is_home() || is_front_page() ) : ?>
					<div class="container">

					<?php
					if ( have_posts() ) :

						while ( have_posts() ) :

							the_post();

							echo '<h1 class="banner-heading triangle-side">' . strip_tags( get_the_content() ) . '</h1>';

						endwhile;

					endif;
					
					wp_reset_postdata();
					?>

					</div>

				<? endif; ?>

				</div>

			</header>
			<!-- /header -->
