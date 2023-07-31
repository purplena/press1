<!-- Nous avons accès ici aux valeur renvoyé par "the_post()" 
On a donc accès à out les champs de la table wp_posts
On peut donc afficher le titre, le contenu, la date, l'auteur, etc
-->
<a href="<?php the_permalink(); ?>">
    <h4 class="text-primary blog-post-title">
        <?php the_title() ?>
    </h4>
</a>
<p>
    <?php the_date() ?> par <a href="#"><?php the_author() ?></a>
</p>
<?php the_content() ?>