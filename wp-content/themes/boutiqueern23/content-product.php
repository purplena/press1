<!-- ici le rendu de content-product.php -->
<?php 
// si woocommerce n'est pas activé, ne pas afficher le contenu de la pagge
// if(!defined('ABSPATH')) {
//     exit;
// }

defined('ABSPATH') || exit;

// the_title("<h2>", "</h2>");
// the_post_thumbnail("medium");
// the_content();

// on peut verifier que l'on est pas dans une page 
if(!is_singular('product')) {
    $stock = get_post_meta(get_the_ID(), '_stock_status', true);
    switch($stock) {
        case 'instock': 
            $label = 'En stock';
            $class='success';
            break;
        case 'outofstock': 
            $label = 'Rupture stock';
            $class='danger';
            break;
        case 'onbackorder': 
            $label = 'Sur commande';
            $class='warning';
            break;
        default:
            $label = 'Pas d\'info stock';
            $class='info';
    }
}

?>

<div class="card m-3" style="width: 18rem;">
    <a href="<?php the_permalink() ?>">
        <?php the_post_thumbnail('medium', ['class' => 'card-img-top img-fluid image_prod']) ?>
    </a>
    <div class="card-body">
        <h5 class="card-title">
            <?php the_title() ?>
        </h5>
        <div class="d-flex align-items-center ">
            <div class="card-text text-primary me-4">
                <?php echo wc_price(get_post_meta(get_the_ID(), '_price', true)); ?>
            </div>
            <span class="badge rounded-pill text-bg-<?php echo $class ?>">
                <?php echo $label ?>
            </span>
        </div>
        <!-- on va afficher le bouton "ajouter au panier" -->
        <div class="mt-3 d-flex align-items-center gap-5">
            <!-- on va afficher le bouton "ajouter au panier" -->
            <?php woocommerce_template_loop_add_to_cart() ?>
            <!-- option pour ajouter un nombre de produit -->
            <?php woocommerce_quantity_input() ?>
        </div>

    </div>
</div>