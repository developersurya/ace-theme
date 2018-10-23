<?php 
if(! function_exists( 'acethehimalaya_custom_info_section' )){
    function acethehimalaya_custom_info_section(){
        $ed_info_section = get_theme_mod( 'ed_info_section' );
        $info_text = get_theme_mod( 'info_text' );
        $info_readmore_text = get_theme_mod( 'info_readmore_text' );
        $info_youtube_link = get_theme_mod( 'info_youtube_link' );
        if( $ed_info_section ){ 
        ?>
            <section class="intro">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                            <?php
                                $intro_qry = new WP_Query(
                                    array(
                                        'page_id'     => $info_text,
                                        'post_status' => 'publish',
                                    )
                                );
                        
                                if( $intro_qry->have_posts() ){
                                    while( $intro_qry->have_posts() ){
                                        $intro_qry->the_post();
                            ?>
                            <div class="text-holder">
                              <h2 class="section-title"><?php the_title(); ?></h2>
                              <?php the_excerpt(); ?>
                              <?php if ( $info_readmore_text ) { ?>
                                <a href="<?php the_permalink(); ?>" class="btn btn-border"><?php echo esc_html( $info_readmore_text ); ?></a>
                              <?php } ?>
                            </div>
                            <?php } } ?>
                        </div>
                        <?php if( $info_youtube_link ){ ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 ">
                                <div class="media-holder">
                                    <?php $allowed_tags = array( 
                                        'iframe' => array( 
                                            'width' => array(), 
                                            'height' => array(), 
                                            'src' => array(), 
                                            'frameborder' => array(), 
                                            'gesture' => array(), 
                                            'allowfullscreen' => array() 
                                        ) 
                                    );
                                    echo wp_kses( $info_youtube_link, $allowed_tags ); ?> 
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        <?php 
        }
    }
} 
add_action( 'acethehimalaya_custom_info_section', 'acethehimalaya_custom_info_section');

if (! function_exists( 'acethehimalaya_custom_tripadvisor_section' )) {
    function acethehimalaya_custom_tripadvisor_section(){
        $ed_trip_advisor = get_theme_mod( 'ed_trip_advisor_section' );
        $trip_advisor_title = get_theme_mod( 'trip_advisor_title_section' );
        $trip_advisor_desc = get_theme_mod( 'trip_advisor_desc_section' );
        if ( $ed_trip_advisor ) {
        ?>
        <section class="section-tripadviser">
            <div class="container">
                <?php if( $trip_advisor_title ){ ?>
                <header class="section-header col-lg-12 ">
                    <div class="row">
                        <span class="heading-title"><?php echo esc_html( $trip_advisor_title ); ?></span>
                    </div>
                </header>
                <?php } if( $trip_advisor_desc ){ ?>
                <div class="top-description">
                   <?php echo wpautop( wp_kses_post( $trip_advisor_desc ) ); ?>
                </div>
                <?php } ?>
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="content-panel">
                        <?php if ( is_active_sidebar( 'left-trip-advisor-widget' ) ) : ?>
                            <div class="left-panel">
                                <?php dynamic_sidebar( 'left-trip-advisor-widget' ); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( is_active_sidebar( 'right-trip-advisor-widgets' ) ) : ?>
                            <div class="right-panel">
                                <ul class="items">
                                    <?php dynamic_sidebar( 'right-trip-advisor-widgets' ); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php 
        }
    }
}
add_action( 'acethehimalaya_custom_tripadvisor_section', 'acethehimalaya_custom_tripadvisor_section');