<?php
$pid = $_POST['post_id'];
if (have_rows('detail_itinerary',$pid)):
    while (have_rows('detail_itinerary',$pid)):the_row();
        ?>

        <div class="itinerary--item">
            <h6><?php the_sub_field("heading"); ?></h6>

            <?php the_sub_field("description"); ?>
        </div>
        <?php
    endwhile;
endif; ?>