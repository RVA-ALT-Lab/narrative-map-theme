<?php
/*
Template Name: Front Page
*/
?>

<?php get_header(); ?>

            <div class="front-page">
                <?php
                    $featured_img_url = get_the_post_thumbnail_url();
                    $caption = get_post(get_post_thumbnail_id())->post_excerpt;
                    if(!$featured_img_url){
                        $featured_img_url = 'https://www.encyclopediavirginia.org/filestore/8/8/2/0_8fc9623885e5d52/8820pre_664fcf550b47c58.jpg';
                    }
                ?>
                <div id="front-page" style="background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url(<?php echo $featured_img_url; ?>); background-size: cover;">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1><?php bloginfo('name'); ?></h1>
                            <p><?php  bloginfo('description');?></p>
                            <a class="btn btn-primary btn-lg" href="<?php echo get_site_url(). '/map'; ?>">Explore the Map</a>
                            <p class="small"><?php echo $caption; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


<?php get_footer(); ?>