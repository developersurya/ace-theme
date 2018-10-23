<?php $pid = $_POST['post_id']; ?>
<div class="tab-gallery-wrap">
    <ul class="nav nav-tabs">
        <?php
        if(get_field("trip_gallery", $pid)) {
        ?>
        <li class="active"><a href="#tab-photo" data-toggle="tab">Images</a></li>
        <?php
        }
        if (have_rows('videos_upload', $pid)) {
        ?>
        <li class="<?php if(!get_field("trip_gallery", $pid)) { echo 'active'; } ?>"><a href="#tab-video" data-toggle="tab">Videos</a></li>
        <?php } ?>
    </ul>
    <div class="row">
        <ul class="tab-content clearfix">
            <?php
            if(get_field("trip_gallery", $pid)) {
            ?>
            <li class="tab-pane active" id="tab-photo">
                <div class="gallery-image">
                    <?php $galleryid = get_field("trip_gallery", $pid); ?>
                    <?php echo do_shortcode('[nggallery id=' . $galleryid . ' template=caption]'); ?>
                </div>
            </li>
            <?php
            }
            if (have_rows('videos_upload', $pid)) {
            ?>
            <li class="tab-pane <?php if(!get_field("trip_gallery", $pid)) { echo 'active'; } ?>" id="tab-video">
                <?php
                //echo $pid;
                if (have_rows('videos_upload', $pid)):
                    while (have_rows('videos_upload', $pid)):the_row();
                        if (!empty(get_sub_field("upload_video"))) { ?>
                            <!--upload file -->
                            <div class="col-md-6 col-sm-6">
                                <div class="video-wrap">
                                    <?php echo do_shortcode('[video flv="' . get_sub_field("upload_video") . '"][/video]'); ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6">
                                <!--embed video-->
                                <div class="video-wrap">
                                    <?php echo get_sub_field("video_embed"); ?>
                                </div>
                            </div>
                        <?php }
                    endwhile;
                endif;
                ?>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>