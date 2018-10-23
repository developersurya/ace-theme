<?php
/**
* Template Name: Direct Payment Form
*/
get_header();
?>
<?php
if (has_post_thumbnail()) {
	$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image-mobile');
	$image_medium = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image-tab');
	$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image');
?>
<figure
	class="hero-image style1">
	<picture>
		<!--[if IE 9]>
		<video style="display: none;"><![endif]-->
			<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1200px)">
			<source srcset="<?php echo $image_medium[0]; ?>"
			media="(min-width: 768px)">
			<source srcset="<?php echo $image_thumb[0]; ?>"
			media="(min-width: 320px)">
			<!--[if IE 9]></video><![endif]-->
			<img srcset="<?php echo $image[0]; ?>"
			alt="<?php the_title();?>">
		</picture>
	</figure>
	<?php }?>
	<div class="container">
		<div class="row  contact-us">
			<div class="col-lg-12">
				<?php
				if (have_posts()) {
					while (have_posts()) {
						the_post();
				?>
				<div class="header-block centered-form">
					<h1 class="page-heading"><?php the_title(); ?></h1>
					<?php
						the_content();
					?>
					<br/>
					<?php echo do_shortcode('[gravityform id=16 title=false description=false ajax=false tabindex=49]');?>
				</div>
				<?php
					} // end while
				} // end if
				?>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$('#gform_submit_button_16').val('PAY BY CARD');
		});
	</script>

	<?php get_footer();?>