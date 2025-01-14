<?php

class ThemeSetup {
    
    public function after_setup_theme() {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list'
        ));
        add_theme_support('post-formats', array(
            'video',
            'audio',
        ));
        add_theme_support('custom-logo', array(
            'height'               => 250,
            'width'                => 250,
            'flex-height'          => true,
            'flex-width'           => true,
            'unlink-homepage-logo' => true,
        ));

        add_theme_support('custom-menu');
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');

        // Désactiver l'éditeur de fichiers de thèmes
        define('DISALLOW_FILE_EDIT', true);
    }
}
