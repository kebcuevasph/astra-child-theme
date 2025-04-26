<?php
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['parent-style'],
        wp_get_theme()->get('Version')
    );

    if (function_exists('learn_press_is_profile') && learn_press_is_profile()) {
        wp_enqueue_style(
            'learnpress-custom-style',
            get_stylesheet_directory_uri() . '/css/learnpress-custom.css',
            ['child-style'],
            '1.0'
        );
    }
});

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('dashicons');
});

add_filter('learn-press/profile-tabs', function ($tabs) {

    $tabs['my-apps'] = array(
        'title'    => '<span class="dashicons dashicons-grid-view" style="margin-right:5px;"></span>' . __('My Apps', 'astra-child-theme'),
        'slug'     => 'my-apps',
        'priority' => 1,
        'callback' => function() {
            echo '<div class="lp-profile-content"><h2>My Apps (Test)</h2><p>Content loaded directly!</p></div>';
        }
    );

    uasort($tabs, function($a, $b) {
        return ($a['priority'] ?? 100) <=> ($b['priority'] ?? 100);
    });

    return $tabs;
});

