<?php
// traitement.php - Script d'envoi du formulaire

// Configuration
$destinataire = "bmautomobilescarrosserie@gmail.com"; // Remplacez par votre email
$sujet = "Nouvelle demande de devis - BM Automobiles";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données
    $nom = htmlspecialchars($_POST['nom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $modele = htmlspecialchars($_POST['modele']);
    $immatriculation = htmlspecialchars($_POST['immatriculation']);
    $prestation = htmlspecialchars($_POST['prestation']);
    $message = htmlspecialchars($_POST['message']);
    
    // Construction du message
    $contenu = "NOUVELLE DEMANDE DE DEVIS - BM AUTOMOBILES\n";
    $contenu .= "===========================================\n\n";
    $contenu .= "INFORMATIONS CLIENT :\n";
    $contenu .= "-------------------\n";
    $contenu .= "Nom : $nom\n";
    $contenu .= "Téléphone : $telephone\n";
    $contenu .= "Modèle véhicule : $modele\n";
    $contenu .= "Immatriculation : $immatriculation\n";
    $contenu .= "Prestation souhaitée : $prestation\n";
    $contenu .= "Message : $message\n\n";
    $contenu .= "Date : " . date("d/m/Y à H:i") . "\n";
    $contenu .= "IP : " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    // En-têtes de l'email
    $headers = "From: webmaster@bmautomobiles-nantes.fr\r\n";
    $headers .= "Reply-To: $destinataire\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Gestion des fichiers joints (photos)
    $fichiers_joints = "";
    if (!empty($_FILES['photos']['name'][0])) {
        $fichiers_joints = "\n\nPHOTOS JOINTES :\n";
        $fichiers_joints .= "----------------\n";
        
        $total = count($_FILES['photos']['name']);
        for ($i = 0; $i < $total; $i++) {
            $fichiers_joints .= "- " . $_FILES['photos']['name'][$i] . " (" . 
                round($_FILES['photos']['size'][$i] / 1024, 2) . " Ko)\n";
        }
        $fichiers_joints .= "\nLes fichiers sont disponibles sur le serveur.";
    }
    
    $contenu .= $fichiers_joints;
    
    // Envoi de l'email
    if (mail($destinataire, $sujet, $contenu, $headers)) {
        // Redirection vers une page de confirmation
        header('Location: merci.html');
        exit();
    } else {
        echo "<script>
                alert('Une erreur est survenue lors de l\\'envoi du formulaire.');
                window.history.back();
              </script>";
    }
} else {
    // Si quelqu'un tente d'accéder directement au fichier
    header('Location: index.html');
    exit();
}
?>