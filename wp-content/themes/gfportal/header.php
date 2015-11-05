<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php admin_tools(); ?>
	<div id="header">
		<div class="container">
			<div class="row">
				<div class="col-xs-2">
					<a href="<?php echo get_site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="logo"></a>
				</div>
				<div class="col-xs-10 text-right">
				<?php if(is_user_logged_in()) { ?>
					<div class="account pull-right">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a aria-expanded="false" role="button" aria-haspopup="true" data-toggle="dropdown" class="dropdown-toggle" href="#" id="drop1">
									My Account
									<span class="caret"></span>
								</a>
								<ul aria-labelledby="drop1" role="menu" class="dropdown-menu">
									<li role="presentation"><a href="<?php echo get_site_url() . '/account/'; ?>" tabindex="-1" role="menuitem">View my account</a></li>
									<li role="presentation"><a href="<?php echo wp_logout_url(get_site_url()); ?>" tabindex="-1" role="menuitem" data-action="save" class="btn">Save & Sign out</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="search pull-right relative">
						<input type="text" placeholder="Search" class="form-control col-md-3">
						<span aria-hidden="true" class="glyphicon glyphicon-search form-control-icon"></span>
					</div>
				<?php } else { ?>
					<div class="main-link pull-right">
						<a href="https://www.guidantfinancial.com">Back to Guidant Financial</a>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>