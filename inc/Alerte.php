<?php
if (!defined('ABSPATH')) {
    exit; // Sortie si le fichier est accédé directement
}

class Alerte {
    public function __construct() {
    }

    public function ajouter_menu_alerte() {
        add_menu_page(
            'Alerte',
            'Message d\'alerte',
            'manage_options',
            'alerte',
            [$this, 'afficher_formulaire_alerte'],
            'dashicons-editor-textcolor',
            8
        );
    }

    public function afficher_formulaire_alerte() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Traitement du formulaire
        if (isset($_POST['alerte_texte'])) {
            update_option('texte_alerte', sanitize_text_field($_POST['alerte_texte']));
        }

        $texte_alerte = stripslashes(get_option('texte_alerte', ''));
        ?>
        <div class="wrap">
            <h1>Alerte Front Office</h1>
            <form method="post">
                <textarea name="alerte_texte" rows="5" class="large-text"><?php echo esc_textarea($texte_alerte); ?></textarea><br>
                <input type="submit" value="Enregistrer" class="button button-primary">
            </form>
        </div>
        <?php
    }

    public function afficher_alerte() {
        $texte_alerte = stripslashes(get_option('texte_alerte', ''));
        if (!empty($texte_alerte)) {
            get_template_part('template-parts/alerte', null, ['texte' => $texte_alerte]);
        }
    }

}