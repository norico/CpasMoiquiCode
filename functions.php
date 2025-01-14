<?php 
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}

require_once get_template_directory() . '/inc/Loader.php';
require_once get_template_directory() . '/inc/Theme-setup.php';
require_once get_template_directory() . '/inc/Theme-switch.php';
require_once get_template_directory() . '/inc/Theme-meta.php';
require_once get_template_directory() . '/inc/Admin.php';
require_once get_template_directory() . '/inc/Admin-trace.php';
require_once get_template_directory() . '/inc/Admin-metabox.php';
require_once get_template_directory() . '/inc/Login.php';

class Theme {

    private int     $posts_per_page     = 12;
    private string  $language           = "fr_FR";
    private string  $timezone_string    = "Europe/Paris";
    private string  $time_format        = "G\hi";
    private string  $date_format        = "j F Y";
    private string  $theme_name;
    private string  $theme_slug;
    private string  $theme_version;


    private ThemeSetup $theme_setup;
    private ThemeSwitch $theme_switch;
    private ThemeMeta $theme_meta;
    private Login $login;

    private Admin $admin;
    private AdminTrace $admin_trace;
    private AdminMetabox $admin_metabox;

    private $menus = array(
        'primary'   => 'Menu Principal',
        'footer'    => 'Menu Footer',
    );

    private $loader;

    public function __construct() {
        $theme = wp_get_theme();
        $this->theme_name       = $theme->get('Name');
        $this->theme_slug       = $theme->get('TextDomain');
        $this->theme_version    = $theme->get('Version');
        
        $this->admin            = new Admin();
        $this->admin_trace      = new AdminTrace();
        $this->admin_metabox    = new AdminMetabox();

        $this->theme_setup      = new ThemeSetup();
        $this->theme_meta       = new ThemeMeta($this->language);
        $this->theme_switch     = new ThemeSwitch(
            $this->posts_per_page,
            $this->language,
            $this->timezone_string,
            $this->time_format,
            $this->date_format
        );
        $this->admin_trace      = new AdminTrace();
        $this->loader           = new Loader();
        $this->login            = new Login();
        $this->setup();
    }

    public function run() {
        $this->loader->run();
    }

    public function get_theme_name(): string {
        return $this->theme_name;
    }
    
    public function get_theme_version(): string {
        return $this->theme_version;
    }

    private function setup() {
        $this->loader->add_action('after_setup_theme', $this->theme_setup, 'after_setup_theme');
        $this->loader->add_action('after_switch_theme', $this->theme_switch, 'after_switch_theme');
        $this->loader->add_action('init', $this, 'init');
        $this->loader->add_action('wp_head', $this, 'wp_head');
        

        // Ajouter le filtre pour retirer le sélecteur de langues
        $this->loader->add_filter('login_display_language_dropdown', $this->login, 'login_display_language_dropdown');
        
        // Masque les gravatars
        $this->loader->add_filter('get_avatar', $this->admin, 'get_avatar', 10, 5);

        $this->loader->add_action('wp_dashboard_setup', $this->admin_metabox, 'remove_dashboard_metaboxes');

        // Ajouter le filtre et l'action pour afficher l'image à la une
        $this->loader->add_filter('manage_posts_columns', $this->admin, 'add_thumbnail_column');
        $this->loader->add_action('manage_posts_custom_column', $this->admin, 'display_thumbnail_column', 10, 2);
        
        // Actions et filtres pour AdminTrace
        $this->loader->add_action('wp_login', $this->admin_trace, 'update_last_login', 10, 2);
        $this->loader->add_filter('manage_users_columns', $this->admin_trace, 'add_last_login_column');
        $this->loader->add_filter('manage_users_custom_column', $this->admin_trace, 'show_last_login_column', 10, 3);
        $this->loader->add_filter('manage_users_sortable_columns', $this->admin_trace, 'make_last_login_sortable');
        $this->loader->add_action('pre_get_users', $this->admin_trace, 'sort_by_last_login');
    }



    public function init() {
        register_nav_menus($this->menus);
    }

    public function wp_head() {
        $this->theme_meta->meta_og();
    }
}

// Initialisation
if (class_exists('Theme')) {
    $theme = new Theme();
    if ($theme) {
        $theme->run();
    } else {
        wp_die('Impossible d\'instancier la classe Theme. Veuillez vérifier votre installation.');
    }
} else {
    wp_die('La classe Theme n\'existe pas. Veuillez vérifier votre installation.');
}
