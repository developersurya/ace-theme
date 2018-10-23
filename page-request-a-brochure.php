<?php
get_header();
?>
    <div class="container company">
        <div class="row">
            <!-- <div class="col-lg-12">
               <?php if (get_field('top_heading')) { ?>
                    <div class="hint-text"><?php the_field('top_heading'); ?></div>
                <?php } ?>
                <h1 class="border-btm"><?php //the_title(); ?></h1> 
            </div> -->
            <div class="col-lg-offset-1 col-lg-3 col-md-4 col-sm-4 ebrochure-block">
                <?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "full");  ?>
                    <img class="img-responsive" src="<?php echo $img[0]; ?>" alt="<?php the_title(); ?>">
                <p class="ebrochure-description"><?php echo get_the_excerpt(get_the_ID()); ?></p>

                <?php if( have_rows('pdf_repeater') ): ?>

                    <h4><?php echo get_field('pdf_download_title'); ?></h4>
                    <div class="ebrochure-listing clearfix">
                        <?php while( have_rows('pdf_repeater') ): the_row();
                            $pdf_language = get_sub_field('pdf_language');
                            $pdf_file = get_sub_field('pdf_file');
                            ?>
                             <?php if( $pdf_file ): ?>
                                <a href="<?php echo $pdf_file['url']; ?>" target="_blank"><?php echo $pdf_language; ?></a>
                            <?php endif; ?>

                        <?php endwhile; ?>
                        </div><!-- .ebrochure-listing -->
                     <?php   endif; ?>
            </div>
            <div class="col-lg-offset-1 col-lg-6 col-md-8 col-sm-8"><?php if (have_posts()) : while (have_posts()) : the_post();
                    the_content();
                endwhile;
                endif;
                ?></div>
        </div>
    </div>
<?php get_footer();
