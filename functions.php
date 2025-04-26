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

add_filter('learn-press/profile-tabs', function ($tabs) {

    // 1. Add your custom tab
    $tabs['my-apps'] = array(
        'title'    => __('My Apps', 'astra-child-theme'),
        'slug'     => 'my-apps',
        'icon'     => 'dashicons-grid-view',
        'priority' => 1, // Very low = appears first
        'callback' => function() {
            learn_press_get_template('profile/tabs/my-apps.php');
        }
    );

    // 2. Reorder tabs by priority (lower priority first)
    uasort($tabs, function($a, $b) {
        return ($a['priority'] ?? 100) <=> ($b['priority'] ?? 100);
    });

    // 3. Return the sorted tabs
    return $tabs;
});

