<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . "/style.css"; ?>">
    <title><?php bloginfo('name'); ?></title>
</head>
<body>
    <header class="bg-success text-white p-3 site-header" style="background-image: url(<?php header_image() ?>)">
        <a class="text-light" href="<?php echo get_bloginfo(('wpurl'))?>">
            <h2><?php echo get_bloginfo('name'); ?></h2>
        </a>
        <em class="blog-description"><?php echo get_bloginfo('description'); ?></em>
        <?php 
        wp_nav_menu(array(
            "theme_location" => "menu-sup", //on indique le menu à afficher
            "menu_class" => "custom-menu", //ajout de la class pour pour le css
            "container" =>false, 
            "walker" => new depth_menu() //récuperation de notre template 
        ));
        ?>
    </header>