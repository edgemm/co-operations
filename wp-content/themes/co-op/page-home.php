<?php // Template Name: Home ?>

<?php get_header(); ?>

			<main class="main" role="main">
		
				<section id="section-services" class="services">
		
					<h1 class="section-title">Services</h1>
					
					<div class="container slider">
		
						<div class="services-container">
		
					<?php
					$services_args = array(
							'post_type'			=> 'services',
							'posts_per_page'	=> -1,
							'post_parent' 		=> 0,
							'orderby'			=> 'menu_order',
							'order'				=> 'ASC'
						);
		
					$services_query = new WP_Query( $services_args );

					// store post names for "image map" classes after loop
					$service_slugs = array();
		
					if( $services_query->have_posts() ) :
		
						while( $services_query->have_posts() ) :
		
								$services_query->the_post();

								// set graphic assigned to hover over illustration below to attribute to be appended by js
								$upload_dir = wp_upload_dir();

								$service_thmb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

								$graphic = str_replace( $upload_dir[ 'url' ], "", $service_thmb_url[0] );

						?>
							<article class="service slider-content">
			
								<h1 class="service-title">
									<a class="slider-trigger" href="<?php the_permalink(); ?>" data-service="<?php echo $post->post_name; ?>" data-graphic="<? echo $graphic; ?>"><?php the_title(); ?></a>
								</h1>
			
								<div class="slider-desc">

									<?php
									
									// display children of current service
									$subs_args = array(
										'post_type'			=> 'services',
										'posts_per_page'	=> -1,
										'post_parent' 		=> $post->ID,
										'orderby'			=> 'menu_order',
										'order'				=> 'ASC'
									);
		
									$subs = get_posts( $subs_args );

									?>
									<ul class="subnav clr">
									<?php

									foreach( $subs as $s ) :

									?>
										<li class="subnav-item">
											<a class="subnav-link" href="<?php echo get_post_permalink( $s->ID ); ?>"><?php echo $s->post_title; ?></a>
										</li>
									<?php

									endforeach;

									?>
									</ul>

									<?php the_content(); ?>
			
									<a class="more triangle-side" href="<?php the_permalink(); ?>">More about <?php the_title(); ?></a>
			
								</div>
			
							</article>
						<?php

						// add slug to array for "image map" classes
						array_push( $service_slugs, $post->post_name );
						
						endwhile;
		
					endif;
		
					wp_reset_query();
					?>
						</div>
		
						<div class="slider-display">
		
							<div class="slider-container"></div>
		
						</div>
			
						<div class="services-graphic-container container">
			
							<img class="services-graphic services-all" src="<?php echo get_stylesheet_directory_uri(); ?>/img/services-graphic.png" alt="Illustration of services provided by Co-Operations">

							<?php

							// add hot spots for each service
							foreach( $service_slugs as $s ) :

								echo '<a class="service-map ' . $s . '" href="/services/' . $s . '" data-service="' . $s . '"></a>';

							endforeach;

							?>
			
						</div>
		
					</div>
		
				</section>
		
				<section id="section-technologies" class="technologies">
		
					<h1 class="section-title">Technology</h1>
					
					<div class="container slider">
		
						<div class="technologies-container clr">
		
					<?php
					$tech_args = array(
							'post_type'			=> 'technologies',
							'posts_per_page'	=> -1,
							'orderby'			=> 'menu_order',
							'order'				=> 'ASC'
						);
		
					$tech_query = new WP_Query( $tech_args );
		
					if( $tech_query->have_posts() ) :
		
						while( $tech_query->have_posts() ) :
		
								$tech_query->the_post();
						?>
							<article class="technology slider-content">
		
							<?php
							if ( has_post_thumbnail()) : // Check if Thumbnail exists
		
								$tech_thmb_attr = array(
									'class' => 'technology-img'
								);
		
								// set attributes of active state image
								$tech_thmb_active_attr = $tech_thmb_attr;
								$tech_thmb_active_attr[ 'class' ] = $tech_thmb_active_attr[ 'class' ] . " active";
		
								$tech_thmb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
								$tech_thmb_url = $tech_thmb_url[0];
								$tech_thmb_active_attr[ 'src' ] = substr_replace( $tech_thmb_url, '-active', -4, 0 );
		
							endif;
							?>
								<a class="slider-trigger" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<?php the_post_thumbnail( 'full', $tech_thmb_attr ); ?>
									<?php the_post_thumbnail( 'full', $tech_thmb_active_attr ); ?>
								</a>
		
								<h1 class="technology-title">
									<a class="slider-trigger" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h1>
			
								<div class="slider-desc">
			
									<?php the_content(); ?>
			
									<a class="more triangle-side" href="<?php the_permalink(); ?>">More about <?php the_title(); ?></a>
			
								</div>
			
							</article>
						<?php
						endwhile;
		
					endif;
		
					wp_reset_query();
					?>
		
						</div>
		
						<div class="slider-display">
		
							<div class="slider-container"></div>
		
						</div>
		
					</div>
		
				</section>
		
				<section id="section-about" class="about">
		
					<h1 class="section-title">About Us</h1>
		
					<div class="container">
		
						<?php
		
						$about = 9; // id of About Us page
		
						// display about page thumbnail (if exists)
						if( has_post_thumbnail( $about ) ) :
		
								$about_attr = array(
									'class' => 'alignleft'
								);
		
								echo get_the_post_thumbnail( $about, 'medium', $about_attr );
		
						endif;
		
						echo apply_filters( 'the_content', get_post_field( 'post_content', $about ) );
		
						?>
		
						<button class="btn more triangle-side showTeam">Meet our Team</button>

					<?php
					$team_args = array(
							'post_type'			=> 'team',
							'posts_per_page'	=> -1,
							'orderby'			=> 'menu_order',
							'order'				=> 'ASC'
						);
		
					$team_query = new WP_Query( $team_args );
		
					if( $team_query->have_posts() ) :
					
					?>
						<div class="team">

							<div class="team-container clr">
						<?php
			
							while( $team_query->have_posts() ) :
			
									$team_query->the_post();
							?>
								<div class="team-member">
			
								<?php
	
								if ( has_post_thumbnail()) : // Check if Thumbnail exists
			
									$team_thmb_attr = array(
										'class' => 'team-img'
									);
									
									the_post_thumbnail( 'medium', $team_thmb_attr );
			
								else :
								
								?>
									<img class="team-img" src="/wp-content/themes/co-op/img/avatar-generic.png" alt="Generic avatar of team member">
								<?php
	
								endif;
	
								?>
	
									<h1 class="team-name"><?php the_title(); ?></h1>
	
									<?php if( get_field( 'team_member_title' ) ) : ?>
									<div class="team-title"><?php the_field( 'team_member_title' ); ?></div>
									<?php endif; ?>
	
									<div class="team-bio"><?php the_content(); ?></div>
				
								</div>
							<?php
							endwhile;
			
						endif;
			
						wp_reset_query();
						?>
						</div>

					</div>
		
				</section>

<?php get_footer(); ?>