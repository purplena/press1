<?php 
// class qui nous permet d'ajouter nos propres tables à nous dans la base de données
class Ern_Database_Service 
{
    public function __construct()
    {
        // pour instant rien dedans
    }

    // fonctio, qui va créer une nouvelle table dans le DB
    public static function create_db() 
    {
        //on appelle la variable globale de connection à la base de donnée $wpdb
        // $wpdb est une analogue de dlovbal $mysqli ou $connection
        global $wpdb;
        // creation de la table en BDD
        $wpdb->query("
        CREATE TABLE IF NOT EXISTS {$wpdb->prefix}ern_client (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(150) NOT NULL,
        prenom VARCHAR(150) NOT NULL,
        email VARCHAR(150) NOT NULL,
        telephone VARCHAR(50) NOT NULL,
        fidelite BOOLEAN DEFAULT false
        )
        ");

        //on regarde si la table contient des lignes(rows)
        $count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ern_client");

        // si la table est vide je vais lui inserer des valeurs daf défaut
        if($count==0) {
            $wpdb->insert("{$wpdb->prefix}ern_client", [
                "nom" => "Doe",
                "prenom" => "John",
                "email" => "john.doe@example.com",
                "telephone" => "0611251328",
                "fidelite" => true
            ]);
        };
    }
    //fonction qui vide la table lors de la désactivation du plugin
    //A NE PAS FAIRE EN CAS REEL
    // public static function empty_db() {
    //     global $wpdb; 
    //     $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}ern_client");
    // }

    // fonction qui suprime la table lors de la désinstallation du plugin
    // public static function delete_db() {
    //     global $wpdb;
    //     $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ern_client");
    // } 

    //fonction qui va récupérer tous les clients
    public function findAll() {
        global $wpdb;
        $res = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ern_client");

        return $res;
    }

    //function pour enregistrer un client
    public function save_client() {
        global $wpdb; 
        //dans une variable on ve récuperer les données du formulaire
        $data = [
            "nom" => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email" => $_POST["email"],
            "telephone" => $_POST["telephone"],
            "fidelite" => $_POST["fidelite"]
        ];

        //on vérifie que le client n'existe pas déjà
        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}ern_client WHERE email = '" . $data["email"] . "'");
        if(is_null($row)) {
            //si le client n'existe pas on l'insère dans la table
            $wpdb->insert("{$wpdb->prefix}ern_client", $data);
        } else {
            //TODO: faire un message d'erreur
        }
    }

    //fonction qui suprime un ou plusieurs clients
    //$ids est un tableau de plusieurs id
    public function delete_client($ids) 
    {
        global $wpdb; 
        //on check si $ids est dans un tableau sinon on le met dans un tableau
        //pour avoir la possibilité de supprimer plusieurs clients
        if(!is_array($ids)) {
            $ids = [$ids]; 
        }
        //effectuer la requete de suppression
        $wpdb->query("DELETE FROM {$wpdb->prefix}ern_client WHERE id IN (" . implode(",", $ids) . ")");
    }

}




?>