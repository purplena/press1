<!-- On appelle notre header  -->
<?php get_header(); ?>

<!-- Partie reservé au main -->
<main>
    <div class="d-flex">
        <div class="col-sm-8 bloc-main bg-secondary">
            <?php 
            // si j'ai au moins un post, je boucle dessus pour récuperer chae post
            if(have_posts()) : while(have_posts()) : the_post();
                    get_template_part('content', 'single', get_post_format());   
                endwhile;
            endif;
            ?>
        </div>
        <!-- importer la sidebar -->
        <?php get_sidebar(); ?>
    </div>
</main>

<!-- On appelle notre footer  -->
<?php get_footer(); ?>