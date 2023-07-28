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
        $output .= "<a class='nav-link' href='$permalink'>";
        $output .= $title;
        $output .= "</a>"; 
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        //on ferme la div
        $output .="</div>";
    }
}

?>