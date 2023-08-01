<div class="col-sm-3 offset-1 blog-sidebar bg-warning">
    <div class="sidebar-module sidebar-module-insert">
        <!-- is_single permet de savoir si on est dans le  détail d'un post -->
        <?php  if(is_single()): ?>
        <h5>a propos </h5>
        <!-- Ici on affiche la biorgaphie de l'auteur -->
        <p>
            <?php the_author_meta('description') ?>
        </p>
        <!-- On peut montrer tous les article de l'auteur -->
        <h5>article de l'auteur</h5>
        <ol class="list-unstyled">
            <!-- on doit interroger la BDD pour recuperer les posts de l'auteur -->
            <?php 
            $autor_post =  new WP_Query(array(
                //wp_query permet de construire une requete personalisé
                'author' => get_the_author_meta('ID')
                //va chercher tous les articles de même auteur
                //pourrait se traduire par
                // SELECT * FROM wp_posts WHERE post_author = id
            )); 
            while($autor_post->have_posts()): $autor_post->the_post();
            ?>
            <li>
                <!-- the_permalink() permet de récuperer le lien vers le post-->
                <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </li>
            <?php endwhile; ?>
        </ol>
        <?php  endif; ?>
        <h5>archives </h5>
        <!-- Ici on affiche les archives des posts  -->
        <p>
            <?php wp_get_archives('type=monthly') ?>
        </p>
        <?php 
        // affichage du widget dans le sidebar (le blade)
        if(is_active_sidebar('new-widget-area')) :?>
        <div id="secondary-sidebar" class="new-widget-area">
            <?php dynamic_sidebar("new-widget-area"); ?>
        </div>
        <?php endif; ?>
    </div>
</div>