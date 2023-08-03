<footer class="footer">
    <div class='nav-item-colomn-left'>
        <h5><?php bloginfo('name') ?></h5>
        <p>Telephone: <span class="bold-span">06 11 76 59 55</span></p>
        <p>Email: <span class="bold-span"><?php bloginfo('admin_email') ?></span></p>
    </div>
    <?php 
    wp_nav_menu(array(
        "theme_location" => "menu-footer", //on indique le menu à afficher
        "container" => "nav", //on indique que le menu sera dans une balise nav
        "container_class" => "navbar navbar-flex-column", //on ajoute desclass bootstrap 
        "menu_class" => "navbar-nav me-auto", //on ajoute des classe bootstrap
        "menu_id" => "menu-footer", //on ajoute un id
        "walker" => new simple_menu() //recuperation de notre template du menu
        )) 
?>
</footer>
</body>
</html>