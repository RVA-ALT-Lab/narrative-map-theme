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
              <div class="row">
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
                  <?php the_title(); ?>
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-lg-6">
              <h3>People</h3>
              </div>
              <div class="col-sm-12 col-lg-6">
              <h3>Locations</h3>
              </div>
            </div>

        </div>
    </div>


<?php get_footer(); ?>