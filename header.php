<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package acethehimalaya
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <!-- Social Share -->
    <script charset="utf-8" type="text/javascript">var switchTo5x=true;</script>
     <script async charset="utf-8" type="text/javascript" src="https://w.sharethis.com/button/buttons.js"></script>
    <!-- <script async charset="utf-8" type="text/javascript">stLight.options({"publisher":"9ce9057c-e392-4176-b62b-e400e70d0ab1","doNotCopy":true,"hashAddressBar":false,"doNotHash":true});var st_type="wordpress4.5.3";</script> -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!--new shareit-->
    <script charset="utf-8" type="text/javascript">var switchTo5x=true;</script>
<script charset="utf-8" type="text/javascript" id="st_insights_js" src="https://ws.sharethis.com/button/buttons.js?publisher=9ce9057c-e392-4176-b62b-e400e70d0ab1&product=sharethis-wordpress"></script>
<script charset="utf-8" type="text/javascript">stLight.options({"publisher":"9ce9057c-e392-4176-b62b-e400e70d0ab1","doNotCopy":true,"hashAddressBar":false,"doNotHash":true});var st_type="wordpress4.9.4";</script>
<!--/new shareit-->


    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="skip-link screen-reader-text"
   href="#content"><?php esc_html_e('Skip to content', 'acethehimalaya'); ?></a>
<!-- START Display Upgrade Message for IE 9 or Less -->
<!--[if lt IE 9]>
<div style="background: #000; text-align: center; position: fixed; top: 0px; width: 100%; color: #FFF; z-index: 100;">This website may not be compatible with your outdated Internet Explorer version. <a href="https://windows.microsoft.com/en-us/internet-explorer/download-ie" target="_blank" style="color: #fff; text-decoration: underline;">Please upgrade here.</a></div>
<script type="text/javascript"> $('body').addClass('ie'); </script>
<![endif]-->
<!--[if IE 9]>
<div style="background: #000; text-align: center; position: fixed; top: 0px; width: 100%; color: #FFF; z-index: 100;">This website may not be compatible with your outdated Internet Explorer version. <a href="https://windows.microsoft.com/en-us/internet-explorer/download-ie" target="_blank" style="color: #fff; text-decoration: underline;">Please upgrade here.</a></div>
<script type="text/javascript"> $('body').addClass('ie'); </script>
<![endif]-->
<div class="mobile-nav-wrap  clearfix">

    <?php wp_nav_menu(
        array('menu' => 'primary',
            'container' => 'nav',
            'container_class' => 'main-nav primary-menu',
            'container_id' => 'navigation-menu',
            'menu_class' => 'group',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '', 'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 0, 'walker' => '',
            'theme_location' => 'primary_menu'
        ));
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $('#menu-primary-menu').append('<li class=""><a href="/blog">Blog</a></li>' +
                '<li class=""><a href="/company/reviews/">Reviews</a></li>' +
                '<li class=""><a href="/contact-us">Contact us</a></li>' +
                '<li class=""><a href="/request-a-brochure/">Request a Brochure</a></li>'
            );
        });
    </script>
</div>
<div class="conntainer-fluid">
    <div class="mobile-menu">
        <div class="top-space">
            <div class="top-header">

                <div class="site-header">
                    <div class="site-branding">
                        <a class="logo" href="<?php echo site_url(); ?>"><img
                                src="<?php the_field('site_logo', 'option') ?>"
                                alt="Acethehimalaya logo"></a>
                        <img class="ace-slogan" src="<?php the_field('ace_slogan', 'option'); ?>"
                             alt="Acethehimalaya Slogan">
                    </div><!-- .site-branding -->
                    <div class="phone-list-trigger"><img src="<?php echo get_template_directory_uri(); ?>/images/phone.svg" alt="Phone icon" /></div>
                    <?php

                    // check if the repeater field has rows of data
                    if( have_rows('header_phone_number', 'option') ): ?>
                        <div class="quick-contact--menu-secondary">
                            <ul class="quick-contact clearfix">
                                <?php // loop through the rows of data
                                while ( have_rows('header_phone_number', 'option') ) : the_row();

                                    // display a sub field value
                                    $phone_label = get_sub_field('phone_label');
                                    $phone = get_sub_field('phone_number');
                                    $phone_number = preg_replace('/\D/', '', $phone);
                                    ?>
                                    <li>
                                        <span class="contact-region"><?php echo $phone_label; ?></span>
                                        <a class="quick-contact-main" href="tel:<?php echo $phone_number; ?>">
                                            <span class="icon-phone"></span><span
                                                class="num"><?php echo $phone; ?></span>
                                        </a>
                                    </li>
                                <?php  endwhile; ?>

                            </ul>
                        </div>
                    <?php  endif;  ?>

                </div>

                <div class="mobile-nav-btn"><span></span></div>

            </div>
        </div>
    </div>
    <header id="masthead">
        <div class="site-header">
            <div class="site-branding">
                <a class="logo" href="<?php echo site_url(); ?>"><img
                        src="<?php the_field('site_logo', 'option') ?>"
                        alt="Acethehimalaya logo"></a>
                <img class="ace-slogan" src="<?php the_field('ace_slogan', 'option'); ?>"
                     alt="Acethehimalaya Slogan">
            </div><!-- .site-branding -->

            <?php

            // check if the repeater field has rows of data
            if( have_rows('header_phone_number', 'option') ): ?>
            <div class="quick-contact--menu-secondary">
                <ul class="quick-contact clearfix">
               <?php // loop through the rows of data
                while ( have_rows('header_phone_number', 'option') ) : the_row();

                    // display a sub field value
                    $phone_label = get_sub_field('phone_label');
                    $phone = get_sub_field('phone_number');
                    $phone_number = preg_replace('/\D/', '', $phone);
                    ?>
                    <li>
                        <span class="contact-region"><?php echo $phone_label; ?></span>
                        <a class="quick-contact-main" href="tel:<?php echo $phone_number; ?>">
                            <span class="icon-phone"></span><span
                                class="num"><?php echo $phone; ?></span>
                        </a>
                    </li>
            <?php  endwhile; ?>

                </ul>
            </div>
            <?php  endif;  ?>

        </div><!-- .site-header -->

        <div class="nav-wrap clearfix">

            <?php wp_nav_menu(
                array('menu' => 'primary',
                    'container' => 'nav',
                    'container_class' => 'main-nav primary-menu',
                    'container_id' => 'navigation-menu',
                    'menu_class' => 'group',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '', 'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' => 0, 'walker' => '',
                    'theme_location' => 'primary_menu'
                ));
            ?>
        </div>
    </header><!-- #masthead -->
    <div class="metabar--spacer"></div>
</div><!--.container-fluid-->
<div id="content" class="site-content">
