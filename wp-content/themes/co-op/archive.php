<?php get_header(); ?>

	<main class="main clear" role="main">
		
		<section id="content">

			<div class="container clear">

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>
			
			</div>
			<!-- /.container -->

		</section>
		<!-- /#conent -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
