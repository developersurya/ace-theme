<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package acethehimalaya
 */

get_header(); ?>

    <div class="container">
        <div class="row">
            <div id="primary" class="content-area">
                <main id="main" class="site-main error-404 not-found" role="main">

                    <div class="col-md-8 col-md-offset-2">
                        <section>
                            <header class="page-header text-center">
                                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'acethehimalaya'); ?></h1>
                            </header><!-- .page-header -->

                            <div class="page-content text-center">
                                    <h3>Unfortunately, the page you’ve requested cannot be displayed. It appears that you’ve lost your way either through an outdated link or a typo on the page you were trying to reach.</h3>
                                    <p>Please feel free to <a href="<?php echo site_url(); ?>">return to the front page</a>.We are very sorry for any inconvenience.</p>
                                    <h3>WHAT ELSE CAN YOU DO?</h3>
                                    <p>Report this error using our <a href="<?php echo site_url(); ?>/contact-us/">contact form</a>. We’ll be very grateful.</p>

                            </div><!-- .page-content -->
                        </section><!-- .error-404 -->
                    </div>

                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
    </div>
<?php
get_footer();
