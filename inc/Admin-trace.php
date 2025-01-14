<?php
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}

class AdminTrace {
    private string $meta_key = 'last_login';

    public function __construct() {
    }

    public function update_last_login($user_login, $user) {
        update_user_meta($user->ID, $this->meta_key, current_time('mysql'));
    }

    public function add_last_login_column($columns) {
        $columns[$this->meta_key] = __('Last Login', 'intranet');
        return $columns;
    }

    public function show_last_login_column($value, $column_name, $user_id) {
        if ($column_name === $this->meta_key) {
            $last_login = get_user_meta($user_id, $this->meta_key, true);
            if (!empty($last_login)) {
                return mysql2date(get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $last_login);
            }
            return __('Never logged in.', 'intranet');
        }
        return $value;
    }

    public function make_last_login_sortable($columns) {
        $columns[$this->meta_key] = $this->meta_key;
        return $columns;
    }

    public function sort_by_last_login($query) {
        if (!is_admin()) {
            return;
        }

        $orderby = $query->get('orderby');
        if ($orderby === $this->meta_key) {
            $query->set('meta_key', $this->meta_key);
            $query->set('orderby', 'meta_value');
        }
    }
}
