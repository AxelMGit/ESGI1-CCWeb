<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <script src="main.js"></script>
    <title>To-Do List</title>
</head>
<body>

<h1>Ma To-Do List :)</h1>

<?php
// Définir le tache_titre du fichier CSV
$csvFile = 'data.csv';


function supprimerLignesCochees($fichier, $lignes) {
    $lignesASupprimer = array_flip($lignes); 
    $nouveauContenu = '';
    if (($handle = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (!isset($lignesASupprimer[$data[0]])) {
                $nouveauContenu .= implode(',', $data) . "\n";
            }
        }
        fclose($handle);
    }
    file_put_contents($fichier, $nouveauContenu);
}


if (isset($_POST['supprimer'])) {
    $lignesASupprimer = isset($_POST['lignes']) ? $_POST['lignes'] : [];
    if (!empty($lignesASupprimer)) {
        supprimerLignesCochees($csvFile, $lignesASupprimer);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['supprimer'])) {
    // Récupérer les données du formulaire
    $tache_titre = $_POST['tache_titre'];
    $tache_description = $_POST['tache_description'];
    $tache_deadline = date("d-m-Y", $_POST['tache_deadline']);
    $priority = isset($_POST['priority']) ? $_POST['priority'] : 'normal'; 

    $lignes = isset($_POST['lignes']) ? $_POST['lignes'] : [];

    // Créer une ligne CSV avec les données
    $nouvelleLigne = "$tache_titre, $tache_description, $tache_deadline, $priority\n";

    // Ajouter la nouvelle ligne au fichier CSV
    file_put_contents($csvFile, $nouvelleLigne, FILE_APPEND | LOCK_EX);
}



if (($handle = fopen($csvFile, "r")) !== FALSE) {
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "<table>";
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo "<tr";
        if ($data[3] == 'low') {
            echo " class='green-text'";
        }
        if ($data[3] == 'normal') {
            echo " class='black-text'";
        }
        if ($data[3] == 'high') {
            echo " class='red-text'";
        }
        echo ">";

        echo "<td><input id='checkbox_{$data[0]}' type='checkbox' name='lignes[]' value='{$data[0]}' onchange='toggleCheckboxColor(this)'></td>";

        echo "<td style='color:$data[3];text-decoration:$data[4]'>$data[0]</td>";


        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit' name='supprimer' value='Supprimer'>";
    echo "</form>";
    fclose($handle);

}

$maxDate = date('Y-m-d', strtotime('+5 years'));
$currentDate = date('Y-m-d');

?>


<h2>> Nouvelle tâche</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Titre de la tâche : <input type="text" name="tache_titre"><br>
    Description de la tâche : <input type="text" name="tache_description"><br>
    Deadline de la tâche : <input type="date" name="deadline_tache" value="<?php echo $currentDate; ?>" min="2024-05-15" max="<?php echo $maxDate; ?>" /><br>
    Priorité : <input type="radio" name="priority" value="green"/>Basse <input type="radio" name="priority" value="black" checked/>Normale <input type="radio" name="priority" value="red"/>Haute<br>


    <input type="submit" value="Envoyer">
</form>

</body>
</html>
