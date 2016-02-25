<aside class="sidebar" role="complementary">

						<?php

						$side_args = array(
								'post_type'			=> get_post_type( $post->ID ),
								'posts_per_page'	=> -1,
								'meta_key'			=> 'sort_order',
								'orderby'			=> 'meta_value_num',
								'order'				=> 'ASC'
							);

						$side = get_posts( $side_args );

						?>

						<nav class="nav-aside">

							<ul class="menu-aside">
								<?php

								foreach( $side as $post ) :

									setup_postdata( $post );

									$isCurrent = ( is_single() && ( $current == $post->ID || $parent == $post->ID ) ) ? true : false;

								?>
								<li class="menu-aside-item triangle-side<?php if( $isCurrent ) echo ' current'; ?>">
									<?php if( $isCurrent ) : ?>
									<span class="menu-aside-link"><?php the_title(); ?></span>
									<?php else : ?>
									<a class="menu-aside-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php endif; ?>
									<span class="triangle"></span>
								</li>
								<?php

								endforeach;

								wp_reset_postdata();

								?>
							</ul>

						</nav>

						</aside>