<?php // Facebook Popup Contents ?>
<div class="state-fb-pop-up-wrap">					
	<div class="fb-page" data-href="https://www.facebook.com/<?php echo sanitize_text_field($url); ?>" data-width="318" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
		<div class="fb-xfbml-parse-ignore">
			<blockquote cite="https://www.facebook.com/<?php echo sanitize_text_field($url); ?>">
				<a href="https://www.facebook.com/<?php echo sanitize_text_field($url); ?>"><?php echo sanitize_text_field($title); ?></a>
			</blockquote>
		</div>
	</div>
</div>