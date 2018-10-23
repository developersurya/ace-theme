<?php $pid = $_POST['post_id']; ?>
<?php if(get_field('faqs_tab_title','options')){ ?><h4 class="section__heading"><?php echo get_field('faqs_tab_title','options'); ?></h4> <?php } ?>
<div class="panel-group faq-accordion" id="accordion">
    <?php
    $count = 0;
    if (have_rows('faqs_list', $pid)):
        while (have_rows('faqs_list', $pid)):the_row();

            ?>
            <div class="panel">
                <div class="panel-heading">
                    <h6>
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse<?php echo $count; ?>">
                           <?php the_sub_field("question"); ?>
                        </a>
                    </h6>
                </div>
                <div id="collapse<?php echo $count; ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php the_sub_field("answer"); ?>
                    </div>
                </div>
            </div>
            <?php
            $count++;
        endwhile;
    endif;
    ?>

</div>