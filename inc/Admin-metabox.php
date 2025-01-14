<?php

class AdminMetabox {

    public function remove_dashboard_metaboxes() {
        remove_meta_box('dashboard_primary', 'dashboard', 'side'); // Événements
    }
}
