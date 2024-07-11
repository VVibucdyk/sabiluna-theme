<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="site-header" class="site-header" role="banner">
        <div class="header-container">
			<div class="top-header">
				<!-- Logo Section -->
				<div class="site-logo">
					<?php
						if ( has_custom_logo() ) {
							the_custom_logo();
						} else {
							?>
							<div class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</div>
							<?php
						}
					?>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				</div>
				<!-- Search -->
				<div class="header-extras">
					<form class="searchInputWrapper" action="<?php echo home_url( '/' ); ?>">
						<input class="searchInput" type="text" placeholder='cari artikel, video...'>
						<i class="searchInputIcon fa fa-search"></i>
						</input>
					</form>
				</div>

				<!-- Login Button -->
				<div class="header-extras">
					<a class="login-button" href="<?php echo wp_login_url(); ?>">Login</a>
				</div>
			</div>
			<div class="bottom-header">
				<!-- Navigation Menu -->
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
					] );
					?>
				</nav><!-- #site-navigation -->
			</div>
        </div>
    </header><!-- #site-header -->
    <div id="content" class="site-content">
