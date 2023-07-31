<?php 
// creation d'un menu de navigation
// 1. On enregistre le menu
// 2. On initialise le menu
// 3. On l'active et on configure dans le BO
// 4. On design le menu dans le thème


// 1. On enregistre le menu

use function FakerPress\register;

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
//add_action permet d'executer une fonction à un momet précis
//1er parametre: le hook 'init' qui permet d'executer la fonction au moment d'initialisation du thème
//2eme parametre: le nom de la fonction à executer
add_action('init', 'register_menu');




// 4. On design le menu dans le thème
class simple_menu extends Walker_Nav_Menu {
    //on va appeler et surcharger la méthode start_el()
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        // $output: ce qui va être affiché (template)
        //$data_object: servira à récupérer les infos du menu (titre, lien, etc...)
        // 1. on récupère les data du menu dans des variables
        $title = $data_object->title; //récupère les titre du menu
        $permalink = $data_object->url; //récupère les liens du menu

        //2. on construit le template
        $output .= "<div class='nav-item custom-nav-item'>";
        $output .= '<a class="nav-link" href="$permalink">';
        $output .= $title;
        $output .= "</a>"; 
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        //on ferme la div
        $output .="</div>";
    }
}

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

// shortcode
// 1er exemple : shortcode sans paramètres
function monShortCode() {
    // on retourne le shortcode que l'on souhaite afficher
    return "<div class='alert alert-success'>Mon super shortcode</div>";
}
// on ajoute le shortcode à notre thème
add_shortcode('monMonShort', 'monShortCode');



function monShortPromo($atts) {
    // on va déclarer une variable ici $a
    // on utilise la fonction WP 'shortcut_atts()' pour attribuer une valeur par défault à notre paramètre
    // OPTION
    // $a = shortcode_atts(array(
    //     'percent' => 10
    // ), $atts);
    $a = shortcode_atts(['percent' => 10], $atts);
    return "<div class='alert alert-success'>Promo de {$a['percent']} %</div>";
}

add_shortcode('promo', 'monShortPromo');


// WIDGET
// fonction pour enregistrer le widget
function register_custom_widget_area() {
    register_sidebar(
        array(
            'id' => 'new-widget-area',
            'name' => __('New Widget Area'),
            'description' => __('Widget area for the sidebar'),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
}
//initialisation du widget
add_action('widgets_init', 'register_custom_widget_area');
?>