<?php

function admin_tools() {
	if(current_user_can('manage_options')) : ?>
		<div id="admin-tools">
			<a class="admin-tools-toggle" href="#" data-toggle="modal" data-target="#admin-tools-modal"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>Admin Tools</a>
		</div>
		<div class="modal fade" id="admin-tools-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Administrator Tools</h4>
					</div>
					<div class="modal-body"><?php list_users(); ?></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	<?php endif;
}