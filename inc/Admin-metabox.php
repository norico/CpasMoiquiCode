<?php
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}

class AdminMetabox {

    public function remove_dashboard_metaboxes() {
        remove_meta_box('dashboard_primary', 'dashboard', 'side'); // Événements
        remove_meta_box('dashboard_secondary', 'dashboard', 'side'); // Nouveautés
    }
}
