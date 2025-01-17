<?php get_header(); ?>

<?php 
if (has_action('front_posts') && is_front_page() ) {
    echo '<section class="front-posts">';
    do_action('front_posts');
    echo '</section>';
}
?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <?php the_content(); ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>