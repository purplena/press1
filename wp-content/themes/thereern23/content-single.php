<h1 class="text-primary blog-post-title">
    <?php the_title() ?>
</h1>

<div class="mt-3">
    <?php the_date() ?> par <a href="#"><?php the_author() ?></a>
</div>

<div class="mt-3">
    <p>Categories: <?php the_category() ?></p>
</div>

<?php if(has_tag()) : ?>
<p>Tags: <?php the_tags() ?></p>
<?php endif; ?>

<div class="mt-3">
    <?php the_content() ?>
</div>

<?php 
$author_id = get_the_author_meta('ID'); // Get the ID of the current author

$args = array(
    'post_type' => 'post',
    'author' => $author_id,
    'posts_per_page' => -1 // Retrieve all posts
);

$author_posts_query = new WP_Query($args);

if ($author_posts_query->have_posts()) {
    $author_posts_url = get_author_posts_url($author_id); // Get the URL to the author's posts page

    echo '<a href="' . esc_url($author_posts_url) . '">Decouvrez les autres article de ' . get_the_author() . '</a>';

    // Rest of the code to display the author's name, bio, etc.

    while ($author_posts_query->have_posts()) {
        $author_posts_query->the_post();
        get_template_part('content', 'author', get_post_format());
        // Display the post content or perform any other operations
    }
}
?>



<!-- <p>Decouvrez les autres article de <a href="<?php the_permalink() ?>"><?php the_author() ?></a></p> -->