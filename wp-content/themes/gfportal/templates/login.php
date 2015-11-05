<?php
/*
	Template Name: Login
*/
?>
<?php get_header(); ?>

<div class="container">
	<div id="main-content">
		<?php if(!is_user_logged_in()) : ?>
			<div class="vcenter-wrapper">
				<div class="vcenter">
					<form class="login-form" method="post" action="<?php echo get_permalink(); ?>">
						<?php if(isset($_POST['submit'])) : ?>
						<?php
							$vague_error = 'An error occurred';

							$credentials = array();
							$credentials['user_login'] = $_POST['email'];
							$credentials['user_password'] = $_POST['password'];
							$credentials['remember'] = false;

							$user = wp_signon($credentials, false);

							if(is_wp_error($user)) {
								if($user->get_error_code() == 'invalid_username') {
									$sso = SalesForce::communities_signon($credentials, 'https://training-guidant-financial.cs15.force.com/CommunityLogin');

									if(!$sso) {
										echo '<p>' . $vague_error . '</p>';
									} else {
										$user_id = wp_create_user($credentials['user_login'], $credentials['user_password'], $credentials['user_login']);
										update_user_meta($user_id, 'sforce_account_id', $sso['account_id']);
										update_user_meta($user_id, 'sforce_contact_id', $sso['contact_id']);
										update_user_meta($user_id, 'sfile_id', $sso['sfile_id']);
										wp_signon($credentials, false);
										wp_redirect(get_site_url());
									}
								} else {
									echo '<p>' . $vague_error . '</p>';
								}
							} else {
								// success, refresh account attached to user incase it was changed
								$account_id = SalesForce::get_contact_account(get_user_meta($user->ID, 'sforce_contact_id', true));

								if($account_id)
									update_user_meta($user->ID, 'sforce_account_id', $account_id);

								wp_redirect(get_site_url());
							}
						?>
						<?php endif; ?>
						<div class="form-group">
							<label for="email">Username</label>
							<input name="email" type="text" class="form-control" placeholder="Email address">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input name="password" type="password" class="form-control" placeholder="Password">
						</div>
						<input name="submit" type="submit" class="btn btn-primary" value="Submit">
					</form>
				</div>
			</div>
		<?php else : ?>
			<p>You are already logged in.</p>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>