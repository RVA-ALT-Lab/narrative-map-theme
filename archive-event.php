<?php get_header(); ?>
    <div class="content-container container">
      <h1>Events</h1>
      <div class="row">
      <?php if ( have_posts() ) : ?>

        <?php
        /* Start the Loop */
        while ( have_posts() ) :
          the_post();
        ?>
          <?php
            $featured_img_url = get_the_post_thumbnail_url();
            if(!$featured_img_url){
              $featured_img_url = 'https://www.encyclopediavirginia.org/filestore/8/8/2/0_8fc9623885e5d52/8820pre_664fcf550b47c58.jpg';
            }
          ?>

          <div class="col-lg-4 col-sm-12">
            <div class="card">
              <img src="<? echo $featured_img_url; ?>" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title"><?php the_title(); ?></h5>

                <?php
                $start_date = get_field('start_date');
                $end_date = get_field('end_date');
                ?>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $start_date . ' to ' . $end_date; ?></h6>
                <p class="card-text"><?php the_content(); ?></p>
                <a href="<?php the_permalink(); ?>">Read More</a>
              </div>
            </div>
          </div>

        <?php
        endwhile;

        the_posts_navigation();

      else :

        get_template_part( 'template-parts/content', 'none' );

      endif;
      ?>

      </div>
      <!-- End Row -->
    </div>


<?php get_footer(); ?>