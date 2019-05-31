<?php get_header(); ?>
  <div class="content-container container" id="narrative-section">
    <div class="row">
      <div class="col-lg-12">
        <h1>Narrative</h1>
      </div>
      <div class="col-lg-4">
          <div class="step" data-step="1">
            step 1
          </div>
          <div class="step" data-step="2">
          step 2
          </div>
          <div class="step" data-step="3">
          step 3
          </div>
          <div class="step" data-step="4">
          step 4
          </div>
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
    step: '.step'
  })
  .onStepEnter(()=>console.log('entering'))
  .onStepExit(()=>console.log('exiting'))

</script>
<?php get_footer(); ?>