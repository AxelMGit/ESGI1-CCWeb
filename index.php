<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_style.php" media="screen">
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

    header("Location: {$_SERVER['PHP_SELF']}?success=true");
    exit();
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
    $tache_deadline = $_POST['annee'] . "-" . $_POST['mois'] . "-" . $_POST['jour'];
    $priority = isset($_POST['priority']) ? $_POST['priority'] : 'normal'; 

    $lignes = isset($_POST['lignes']) ? $_POST['lignes'] : [];

    // Créer une ligne CSV avec les données
    $nouvelleLigne = "$tache_titre,$tache_description,$tache_deadline,$priority\n";

    // Ajouter la nouvelle ligne au fichier CSV
    file_put_contents($csvFile, $nouvelleLigne, FILE_APPEND | LOCK_EX);

    header("Location: {$_SERVER['PHP_SELF']}?success=true");
    exit();
}



if (($handle = fopen($csvFile, "r")) !== FALSE) {
    $maxDate = date('Y-m-d', strtotime('+5 years'));
    $currentDate = date('Y-m-d');

    echo "<div class='data_div'>";
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "<table>";
    echo strtotime($data[2]);
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        $status = "";

        if (strtotime($data[2]) < strtotime($currentDate)) {
            $status = ' - En retard';
        } else {
            $status = '';
        }
        /*    
        echo "<tr>";
        echo "<td><input id='checkbox_{$data[0]}' type='checkbox' name='lignes[]' value='{$data[0]}' onchange='toggleCheckboxColor(this)'></td>";
        echo "<td class='title' style='color:$data[3];text-decoration:$data[4]'>$data[0]</td>";
        echo "<td style='color:red;'>$status</td>"; 
        echo "</tr>";
        
        echo "<tr class='desc-row'>";
        echo "<td colspan='2' class='hidden_desc'>$data[1]</td>";
        echo "</tr>";*/

        echo "<tr>";
            echo "<td><input id='checkbox_{$data[0]}' type='checkbox' name='lignes[]' value='{$data[0]}' onchange='toggleCheckboxColor(this)'></td>";
            echo "<td class='title-cell' style='color:$data[3];text-decoration:$data[4]'> $data[0]";
                echo "<div class='hidden_desc'>$data[1]</div>";
            echo "</td>";
            
        echo "</tr>";



       
        
        echo "</div>";
    }
    echo "</table>";
    echo "<input id='button' type='submit' name='supprimer' value='Supprimer'>";
    echo "</form>";
    fclose($handle);

}

$mois = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre']   ;

function genererMois($elements) {
    $options = '';
    foreach ($elements as $valeur => $texte) {
        $options .= "<option value='$valeur'>$texte</option>";
    }
    return $options;
}

?>

<div class="new_task">
    <hr>

    <h2>> Nouvelle tâche</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <label for="tache_titre">Titre </label>
        <input type="text" id="tache_titre" name="tache_titre"><br>

        <label style="  position: relative; top: -40px;" for="tache_description">Description </label>
        <textarea rows="3" cols="23" id="tache_description" name="tache_description"></textarea><br>

        <label for="jour">Date de fin </label>

        <select id="jour" name="jour">
            <?php for ($i = 1; $i <= 31; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>

        <select name="mois">
            <?php echo genererMois($mois); ?>
        </select>

        <select name="annee">
            <?php for ($j = date('Y'); $j <= date('Y') + 5; $j++) : ?>
                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
            <?php endfor; ?>
        </select><br>


        <label for="priority">Priorité </label>
        <input type="radio" id="priority" name="priority" value="green"/>Basse <input type="radio" name="priority" value="black" checked/>Normale <input type="radio" name="priority" value="red"/>Haute<br><br>

        <div id="lb">
            <input id="button" type="submit" value="Enregistrer">
        </div>
    </form>

</div>

</body>
</html>
