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
                <script>
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                    ga('create', 'UA-53615222-1', 'auto');
                    ga('send', 'pageview');
                </script>
</html>