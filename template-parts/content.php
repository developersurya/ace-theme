<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package acethehimalaya
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_single()) {
            if ('post' === get_post_type()) { ?>
                <div class="entry-meta">
                    Posted on <?php the_time('j F, Y') ?> by <?php the_author(); ?>
                    Category:
                    <?php the_category(', '); ?>
                </div><!-- .entry-meta -->
                <?php
            }
        } else{
            if ('post' === get_post_type()) { ?>
                <div class="entry-meta">
                    Posted by <?php the_author(); ?> <?php the_time('F j, Y') ?>
                    <?php the_time(); ?>
                    under
                    <?php the_category(', '); ?>
                </div><!-- .entry-meta -->
                <?php
            }
        }
        if (is_single()) {
            the_title('<h1 class="entry-title">', '</h1>');
        } else {
            the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
        }

        ?>
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php  if (is_home() || is_archive()) {
            if (has_post_thumbnail()) { ?>
                <figure><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a></figure>
                <?php
            }
        } else{
            ?>
            <figure><?php the_post_thumbnail('full'); ?></figure>
            <?php
        }
        if (is_home() || is_archive()) {
            echo wp_trim_words(get_the_content(), 40, '...');
            ?>
            <span class="learn-more"><a href="<?php the_permalink(); ?>">Read More</a></span>
            <?php
        }
        if (is_single()) {
            the_content();
        }
        ?>
    </div><!-- .entry-content -->
    <?php if(is_single()){ ?>
    <div class="social-share">
         <span st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'
               class='st_fblike_hcount'></span>
         <span st_via='@acethehimalaya' st_username='@acethehimalaya'
               st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'
               class='st_twitter_hcount'></span>
         <span st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'
               class='st_googleplus_hcount'></span>
    </div>
    <?php } ?>
    <!--<footer class="entry-footer">
		<?php /*acethehimalaya_entry_footer(); */ ?>
	</footer>--><!-- .entry-footer
<!-- #post-## -->

</article>
