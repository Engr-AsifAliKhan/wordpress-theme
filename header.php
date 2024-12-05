<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
    
    <!-- Hamburger Menu Icon for Mobile -->
    <button class="hamburger-menu" aria-label="Open menu">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
    </button>

    <nav>
        <?php wp_nav_menu(array(
            'theme_location' => 'primary',
            'depth' => 3, // Limit the depth of the nav
            'container' => 'div',
            'container_class' => 'main-menu',
            'menu_class' => 'nav-menu',
        )); ?>
    </nav>
</header>
