<!-- template pour afficher la liste des articles d'une categorie -->
<div>
    <h3>
        <a href="<?php the_permalink() ?>">
            <?php the_title() ?>
        </a>
    </h3>
    <!-- we use in the case of the posts -->
    <?php if('post' == get_post_type()) : ?>
    <!-- on check si c'est un post -->
    <div class="blog-postmeta">
        <p class="post-date">
            <?php echo get_the_date(); ?>
        </p>
    </div>
    <?php endif; ?>
    <div class="entry-summary">
        <?php the_excerpt() ?>
        <!-- on ajoute un bouton vpoir plus pour l'integralité du post -->
        <a href="<?php the_permalink() ?>"><?php esc_html_e("Lire plus &rarr;") ?></a>
    </div>
</div>