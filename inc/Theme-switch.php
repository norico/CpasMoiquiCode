<?php 
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}

class ThemeSwitch {
    private int     $posts_per_page;
    private string  $language;
    private string  $timezone_string;
    private string  $time_format;
    private string  $date_format;

    public function __construct(
        int $posts_per_page,
        string $language,
        string $timezone_string,
        string $time_format,
        string $date_format
    ) {
        $this->posts_per_page   = $posts_per_page;
        $this->language         = $language;
        $this->timezone_string  = $timezone_string;
        $this->time_format      = $time_format;
        $this->date_format      = $date_format;
    }

    public function after_switch_theme() {
        // Configuration de la langue
        update_option('WPLANG', $this->language);
        
        // Configuration du format de date
        update_option('date_format', $this->date_format);
        update_option('time_format', $this->time_format);
        
        // Configuration du fuseau horaire
        update_option('timezone_string', $this->timezone_string);

        // Configuration du nombre de posts par page
        update_option('posts_per_page', $this->posts_per_page);

        // Vérifier et configurer la page d'accueil
        $homepage = get_page_by_path('homepage');
        if (!$homepage) {
            // Créer la page d'accueil si elle n'existe pas
            $homepage_id = wp_insert_post(array(
                'post_title'    => 'Homepage',
                'post_content'  => 'Contenu de la page d\'accueil',
                'post_status'   => 'publish',
                'post_type'     => 'page',
            ));
        } else {
            $homepage_id = $homepage->ID;
        }
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage_id);

        // Vérifier et configurer la page de blog
        $blog_page = get_page_by_path('actualites');
        if (!$blog_page) {
            // Créer la page de blog si elle n'existe pas
            $blog_page_id = wp_insert_post(array(
                'post_title'    => 'Actualités',
                'post_content'  => 'Contenu de la page des actualités',
                'post_status'   => 'publish',
                'post_type'     => 'page',
            ));
        } else {
            $blog_page_id = $blog_page->ID;
        }
        update_option('page_for_posts', $blog_page_id);

        // Configuration des permaliens
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();
    }
}