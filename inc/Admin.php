<?php

class Admin {

    public function get_avatar() {
        return false;
    }

    public function add_thumbnail_column($columns) {
        $columns['thumbnail'] = __('Image à la une', 'intranet');
        return $columns;
    }

    public function display_thumbnail_column($column, $post_id) {
        if ($column === 'thumbnail') {
            $thumbnail = get_the_post_thumbnail($post_id, array(160, 90));
            echo $thumbnail ? $thumbnail : __('No items.');
        }
    }

}
