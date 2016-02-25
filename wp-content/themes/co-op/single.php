<?php get_header(); ?>

			<main class="main" role="main">
	
			<?php

			if (have_posts()): while (have_posts()) : the_post();

				$type = get_post_type( $post->ID );

				$hasAside = ( $type == 'services' || $type == 'technologies' ) ? true : false;

				$current = $post->ID;
				$parent = ( $post->post_parent != 0 ) ? $post->post_parent : $current;

			?>
		
				<section id="content"<?php if( $hasAside ) echo ' class="' . $type . ' hasAside"'; ?>>
		
					<h1 class="section-title"><?php the_title(); ?></h1>
					
					<div class="container clr">
		
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
							<?php //if ( has_post_thumbnail()) : // Check if Thumbnail exists

								//$thmb_attr = array(
								//	'class' => 'attachment-$size alignleft'
								//);

								// he_post_thumbnail( 'full', $thmb_attr ); // Fullsize image for the single post ?>
							
							<?php //endif; ?>

							<?php

							$subs_args = array(
								'post_type'			=> 'services',
								'posts_per_page'	=> -1,
								'post_parent' 		=> $parent,
								'orderby'			=> 'menu_order',
								'order'				=> 'ASC'
							);

							$subs = get_posts( $subs_args );

							if( $subs ) :
							?>
							<ul class="subnav">
								<?php
	
								foreach( $subs as $s ) :

								$isCurrent = ( $current == $s->ID ) ? true : false;
								?>
									<li class="subnav-item<?php if( $isCurrent ) echo ' current'; ?>">
										<a class="subnav-link" href="<?php echo get_post_permalink( $s->ID ); ?>"><?php echo $s->post_title; ?></a>
									</li>
								<?php
	
								endforeach;
	
								?>
							</ul>


							<?php

							endif;

							the_content();

							?>

							<a class="more triangle-side" href="/">BACK TO MAIN PAGE</a>
				
						</article>

						<?php

						// use sidebar only on custom post types
						if( $hasAside ) include( locate_template( 'sidebar.php' ) );
						
						?>
		
			<?php endwhile; ?>
		
			<?php else: ?>
		
				<!-- article -->
				<article>
		
					<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>
		
				</article>
				<!-- /article -->
		
			<?php endif; ?>

			</div>

		</section>

	</main>

<?php get_footer(); ?>
