<?php 

/*
Plugin Name: Plugin de l'ern 23
Description: Plugin de l'ern 23 qui sert à pas grand chose
Author: ERN23 Team
Version: 0.1
*/

// on import notre fichier Ern_Random_Photo_Widget.php
require_once plugin_dir_path(__FILE__) . "./widget/Ern_Random_Photo_Widget.php";

// on importe notre fichier Ern_Databse_Service.php
require_once plugin_dir_path(__FILE__) . "service/Ern_Database_Service.php";

//on importe notre fichier Ern_List.php
require_once plugin_dir_path(__FILE__) . "./Ern_List.php";

// creation de la classe du plugin 
class Ern {
    //appelle du constructor
    public function __construct() {
        //activation du plugin: creéation des tables à l'activation du plugin
        //__FILE__: constante magique qui contient le chemin du fichier dans lequel on se trouve
        register_activation_hook( __FILE__, array("Ern_Database_Service", "create_db"));

        //désactivation du plugin: vidange des table à la désactivation du plugin
        // register_deactivation_hook(__FILE__, array("Ern_Database_Service", "empty_db"));

        //désinstallation du plugin: suppression des tables à la désinstallation du plugin
        //ATTENTION LE PLUGIN SERA SUPRIME DU CODE SOURCE
        // register_uninstall_hook( __FILE__, array("Ern_Database_Service", "delete_db"));


        // on va enregistrer le widget
        add_action("widgets_init", function(){
            register_widget("Ern_Random_Photo_Widget");
        });

        //on va register le menu client
        add_action("admin_menu", array($this, "add_menu_client"));
    }

    //creation du menu dans le back office pour gérer les clients
    public function add_menu_client() 
    {
        //on a une méthode de WP qui permet de le faire
        //méthode attend 7 arguments
        add_menu_page(
            "Les clients de l'ERN 23", //titre de la page
            "Clients ERN", //titre du menu (titre de l'onglait)
            "manage_options", //capacité de l'utilisateur à voir le menu (ici droit admin)
            "ern-clients", //slug de la page (pour construir le url)
            array($this, "mesClients"), //callback qui va afficher la page($this cat on est dans la class Ern, mesClients () est une fonction de cette classe)
            "dashicons-groups", //icon de menu
            40 //position du menu
            //liste de position du menu 
            //https://developer.wordpress.org/reference/functions/add_menu_page/
        );

        //on va ajouter un sous menu pour ajouter un client
        // 1er arg: son menu parent (le slug du parent)
        //2 arg: titre de la page
        //3 arg: titre du menu
        // 4 arg: capacité de l'utisateur à voir le menu (ici droit admin)
        //5 arg: slug de la page (pour construire l'url)
        //6 arg: callaback qui va afficher la page
        add_submenu_page(
            "ern-clients", 
            "Ajouter un client",
            "Ajouter", 
            "manage_options",
            "ern-client-add", 
            array($this, "mesClients")
        );
    }

    //fonction d'affichage pour le menu
    public function mesClients()
    {
        //on va instancier la class Ern_Database_Service
        $db = new Ern_Database_Service();
        //on récupère le titre de la page
        echo "<h2>" . get_admin_page_title() . "</h2>";

        //si la page dans laquelle on est == ern-client (slug de la page) on affiche la liste
        if($_GET['page'] == "ern-clients" || $_POST["send"] == "ok" || $_POST["action"]=="delete-client") {
            //on va mettre une seconde condition 
            //si les données du formulaires sont présentes on execute la rquete
            if(isset($_POST['send']) && $_POST['send'] == 'ok') {
                //on execute la méthode save_client
                $db->save_client();
            }

            //de la même manieère que pour l'insertion 
            //on utilise le flag action pour savoir si on doit supprimer ou pas
            if(isset($_POST['action']) && $_POST['action'] == 'delete-client') {
            //on execute la méthode delete_client
                $db->delete_client($_POST['delete-client']);
            }

            //on instancie la classe Ern_List
            $table = new Ern_List();
            //on appelle la méthode prepare_items
            $table -> prepare_items();
            //on génère le rendu HTML de la table grace à la methode display
            //qu l'on imbrique dans un formulaire
            echo "<form method='post'>";
            $table->display();
            echo "</form>";

            //on commence à construire la table avec les titres des colonnes
            //__________________________________________CA VA ETRE REMPLACER ______________________//
            // echo "<table class='wp-list-table widefat fixed striped'>";
            // echo "<tr>";
            // echo "<th>Nom</th>";
            // echo "<th>Prenom</th>";
            // echo "<th>Email</th>";
            // echo "<th>Telephone</th>";
            // echo "<th>NoFidelite</th>";
            // echo "</tr>";
            // //on boucle dans le tableau de clients pour afficher les clients
            // foreach($db->findAll() as $client) {
            //     echo "<tr>";
            //     echo "<td>" . $client->nom . "</td>";
            //     echo "<td>" . $client->prenom . "</td>";
            //     echo "<td>" . $client->email . "</td>";
            //     echo "<td>" . $client->telephone . "</td>";
            //     echo "<td>" . (($client->fidelite == 0) ? "Client pas fidèle" : "Client fidele") . "</td>";
            //     //on ajoute un bouton pour supprimer le client
            //     echo "<td>";
            //     echo "<form method='post'>";
            //     echo "<input type='hidden' name='action' value='del'>";
            //     echo "<input type='hidden' name='id' value='" . $client->id ."'>";
            //     echo "<input type='submit' value='del' class='button'>";
            //     echo "</form>";
            //     echo "</td>";
            //     echo "</tr>";
            // }
            // //il faut penser à fermer la table
            // echo "</table>";
            //__________________________________________CA VA ETRE REMPLACER ______________________//


        } else { 
            //mon future formulaire
            echo "<form method='POST'>";
            //on va ajouter un input hidden pour envoyer "ok" lorsqu'on poste le formulaire
            //cvette valeur "ok" nous sert de flag pour faire du traitement dessus
            echo "<input type='hidden' name='send' value='ok'>";
            //input nom
            echo "<div>" .
                "<label for='nom'>Nom</label>" . 
                "<input type='text' name='nom' id='nom' class='widefat' required>" . 
                "</div>";
            //input prenom
            echo "<div>" .
                "<label for='prenom'>Prenom</label>" . 
                "<input type='text' name='prenom' id='prenom' class='widefat' required>" . 
                "</div>";
            //input email
            echo "<div>" .
                "<label for='email'>Email</label>" . 
                "<input type='text' name='email' id='email' class='widefat' required>" . 
                "</div>";
            //input telephone
            echo "<div>" .
                "<label for='telephone'>Telephone</label>" . 
                "<input type='text' name='telephone' id='telephone' class='widefat' required>" . 
                "</div>";
            //input fidelite
            echo "<div style='margin-top: 1rem; margin-bottom: 1rem;'>" .
                "<label for='fidelite'>Fidélité</label>" . 
                "<input type='radio' name='fidelite' class='widefat' value=0 checked>non" . 
                "<input type='radio' name='fidelite' class='widefat' value=1>oui" . 
                "</div>";
            //input submit 
            echo "<div>" .
                "<input type='submit' value='Ajouter' class='button button-primary'>" . 
                "</div>";
        }
    }
}

//on instancie la classe Ern
new Ern();


?>