<?php
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}

class ThemeMeta {
    private string $language;

    public function __construct(string $language) {
        $this->language = $language;
    }

    public function meta_og() {
        global $post;
        if (is_single() || is_page() || is_home()) {
            // URL de la page
            printf('<meta property="og:url" content="%s"/>%s', get_permalink(), "\n");
            
            // Type de contenu
            $type = 'website';
            if (is_single()) {
                $type = 'article';
            } elseif (is_page()) {
                $type = 'page';
            }
            printf('<meta property="og:type" content="%s"/>%s', $type, "\n");
            
            // Titre
            $title = get_the_title();
            if ( is_home() && is_front_page() ) {
                $title = get_bloginfo('name');
            }
            printf('<meta property="og:title" content="%s"/>%s', esc_attr($title), "\n");
            
            // Description
            $description = '';
            if (has_excerpt($post->ID)) {
                $description = get_the_excerpt();
            } elseif (!empty($post->post_content)) {
                $description = wp_trim_words($post->post_content, 20);
            } else {
                $description = get_bloginfo('description');
            }
            printf('<meta property="og:description" content="%s"/>%s', esc_attr($description), "\n");
            
            // Image
            if (has_post_thumbnail($post->ID)) {
                $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
                printf('<meta property="og:image" content="%s"/>%s', esc_attr($img_src[0]), "\n");
            }
            
            // Nom du site
            printf('<meta property="og:site_name" content="%s"/>%s', get_bloginfo('name'), "\n");
            
            // Locale
            printf('<meta property="og:locale" content="%s"/>%s', $this->language, "\n");
        }
    }
}
