<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php the_title() ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="container-fluid">
        <div class="row site-wrapper">
            <div class="side-nav">
                <nav>
                    <ul>
                        <li>
                            <a href="<?php echo get_home_url();?>">
                            <i class="fa fa-2x fa-home"></i>
                            <p>Home</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/narrative';?>" id="openPoints">
                                <i class="fa fa-2x fa-map-signs"></i>
                                <p>Narrative</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/map';?>">
                            <i class="fa fa-2x fa-map"></i>
                            <p>Map</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/location';?>" id="openPoints">
                                <i class="fa fa-2x fa-map-pin"></i>
                                <p>Locations</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/person';?>">
                                <i class="fa fa-2x fa-user"></i>
                                <p>People</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/event';?>">
                                <i class="fa fa-2x fa-calendar"></i>
                                <p>Events</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/about';?>">
                            <i class="fa fa-2x fa-question"></i>
                            <p>About</p>
                            </a>
                        </li>
                        <hr>
                    </ul>
                </nav>
            </div>