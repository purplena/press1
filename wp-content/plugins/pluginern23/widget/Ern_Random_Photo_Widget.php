<?php  
class Ern_Random_Photo_Widget extends WP_Widget 
{
    //on surcharge son constructeur
    public function __construct()
    {
        // on déclare une variable avec les options du widget
        $widget_ops = array(
            // on ajoute des options au widget
            // ajout d'une classe css
            "className" => "ern_random_photo",
            // ajout d'une description
            // on traduit le texte en anglais
            // pour éviter rafraichir la fenêntre du navigateur
            "description" => __('Show random image'),
            'customize_selective_refresh' => true 
        );

        // on surcharge le constructeur 
        parent::__construct(
            // on donne un nom au widget
            'photos',
            // on donne un titre au widget
            __("Random photo"),
            // on lui donne des options
            $widget_ops
        );
    }

    //creation du formulaire pour le back office
    public function form($instance) {
        // création d'un tableau de valeurs par défault
        // wp_parse_args() permet de fusionner les valeurs dans un tableaux
        $instance = wp_parse_args((array) $instance, array (
            "query" => "",
            "nbr" => "", 
            "cle" => ""
        ));
        ?>
<!-- Creation de nos inputs -->
<div>
    <label for="<?php echo $this->get_field_id('query') ?>">Mot de recherche</label>
    <input type="text" name="<?php echo $this->get_field_name('query') ?>"
        id="<?php echo $this->get_field_id('query') ?>" value="<?php echo esc_attr($instance['query']) ?>">
</div>
<div>
    <label for="<?php echo $this->get_field_id('nbr') ?>">Nombre de photos</label>
    <input type="text" name="<?php echo $this->get_field_name('nbr') ?>" id="<?php echo $this->get_field_id('nbr') ?>"
        value="<?php echo esc_attr($instance['nbr']) ?>">
</div>
<div>
    <label for="<?php echo $this->get_field_id('cle') ?>">CLÉ Unsplash</label>
    <input type="text" name="<?php echo $this->get_field_name('cle') ?>" id="<?php echo $this->get_field_id('cle') ?>"
        value="<?php echo esc_attr($instance['cle']) ?>">
</div>
<?php
        
    }
    // creaation de lafonction update pour modifier les valeurs
    // du formulaire et générer d'autre images
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['query'] = sanitize_text_field($new_instance['query']);
        $instance['nbr'] = sanitize_text_field($new_instance['nbr']);
        $instance['cle'] = sanitize_text_field($new_instance['cle']);

        return $instance;
    }

    // création de la fonction widget pour afficher les images
    public function widget($args, $instance) {
        // on définit le titre
        $title = "Photos";
        // nombre de photo minimum
        ($instance['nbr'] != 0) ? $nbr = $instance['nbr'] : $nbr = 1; 
        //construction de l'url de l'API unsplash
        $url = "https://api.unsplash.com/search/photos?query=". $instance['query'] . "&per_page" . $nbr;
        // configure des headers pour autoriser la consommation de l'API
        $argCle = [
            'headers' => [
                'Authorization' => 'Client-ID ' . $instance['cle']
            ]
        ];

        // on fait l'appel à l'API à wp_remote_get
        $request = wp_remote_get($url, $argCle);

        // gestion d'erreur de retours
        if(is_wp_error($request)) {
            return false;
        }

        // si ok, on récupère le body de la réponse
        $body = wp_remote_retrieve_body($request);
        $data = json_decode($body, true);
        // var_dump($data);

        // construction du rendu html pour afficher les images
        echo $args['before_widget']; 

        // on affiche le titre
        echo $args ['before_title'] . $title . $args['after_title'];
        echo "<div class='photo'>";
        if(!empty($data)) {
            for($i=0; $i<$nbr; $i++) {
                echo "<p>" . $data['results'][$i]['id'] . "</p>";
                echo "<img src='" . $data['results'][$i]['urls']['thumb'] . "' alt='". $data['results']['$i']['description'] ."' />";
            }
        }
        echo "</div>";
        echo $args['after_widget'];
        
        return '';
    }
}


?>