<?php get_header(); ?>

			<main class="main" role="main">
				
				<section id="content">
				
					<h1 class="section-title"><?php the_title(); ?></h1>
		
					<div class="container clr">
			
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>	
			
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
							<?php the_content(); ?>
			
						</article>
			
					<?php
					
					endwhile;
			
					endif;
					
					?>
		
					</div>
		
				</section>

<?php get_footer(); ?>