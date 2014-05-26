				<div style="clear:both;"></div>
				</article>
				<div class="footer_container">
					<div class="footer">
					<?php
						// Element de legende de l'image (copyright)
						if(get_field('legende_image_footer'))
						{
							echo '<div class="footer_left">' . get_field('legende_image_footer') . '</div>';
						}
					?>						
						<div class="small_footer">
							handmade by <a href="http://the-agencies.ch" class="no_style">www.agencies.ch</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		</div>
				
		<?php
			wp_footer();
		?>
</html>