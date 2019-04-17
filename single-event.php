<?php
/*
Template Name: Events Page
**/
get_header(); ?>
            <?php
            if( is_user_logged_in() ){

            }

            ?>
            <div class="content-container container">
              <!-- Main Content Row -->
              <div class="row mt-3">

                <div class="col-sm-12 col-lg-4">
                  <?php
                  $featured_img_url = get_the_post_thumbnail_url();
                  if(!$featured_img_url){
                    $featured_img_url = 'https://www.encyclopediavirginia.org/filestore/8/8/2/0_8fc9623885e5d52/8820pre_664fcf550b47c58.jpg';
                  }
                  ?>
                  <img src="<?php echo $featured_img_url ?>" alt="">
                </div>

                <div class="col-sm-12 col-lg-8">
                  <h1><?php the_title(); ?></h1>
                  <h5 class="card-subtitle mb-2 text-muted"><?php echo get_field('start_date') . ' to ' . get_field('end_date'); ?></h5>
                  <?php the_content(); ?>
                </div>

              </div>
            <div class="row mt-5">
              <div class="col-lg-6">
                <h4>Related People</h4>
                <ul class="list-group">
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                </ul>
              </div>
              <div class="col-lg-6">
                <h4>Related Locations</h4>
                <ul class="list-group">
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                  <li class="list-group-item">Here is some text</li>
                </ul>
              </div>
            </div>

        </div>
    </div>


<?php get_footer(); ?>