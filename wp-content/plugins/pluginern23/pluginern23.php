<?php 

/*
Plugin Name: Plugin de l'ern 23
Description: Plugin de l'ern 23 qui sert à pas grand chose
Author: ERN23 Team
Version: 0.1
*/

// on import notre fichier Ern_Random_Photo_Widget.php
require_once plugin_dir_path(__FILE__) . "./widget/Ern_Random_Photo_Widget.php";

// creation de la classe du plugin 
class Ern {
    //appelle du constructor
    public function __construct() {
        // on va enregistrer le widget
        add_action("widgets_init", function(){
            register_widget("Ern_Random_Photo_Widget");
        });
    }
}

//on instancie la classe Ern
new Ern();


?>