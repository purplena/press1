<!-- On appelle notre header  -->
<?php get_header(); ?>

<!-- Partie reservé au main -->
<main>
    <div class="page-header">
        <?php 
            // on affiche le titre de categorie
            the_archive_title("<h2 class='category_title'>", "</h2>");
            // on affiche la description de la catégorie
            the_archive_description("<em>", "</em>");
        ?>
    </div>


    <div class="d-flex">
        <div class="col-sm-8 bloc-main bg-secondary">
            <?php 
            // si j'ai au moins un post, je boucle dessus pour récuperer chae post
            if(have_posts()) : while(have_posts()) : the_post();
                // it is better to use like we wrote not "content-category"
                //if our file in the folder: "folder/content", "category"
                    get_template_part('content', 'category', get_post_format());   
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