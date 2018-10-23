<?php
function acethehimalaya_homepage($wp_customize)
{

    /** Option list of all pages */ 
    $options_pages = array();
    $options_pages_obj = get_posts('posts_per_page=-1&post_type=page');
    $options_pages[''] = __( 'Choose Page', 'bakes-and-cakes' );
    foreach ( $options_pages_obj as $bac_pages ) {
        $options_pages[$bac_pages->ID] = $bac_pages->post_title; 
    }


    $wp_customize->add_panel(
        'home_page',
        array(
            'title' => __('Home Page Settings', 'acethehimalaya'),
            'priority' => 60,
                    )
    );

    /**info */
    $wp_customize->add_section(
        'info_section',
        array(
            'title'       => __('Info Section', 'acethehimalaya'),
            'description' => __('Select page to show the info', 'acethehimalaya'),
            'priority'    => 10,
            'capability'  => 'edit_theme_options',
            'panel'       => 'home_page',
        )
    );

    /** Enable/Disable info section */
    $wp_customize->add_setting(
        'ed_info_section',
        array(
            'default'           => '',
            'sanitize_callback' => 'acethehimalaya_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        'ed_info_section',
        array(
            'label'     => __('Enable/Disable Info section', 'acethehimalaya'),
            'section'   => 'info_section',
            'type'      => 'checkbox',
        )
    );


    /** Info select Page */
    $wp_customize->add_setting(
        'info_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'acethehimalaya_sanitize_select',
        )
    );

    $wp_customize->add_control(
        'info_text',
        array(
            'label'     => __('Select Page', 'acethehimalaya'),
            'section'   => 'info_section',
            'type'      => 'select',
            'choices'   => $options_pages,
        )
    );

    /** Info Read More Text */
    $wp_customize->add_setting(
        'info_readmore_text',
        array(
            'default'           => 'Read More',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'info_readmore_text',
        array(
            'label'     => __('Read More Text', 'acethehimalaya'),
            'section'   => 'info_section',
            'type'      => 'Text',
        )
    );

    /** youtube link */
    $wp_customize->add_setting(
        'info_youtube_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'acethehimalaya_sanitize_iframe',
        )
    );

    $wp_customize->add_control(
        'info_youtube_link',
        array(
            'label'     => __('Enter the youtube link', 'acethehimalaya'),
            'section'   => 'info_section',
            'type'      => 'text',
        )
    );

    /**Trip advisor section*/
    $wp_customize->add_section(
        'trip_advisor_section',
        array(
            'title'       => __('Trip Advisor Section', 'acethehimalaya'),
            'description' => __('Select page to show the title for trip advisor', 'acethehimalaya'),
            'priority'    => 20,
            'capability'  => 'edit_theme_options',
            'panel'       => 'home_page',
        )
    );

    /** Enable/Disable trip section */
    $wp_customize->add_setting(
        'ed_trip_advisor_section',
        array(
            'default'           => '',
            'sanitize_callback' => 'acethehimalaya_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        'ed_trip_advisor_section',
        array(
            'label'     => __('Enable/Disable Trip Advisor section', 'acethehimalaya'),
            'section'   => 'trip_advisor_section',
            'type'      => 'checkbox',
        )
    );
    
    /** Info Read More Text */
    $wp_customize->add_setting(
        'trip_advisor_title_section',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'trip_advisor_title_section',
        array(
            'label'     => __('Title', 'acethehimalaya'),
            'section'   => 'trip_advisor_section',
            'type'      => 'Text',
        )
    );
    /** Info Read More Text */
    $wp_customize->add_setting(
        'trip_advisor_desc_section',
        array(
            'default'           => 'Read More',
            'sanitize_callback' => 'wp_kses_post',
        )
    );

    $wp_customize->add_control(
        'trip_advisor_desc_section',
        array(
            'label'     => __('Description', 'acethehimalaya'),
            'section'   => 'trip_advisor_section',
            'type'      => 'textarea',
        )
    );

     /**info */
    $wp_customize->add_section(
        'left_widget_section',
        array(
            'title'       => __('Widget section to the left section', 'acethehimalaya'),
            'description' => __('Select widgets to show the info', 'acethehimalaya'),
            'priority'    => 30,
            'capability'  => 'edit_theme_options',
            'panel'       => 'home_page',
        )
    );

    


}
add_action('customize_register', 'acethehimalaya_homepage');

function acethehimalaya_sanitize_checkbox($checked){
    // Boolean check.
    return ((isset($checked) && true == $checked) ? true : false);
}
function acethehimalaya_sanitize_select($input, $setting){
    // Ensure input is a slug.
    $input = sanitize_key($input);

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control($setting->id)->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}
/*** Escape iframe */
function acethehimalaya_sanitize_iframe( $iframe ){
    $allow_tag = array(
        'iframe' =>array(
            'src' => array()
        ) );
return wp_kses( $iframe, $allow_tag );
}
