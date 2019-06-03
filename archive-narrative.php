<?php get_header(); ?>
  <div class="content-container container-fluid" id="narrative-section">
    <div class="row">
      <div class="narrative-title-section">
        <div class="col-lg-12">
          <h1>Mapping Black Religion and Politics in Post-Emancipation Virginia</h1>
          <h2>
          A Digital History Project by <br>
          Nicole Myers Tuner, PhD
          </h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
      <?php if ( have_posts() ) : ?>

        <?php
        $index = 1;
        /* Start the Loop */
        while ( have_posts() ) :
          the_post();
        ?>
          <div class="step" data-step="<?php echo $index; $index++ ?>" data-json='<?php echo acf_fetch_map_json(); ?>'>
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
          </div>
        <?php
          endwhile;
          the_posts_navigation();
          else :
          get_template_part( 'template-parts/content', 'none' );
          endif;
        ?>
      </div>
      <div class="col-lg-8">
        <div class="map">
          <div id="map">
          </div>
        </div>
      </div>

    </div>
    <!-- End Row -->

  </div>
  <!-- End Content Container -->

<script src="https://unpkg.com/intersection-observer"></script>
<script src="https://unpkg.com/scrollama"></script>
<script>
const scroller = scrollama()
scroller
  .setup({
    step: '.step',
    // progress: true
  })
  .onStepEnter((response)=>{
    console.log(JSON.parse(response.element.dataset.json))
    console.log(map)
  })
  .onStepExit((response)=>console.log('exiting'))
  // .onStepProgress((response) => console.log('progress'))

console.log(map)

</script>
<?php get_footer(); ?>