<?php

function get_action_modal() {
	if(is_singular('portal_page')) { ?>
<div class="action-modal-wrapper">
	<div class="action-modal">
		<div class="action-modal-inner">
			<div class="action-modal-innter-box">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ajax/tail-spin.svg" alt="Action icon" />
				<div class="action-modal-state"></div>
			</div>
		</div>
	</div>
</div>
<?php }
}