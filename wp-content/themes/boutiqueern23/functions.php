<?php 
// creation d'un menu de navigation
// 1. On enregistre le menu

function register_menu() {
    // fonction native de WordPress qui permet d'enregister un menu
    register_nav_menus(
        array(
            //__() permet de traduire le mot dans les differents language
            'menu-sup' => __('Main menu'),
            'menu-footer'  => __('Menu footer')
        )
    ); 
}

// 2. On initialise le menu
add_action('init', 'register_menu');

//on design un menu qui gère les sous-menus
class depth_menu extends Walker_Nav_Menu {
    //fonction pour démarrer le niveau de menu
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= "<ul class = 'sub-menu'>"; //on ouvre une ul
    }

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        //on récupère les titres
        $title = $data_object->title;
        //on récupère les liens
        $permalink = $data_object->url;
        // on gère l'indentation des liens
        //signification de "\t" (hex 09) = tabulation
        // $indentation = str_repeat("\t", $depth);
        //les classes css à ajouter
        $classes = empty($data_object->classes) ? array() : (array) $data_object->classes;
        $class_name = join(' ', apply_filters('nav_menu_css_array', array_filter($classes), $data_object));

        if($depth > 0) {
            // $output .= $indentation . '<li class="' . esc_attr($class_name) . '">';
            $output .= '<li class="' . esc_attr($class_name) . '">';
        } else {
            $output .= '<li class="' . esc_attr($class_name) . '">';
        }
        $output .= '<a href="' . $permalink . '">' . $title . '</a>';
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        // on ferme li
        $output .= "</li>";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        // on ferme ma ul 
        $output .= "</ul>"; 
    }
}

class simple_menu extends Walker_Nav_Menu {
    //on va appeler et surcharger la méthode start_el()
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        $title = $data_object->title; //récupère les titre du menu
        $permalink = $data_object->url; //récupère les liens du menu

        //2. on construit le template
        $output .= "<div class='nav-item custom-nav-item'>";
        $output .= "<a class='nav-link-footer' href='$permalink'>";
        $output .= $title;
        $output .= "</a>"; 
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        //on ferme la div
        $output .="</div>";
    }
}

//ajout de la fonctionnalité 'logo' pour changer l'image du header
function custom_header_logo() {
    $args = [
        "default-image" => get_template_directory_uri() . "/img/banner.png",
        "default-text-color" => "000",
        "width" => 1000,
        "height" =>250, 
        "flex-width" => true,
        "flex-height" => true
    ];

    //add_theme_support: 1er argument le nom de la fonctionnalité
    //2eme arg le taleau de paramètres
    add_theme_support("custom-header", $args);
}
//add_action: 1er arg le hook, 2arg le nom de fonctionalite
add_action("after_setup_theme","custom_header_logo" );