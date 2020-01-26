<?php

    $qpdo="SELECT titre FROM film ORDER BY titre ASC";

    if (isset($_GET['personne']))
    {
        echo "<label>Ajoute un film vu:</label>
        <form method=\"post\">
        <select name=histo>";
            foreach ($pdo->query($qpdo) as $row)
            {
                $title = $row['titre'];
                echo "<option value=\"$title\">$title</option>";
            }
        echo "</select>";
        echo "<label>Ajoute un avis (si tu le souhaites)</label>
            <form method=\"post\">
            <input type=\"text\" name=\"avis\">
            <input class='square_btn' type=\"submit\" value=\"Valider\"></form>
            </form>";
        if(isset($_POST['histo']))
        {
            if(empty($_POST['avis']))
            { 
                $membre = "SELECT membre.id_membre as 'member' from membre left join fiche_personne on fiche_personne.id_perso=membre.id_fiche_perso where fiche_personne.id_perso='" . $_GET['personne'] . "'";
                foreach($pdo->query($membre) as $row)
                {
                    $id_membre = $row['member'];
                }
                $film = "SELECT film.id_film as 'titre' from film where film.titre='" . $_POST['histo'] . "'";
                foreach($pdo->query($film) as $row)
                {
                    $id_film = $row['titre'];
                }
                $inser = $pdo->prepare("INSERT INTO historique_membre(id_membre,id_film,date,avis) VALUES ($id_membre,$id_film,CURRENT_DATE,\"\")");
                $inser->execute(array());
            }
            elseif(isset($_POST['avis']))
            {
                $avis = $_POST['avis'];
                $membre = "SELECT membre.id_membre as 'member' from membre left join fiche_personne on fiche_personne.id_perso=membre.id_fiche_perso where fiche_personne.id_perso='" . $_GET['personne'] . "'";
                foreach($pdo->query($membre) as $row)
                {
                    $id_membre = $row['member'];
                }
                $film = "SELECT film.id_film as 'titre' from film where film.titre='" . $_POST['histo'] . "'";
                foreach($pdo->query($film) as $row)
                {
                    $id_film = $row['titre'];
                }
                $inser = $pdo->prepare("INSERT INTO historique_membre(id_membre,id_film,date,avis) VALUES ($id_membre,$id_film,CURRENT_DATE,\"$avis\")");
                $inser->execute(array());
            }
        }
    }
