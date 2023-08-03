<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package StorePress
 */

get_header();
?>

<h1>Details de produits</h1>
<!-- verifier que l'on est bien dans un produit da la produit -->
<?php 
if(is_product()) {
    echo "Je suis dans un produit";
} else {
    echo "Je suis dans un article standard";
}
?>
<?php  
if (is_product()) {
    //affichage du titre du produit
    echo "<div class='product-block'>";
    echo "<h2>Titre:</h2>";
    the_title("<h1>", "</h1>");
    echo "</div>";

    //affichage de l'image du produit dans single-product.php
    echo "<div class='product-block'>";
    echo "<h2>Image:</h2>";
    echo "<img src='" . get_the_post_thumbnail_url(get_the_ID(), 'medium') . "' class='img-fluid image_desc' alt='" . get_the_title() . "'>";
    echo "</div>";

    //affichage du contenu du produit
    echo "<div class='product-block'>";
    echo "<h2>Description:</h2>";
    the_content();
    echo "</div>";

    //affichage description courte
    echo "<div class='product-block'>";
    echo "<h2>Description courte:</h2>";
    echo get_the_excerpt();
    echo "</div>";

    //affichage du prix du produit
    echo "<div class='product-block'>";
    echo "<h2>Prix:</h2>";
    echo wc_price(get_post_meta(get_the_ID(), '_price', true));
    echo "</div>";

    //si j'ai un prix réduit, je l'affiche et le prix initial est barré
    echo "<div class='product-block'>";
    if (get_post_meta(get_the_ID(), '_sale_price', true)) {
        echo "<h2>Prix réduit:</h2>";
        echo "<br>";
        echo "<del>" . wc_price(get_post_meta(get_the_ID(), '_regular_price', true)) . "</del>";
    }
    echo "</div>";

    //traitement du stock
    echo "<div class='product-block'>";
    echo "<h2>Stock:</h2>";
    $stock = get_post_meta(get_the_ID(), '_stock_status', true);
    switch ($stock) {
        case 'instock':
            $label = 'En stock';
            $class = "success";
            break;
        case 'outofstock':
            $label = 'Rupture de stock';
            $class = "danger";
            break;
        case 'onbackorder':
            $label = 'Sur commande';
            $class = "warning";
            break;
        default:
            $label = 'Pas d\'info stock';
            $class = "info";
    }
    //affichage du stock
    echo "<span class='badge rounded-pill bg-$class'>$label</span>";
    echo "</div>";

    //afficher ses catégories
    echo "<div class='product-block'>";
    echo "<h2>Catégories:</h2>";
    $categories = get_the_terms(get_the_ID(), 'product_cat');
    // Affichage des catégories si elles existent
    if ($categories) {
        echo "<ul>";
        foreach ($categories as $category) {
            echo "<li>" . $category->name . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune catégorie assignée.";
    }
    echo "</div>";

    //afficher ses tags s'il en a
    $tags = get_the_terms(get_the_ID(), 'product_tag');
    echo "<div class='product-block'>";
    echo "<h2>Tags:</h2>";
    // Affichage des tags si ils existent
    if ($tags) {
        echo "<ul>";
        foreach ($tags as $tag) {
            echo "<li>" . $tag->name . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun tag assigné.";
    }

    //affichage du bouton ajouter au panier
    //en utilisant woocommerce_template_loop_add_to_cart()
    //, si stock est épuiser on desactive le clique
    echo "<div class='product-block'>";
    echo "<h2>Ajouter au panier:</h2>";
    if ($stock == 'outofstock') {
        echo "<button class='btn btn-danger' disabled>Produit épuisé</button>";
    } else {
        //méthode direct qui redirige vers la page panier
        echo "<a href='" . get_permalink(get_option('woocommerce_cart_page_id')) .
            "?add-to-cart=" . get_the_ID() . "' class='btn btn-primary'>Ajouter et aller au panier</a>";
    }

    //ajouter formulaire pour laisser un avis
    //on utilise la fonction comments_template()
    echo "<div class='product-block'>";
    echo "<h2>Laisser un avis:</h2>";
    comments_template();
    echo "</div>";

    //affichage des avis
    echo "<div class='product-block'>";
    echo "<h2>Avis:</h2>";
    //on récupère les avis du produit
    $comments = get_comments(array(
        'post_id' => get_the_ID(),
        'status' => 'approve'
    ));
    //on affiche les avis
    if ($comments) {
        echo "<ul>";
        foreach ($comments as $comment) {
            echo "<li>";
            echo "<strong>" . $comment->comment_author . "</strong>";
            echo "<br>";
            echo $comment->comment_content;
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun avis pour ce produit.";
    }
    echo "</div>";

    //affichage des produits similaires
    echo "<div class='product-block'>";
    echo "<h2>Produits similaires:</h2>";
    //on récupère les produits similaires
    $related = wc_get_related_products(get_the_ID(), 4);
    //on affiche les produits similaires
    if ($related) {
        echo "<ul>";
        foreach ($related as $product) {
            echo "<li>";
            echo "<a href='" . get_permalink($product) . "'>";
            echo get_the_post_thumbnail($product, 'thumbnail');
            echo "</a>";
            echo "<br>";
            echo "<a href='" . get_permalink($product) . "'>";
            echo get_the_title($product);
            echo "</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun produit similaire.";
    }
    echo "</div>";


    //on récupère la note du produit
    $rating = get_post_meta(get_the_ID(), '_wc_average_rating', true);
    //on affiche la note
    if ($rating) {
        echo "<p>Note moyenne: $rating</p>";
    } else {
        echo "<p>Aucune note pour ce produit.</p>";
    }
}




get_footer(); ?>