<?php $pid = $_POST['post_id']; ?>
<div class="tab-equipment-content">
    <?php the_field("equipment_main_description", $pid); ?>

    <?php if (have_rows('equipments', $pid)):
        while (have_rows('equipments', $pid)):the_row();

            ?>

            <h4 class="section__heading"><?php the_sub_field("heading"); ?></h4>
            <?php the_sub_field("equipment_list"); ?>

        <?php endwhile;
    endif;
    if(get_field('equipment_extra_description', $pid)) {
    ?>
    <div class="equipment-extra-description"><?php the_field("equipment_extra_description",$pid) ?></div>
    <?php } ?>
</div>