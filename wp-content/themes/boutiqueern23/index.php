<?php get_header(); ?>

<section class="section-container">

    <?php 
    //affichage de la page d'accueill
    //si je suis dans la page d'accueil, je l'affiche
    if(is_page()) {
        //on affiche le contenu de la page d'accueil
        //si j'ai des posts ou pages à afficher
        if(have_posts()) {
            //je boucle dessus
            while(have_posts()) {
                //je récupère les données du post (ou de la page)
                the_post();
                //j'affiche le titre dans une balise h1
                the_title("<h1>", "</h1>");
                //j'affiche le contenu de la page
                the_content();
            }
        }
    } elseif(is_shop()) {
        //sinon si on est dans la boutique
        //je récupere le contenu
        wc_get_template_part("archive", "product");
    }
?>

</section>

<?php get_footer(); ?>