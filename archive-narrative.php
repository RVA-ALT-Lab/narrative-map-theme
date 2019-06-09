<?php get_header(); ?>
  <div class="content-container container-fluid" id="narrative-section">
    <div class="row">
      <div class="narrative-title-section" style="background: url(<?php echo get_stylesheet_directory_uri().'/images/virginia-map-1883.jpg'; ?>)">
        <div class="col-lg-12 title-container">
          <h1>Mapping Black Religion and Politics in Post-Emancipation Virginia</h1>
          <hr>
          <h2>
          A Digital History Project by <br>
          Nicole Myers Turner, PhD
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
          <div class="step"
          data-step="<?php echo $index; $index++ ?>"

          data-json='<?php echo acf_fetch_map_json(); ?>'

          data-focus-latitude='<?php echo acf_fetch_map_focus_latitude(); ?>'
          data-focus-longitude='<?php echo acf_fetch_map_focus_longitude(); ?>'
          data-focus-zoom='<?php echo acf_fetch_map_focus_zoom(); ?>'
          data-focus-transition='<?php echo acf_fetch_map_focus_transition(); ?>'

          data-map-title='<?php echo acf_fetch_map_title(); ?>'
          data-map-legend='<?php echo acf_fetch_map_legend(); ?>'

          data-map-points='<?php echo acf_fetch_map_points(); ?>'
          data-highlighted-counties='<?php echo acf_fetch_map_highlighted_counties(); ?>'
          >
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

const colors = ['#F8C7A0', '#E3D7B1', '#DEA571', '#F9D39C' ]
const scroller = scrollama()
scroller
  .setup({
    step: '.step',
    // progress: true
  })
  .onStepEnter((response)=>{
    const instructions = MapTool.processNarrativeStepIntoInstructions(response.element)
    MapTool.performFocusTransitions(map, instructions)
    MapTool.addMapPoints(map, instructions.map.points)

    console.log(map)
  })
  .onStepExit((response)=>{
    MapTool.removeMapPoints()
  })

console.log(map)

</script>
<?php get_footer(); ?>