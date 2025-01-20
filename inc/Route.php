<?php
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}
class Route {
    private $routes = [];

    public function __construct() {
        $this->init_routes();
    }


    public function init_routes() {
        $this->routes[] = [
            'method' => 'GET',
            'path' => '/post/{id}',
            'callback' => [$this, 'get_post_data'],
        ];
    }

    public function get_post_data(WP_REST_Request $request) {
        // Extract the post ID from the request
        $post_id = $request->get_param('id');

        // Log the post ID being fetched
        error_log('Fetching post with ID: ' . $post_id);

        // Fetch the post by ID
        $post = get_post($post_id);
        if (!$post) {
            error_log('Post not found for ID: ' . $post_id);
            return new WP_REST_Response(['error' => 'Post not found for ID: ' . $post_id], 404);
        }

        // Get the post data
        $title = get_the_title($post_id);
        $excerpt = get_the_excerpt($post_id);
        $permalink = get_permalink($post_id);

        // Get the post thumbnail and encode it in base64
        $thumbnail_id = get_post_thumbnail_id($post_id);
        $image = wp_get_attachment_image_src($thumbnail_id, 'full');
        $base64_image = '';
        if ($image) {
            $base64_image = base64_encode(file_get_contents($image[0]));
        }

        // Prepare the response data
        $response_data = [
            'title' => $title,
            'excerpt' => $excerpt,
            'permalink' => $permalink,
            'image' => $base64_image,
        ];

        // Log the response data
        error_log('Response data: ' . print_r($response_data, true));

        // Set the content type to application/json
        return new WP_REST_Response($response_data, 200);
    }
}

$route = new Route();

add_action('rest_api_init', function () use ($route) {
    register_rest_route('intranet/v1', '/post/(?P<id>\\d+)', [
        'methods' => 'GET',
        'callback' => [$route, 'get_post_data'],
    ]);
});
