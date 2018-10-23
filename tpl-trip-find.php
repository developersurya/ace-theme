<?php
/**
 * Template Name: Trip Find
 */
get_header();
?>
<div class="container trip-find">
    <div class="row">
        <div class="filter-heading col-lg-12">
            <h3 class="filter-by">Filter by</h3>

        </div>

        <div class="col-lg-3 col-md-4 filter-options clearfix">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <?php echo do_shortcode('[searchandfilter id="10215"]'); ?>
                </div>
            </div><!-- .row -->
        </div><!--filter-options-->

        <div class="col-lg-9 col-md-8 search-results-wrap">
            <div class="row" id="update">

                <?php echo do_shortcode('[searchandfilter id="10215" show="results"]'); ?>
            </div>
        </div>
        
    </div>
</div>

<?php
get_footer();
