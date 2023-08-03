<?php 
//si woocomerce n'est pas activé, ne pas afficher le contenu de la page
if(!defined('ABSPATH')) {
    exit;
}

//on récupère le header
get_header();
?>

<!-- on affiche le contenu de la page -->
<div class="woocommerce-product-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(apply_filters('woocommerce_show_page_title', true)): ?>
                <h1 class="woocommerce-products-page-title">
                    <?php echo get_the_title(wc_get_page_id('shop')) ?>
                </h1>
                <?php endif; ?>
                <div class="d-flex flex-wrap">
                    <?php if(have_posts()) {
                    woocommerce_product_loop_start();
                    while(have_posts()) {
                        the_post();
                        //on affiche le rendu de la carte produit
                        ?>
                    <div class="product-container">
                        <?php wc_get_template_part('content', 'product'); ?>
                    </div>
                    <?php 
                    }
                    woocommerce_product_loop_end();
                } else {
                    //si j'ai pas de produit à afficher 
                    echo "<p>Aucun produit à aficher</p>";
                }
                /**
                * Hook: woocommerce_after_shop_loop.
                *
                * @hooked woocommerce_pagination - 10
                */
                do_action("woocommerce_after_shop_loop");
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>