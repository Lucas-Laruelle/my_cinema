<?php

try
{
    $user = 'root';
    $password = "root"; 
    $bdd = "cinema";
    
    $pdo = new PDO
    (
        'mysql:host=localhost;dbname='.$bdd,
        $user,
        $password
    );
    
    if (isset($_GET["date"]))
    {
        $qpdo = "SELECT * FROM film WHERE date_debut_affiche<'$_GET[date]' 
        AND date_fin_affiche>'$_GET[date]' ORDER BY titre ASC";

        if(empty($_GET["date"]))
        {
            $qpdo = 'SELECT * FROM film ORDER BY titre ASC';

            foreach($pdo->query($qpdo) as $row)
            {
                echo "<p><a href='Index.php?titre=" . $row[0] . "'<br>";
                echo $row["titre"] . "</a><br>";
                echo "En salle du " . $row["date_debut_affiche"] . " au ". $row["date_fin_affiche"] . "<br>";
            }
        }
        else
        {
            foreach($pdo->query($qpdo) as $row)
            {
                echo "<p><a href='Index.php?titre=" . $row["titre"] . "'<br>";
                echo $row["titre"] . "<a><br>";
                echo "En salle du " . $row["date_debut_affiche"] . " au ". $row["date_fin_affiche"] . "<br>";
            }
        }
    }

    $qpdo = "SELECT id_distrib,nom FROM distrib ORDER BY nom ASC";
 
    if (isset($_GET["distrib"]))
    {
        if($_GET["distrib"]=="distrib")
        {
            foreach($pdo->query($qpdo) as $row)
            {
                echo "<a href='Index.php?distrib=" . $row[0] . "'</p>" . $row[1] . "</a><br>";
            }
        }
        else
        {
            $qpdo = "SELECT titre,resum FROM film WHERE id_distrib LIKE $_GET[distrib] ORDER BY titre ASC";
            foreach($pdo->query($qpdo) as $row)
            {
                echo "<p><a href='Index.php?titre=" . $row[0] . "'" . "</p><br>";
                echo $row['titre'] . "</a><br>";
                echo $row['resum'] . "<br>";
            }    
        }
    }

    $qpdo = "SELECT id_genre,nom FROM genre ORDER BY nom ASC"; 

    if (isset($_GET["genre"]))
    {
        if($_GET["genre"]=="genre")
        {
            foreach($pdo->query($qpdo) as $row)
            {
                echo "<p><a href='Index.php?genre=" . $row[0]. "'</p>" . $row[1] . "</a><br>";
            }
        }
        else
        {
            $qpdo = "SELECT titre,resum FROM film WHERE id_genre LIKE $_GET[genre] ORDER BY titre ASC";
            foreach($pdo->query($qpdo) as $row)
            {
                echo "<p><a href='Index.php?titre=" . $row[0] . "'" . "</p><br>";
                echo $row['titre'] . "</a><br>";
                echo $row['resum'] . "<br>";
            }
        }
    }

    $qpdo = 'SELECT titre,resum FROM film ORDER BY titre ASC';

    if (isset($_GET["titre"]))
    {
        $test = $pdo->query("SELECT * FROM film WHERE titre='" . $_GET['titre'] . "'");
        $fetch = $test->fetch(); 
        if(empty($_GET["titre"]))
        {
            foreach($pdo->query($qpdo) as $row)
            {
                echo "<a href='Index.php?titre=" . $row[0] . "'" . "<br>";
                echo $row['titre'] . "</a><br>";
                echo $row['resum'] . "<br>";
            }
        }
        elseif($_GET["titre"] == $fetch['titre'])
        {
            $resultat_titre = $fetch['titre'];
            $resultat_resum = $fetch['resum'];
            $resultat_duree = $fetch['date_debut_affiche'];
            $resultat_prod = $fetch['date_fin_affiche'];
            $resultat_debut = $fetch['duree_min'];
            $resultat_fin = $fetch['annee_prod'];
            echo "<br><p>" . "<br>" . $resultat_titre . "</p><br>" . "<br>";
            echo "<p>" . $resultat_resum . "</p><br>" . "<br>";
            echo "<p>" .$resultat_duree . "</p><br>" . "<br>";
            echo "<p>" .$resultat_prod . "</p><br>" . "<br>";
            echo "<p>" .$resultat_debut . "</p><br>" . "<br>";
            echo "<p>" .$resultat_fin . "</p><br>" . "<br>";
        }
        else
        {
            $name=$_GET['titre'];
            $check = "SELECT titre,resum FROM film WHERE titre LIKE '%$name%' ORDER BY titre ASC";
            foreach($pdo->query($check) as $row)
            {
                echo "<p><a href='Index.php?titre=" . $row[0] . "'" . "</p><br>";
                echo $row['titre'] . "</a><br>";
                echo $row['resum'] . "<br>";
            }
        }
    }

    $qpdo = "SELECT * FROM fiche_personne";

    if(empty($_GET["prenom"]) && isset($_GET["nom"]))
    {
        $nom = $_GET['nom'];
        $nom_only = "SELECT * FROM fiche_personne WHERE nom LIKE '$nom%' ORDER BY nom ASC";
        foreach($pdo->query($nom_only) as $row)
        {
            echo "<p><a href='Index.php?personne=" . $row[0] . "'" . "</p><br>";
            echo $row['prenom'] . " " .$row['nom']  . "</a><br>";
            echo $row['email'] . "<br>";
        }
    }
    elseif(isset($_GET["prenom"]) && empty($_GET["nom"]))
    {
        $prenom = $_GET['prenom'];
        $prenom_only = "SELECT * FROM fiche_personne WHERE prenom LIKE '$prenom%' ORDER BY prenom ASC";
        foreach($pdo->query($prenom_only) as $row)
        {
            echo "<p><a href='Index.php?personne=" . $row['id_perso'] . "'" . "</p><br>";
            echo "<p>" .$row['prenom'] . " " .$row['nom']  . "</p></a><br>";
            echo "<p>" .$row['email'] . "</p><br>";
        }
        
    }
    elseif (isset($_GET["prenom"]) && isset($_GET["nom"]))
    {
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $nom_et_nom = "SELECT * FROM fiche_personne WHERE nom LIKE '$nom%' AND prenom LIKE '$prenom%'ORDER BY nom ASC";
        foreach($pdo->query($nom_et_nom) as $row)
        {
            echo "<p><a href='Index.php?personne=" . $row['id_perso'] . "'" . "</p><br>";
            echo $row['prenom'] . " " . $row['nom']  ."</a><br>";
            echo $row['email'] . "<br>";
        }
    }


    if(isset($_GET['personne']))
    {
        $qpdo = "SELECT abonnement.nom AS 'abo', abonnement.id_abo AS 'idé',
        fiche_personne.nom AS 'fnom', fiche_personne.prenom AS 'fprenom',
        fiche_personne.email AS 'femail', fiche_personne.id_perso
        FROM fiche_personne LEFT JOIN membre ON fiche_personne.id_perso=membre.id_fiche_perso 
        LEFT JOIN abonnement ON abonnement.id_abo=membre.id_abo
        WHERE fiche_personne.id_perso='" . $_GET['personne'] . "'";
        foreach($pdo->query($qpdo) as $row)
        {
            if(($row['idé'])==NULL)
            { 
                echo $row['fprenom'] .  " " . $row['fnom'] . "<br>";
                echo $row['femail'] . "<br>";
                echo "abonne toi !";
                echo "<form action='#' method='post'>
                        <select name='abon'>                        
                        <option value='1'>VIP</option>
                        <option value='2'>GOLD</option>
                        <option value='3'>Classic</option>
                        <option value='4'>pass day</option>
                        </select>
                        <input class='square_btn' type='submit' name='submit' value='Valider' />
                        </form>";
                        if(isset($_POST['submit']))
                        {
                            $new_abo = $_POST['abon']; 
                            $qpdo="UPDATE membre SET id_abo='" . $new_abo . "' WHERE id_fiche_perso='" . $_GET['personne'] . "'";
                            foreach ($pdo->query($qpdo) as $row)
                            {
                                echo "<p>c'est fait</p>";
                            }
                        };
            }
            else{
                echo "<p>" . $row['fprenom'] .  " " . $row['fnom'] . "<br>";
                echo "<p>" .$row['femail'] . "<br>";
                echo "<p>" .$row['abo'] ."</p><br> ";
               
                switch ($row['idé']) 
                {
                    case 1:
                        echo "<form action='#' method='post'>
                        <select name='abon'>                        
                        <option value='2'>GOLD</option>
                        <option value='3'>Classic</option>
                        <option value='4'>pass day</option>
                        <option value='0'>Supprimé abo</option>
                        </select>
                        <input class='square_btn' type='submit' name='submit' value='valider' />
                        </form>";
                        if(isset($_POST['submit']))
                        {
                            $new_abo = $_POST['abon']; 
                            $qpdo="UPDATE membre SET id_abo='" . $new_abo . "' WHERE id_fiche_perso='" . $_GET['personne'] . "'";
                            foreach ($pdo->query($qpdo) as $row)
                            {
                                echo "c'est fait";                                
                            }
                        };
                        break;
                    case 2:
                        echo "<form action='#' method='post'>
                        <select name='abon'>                        
                        <option value='1'>VIP</option>
                        <option value='3'>Classic</option>
                        <option value='4'>pass day</option>
                        <option value='0'>Supprimé abo</option>
                        </select>
                        <input class='square_btn' type='submit' name='submit' value='Valider' />
                        </form>";
                        if(isset($_POST['submit']))
                        {
                            $new_abo = $_POST['abon']; 
                            $qpdo="UPDATE membre SET id_abo='" . $new_abo . "' WHERE id_fiche_perso='" . $_GET['personne'] . "'";
                            foreach ($pdo->query($qpdo) as $row)
                            {
                                echo "c'est fait";
                            }
                        };
                        break;
                    case 3:
                        echo "<form action='#' method='post'>
                        <select name='abon'>                        
                        <option value='1'>VIP</option>
                        <option value='2'>GOLD</option>
                        <option value='4'>pass day</option>
                        <option value='0'>Supprimé abo</option>
                        </select>
                        <input class='square_btn' type='submit' name='submit' value='Valider' />
                        </form>";
                        if(isset($_POST['submit']))
                        {
                            $new_abo = $_POST['abon']; 
                            $qpdo="UPDATE membre SET id_abo='" . $new_abo . "' WHERE id_fiche_perso='" . $_GET['personne'] . "'";
                            foreach ($pdo->query($qpdo) as $row)
                            {
                                echo "c'est fait";
                            }
                        };
                        break;
                    case 4:
                        echo "<form action='#' method='post'>
                        <select name='abon'>                        
                        <option value='1'>VIP</option>
                        <option value='2'>GOLD</option>
                        <option value='3'>Classic</option>
                        <option value='0'>Supprimé abo</option>
                        </select>
                        <input class='square_btn' type='submit' name='submit' value='Valider' />
                        </form>";
                        if(isset($_POST['submit']))
                        {
                            $new_abo = $_POST['abon']; 
                            $qpdo="UPDATE membre SET id_abo='" . $new_abo . "' WHERE id_fiche_perso='" . $_GET['personne'] . "'";
                            foreach ($pdo->query($qpdo) as $row)
                            {
                                echo "<p>c'est fait</p>";
                            }
                        };
                        break;
                    
                        
                }
            }

        }
        
    }

    if(isset($_GET['personne']))
    {
    include_once "historique.php";
        $qpdo="SELECT film.titre as 'title' FROM film left join historique_membre on film.id_film=historique_membre.id_film left join membre on membre.id_membre=historique_membre.id_membre left join fiche_personne on fiche_personne.id_perso=membre.id_fiche_perso where fiche_personne.id_perso='" . $_GET['personne'] . "'";
        foreach ($pdo->query($qpdo) as $row)
        {
            echo "<p><a href='Index.php?titre=" . $row['title'] . "'" . "</p><br>";
            echo $row['title']. "<br>";
        }
    }


}
catch(PDOException $error){
    echo 'Error : ' . $error->getMessage() . PHP_EOL;
}