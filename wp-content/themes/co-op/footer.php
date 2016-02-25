				<?php if ( !is_page_template( 'page-nocontact.php' ) ) : ?>
				<section id="section-contact" class="contact">
		
					<h1 class="section-title">Contact Us</h1>
		
					<div class="container clr">
		
						<?php echo do_shortcode( '[contact-form-7 id="31" title="Main Contact Form"]' ); ?>
		
					</div>
		
				</section>
				<?php endif; ?>
		
				<section id="section-locations" class="locations">
		
					<?php if ( is_page_template( 'page-nocontact.php' ) ) : ?>
					<h1 class="section-title">Locations</h1>
					<?php endif; ?>
					<div class="container clr">
		
						<div class="location">
		
							<a href="https://goo.gl/maps/rE4RQ9UCCg42" target="_blank">
								<img class="location-img" src="/wp-content/themes/co-op/img/locations-tualatin.jpg" alt="Map to Tualatin Office">
							</a>
							
							<a class="more thick triangle-side" href="https://goo.gl/maps/rE4RQ9UCCg42" target="_blank">Click to view map</a>
		
							<div class="vcard">
								<div class="adr">
									<div class="org fn">
										<div class="organization-unit"><strong>Corporate Office:</strong></div>
									</div>
									<div class="street-address">20049 SW 112th Ave.</div>
									<span class="locality">Tualatin</span>,
									<abbr class="region" title="Oregon">OR</abbr>
									<span class="postal-code">97062</span>
								</div>
								<div class="tel">
									<span class="type"><strong>Main</strong></span>
									<span class="value"><a href="tel:5036207977">503-620-7977</a></span><br>
									<span class="type"><strong>Toll Free</strong></span>
									<span class="value"><a href="tel:8662286362">866-228-6362</a></span><br>
									<span class="type"><strong>Fax</strong></span>
									<span class="value"><a href="tel:5036207917">503-620-7917</a></span><br>
									<span class="type"><strong>Sales</strong></span>
									<span class="value"><a href="tel:5036207967">503-620-7967, opt. 1</a></span>
								</div>
							</div>
		
						</div>
		
						<div class="location">
		
							<a href="https://goo.gl/maps/enfvESUsaKB2" target="_blank">
								<img class="location-img" src="/wp-content/themes/co-op/img/locations-atlanta.jpg" alt="Map to Atlanta Office">
							</a>
							
							<a class="more thick triangle-side" href="https://goo.gl/maps/enfvESUsaKB2" target="_blank">Click to view map</a>
		
							<div class="vcard">
								<div class="adr">
									<div class="org fn">
										<div class="organization-unit"><strong>Atlanta Office:</strong></div>
									</div>
									<div class="street-address">4400 Bankers Circle.</div>
									<div class="extended-address">Suite 1</div>
									<span class="locality">Atlanta</span>,
									<abbr class="region" title="Georgia">GA</abbr>
									<span class="postal-code">30360</span>
								</div>
								<div class="tel">
									<span class="type"><strong>Toll Free</strong></span>
									<span class="value"><a href="tel:8662286362">866-228-6362</a></span>
								</div>
							</div>
		
						</div>
		
					</div>
		
				</section>
		
			</main>

			<section class="pre-footer">

				<div class="container clr">

					<?php

					if( function_exists('dynamic_sidebar') ) dynamic_sidebar( 'widget-pre-footer' );

					?>					

				</div>

			</section>

			<footer id="footer" class="footer" role="contentinfo">
				
				<section class="container clr">

					<p class="footer-links">

						<a class="footer-link" href="/terms/">Terms of Use</a><br>
						<a class="footer-link" href="/privacy/">Privacy Policy</a>

					</p>

					<p class="copyright">

						&copy; <?php echo date( 'Y' ); ?> Co-Operations, Inc. All Rights Reserved

					</p>

				</section>

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

	</body>
</html>