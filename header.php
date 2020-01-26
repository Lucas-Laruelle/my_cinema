<header class="header">
    <section id=header-top>
        <div class="element" id="titre-header">
          <a href="Index.php"><img src="logo.png" id="index" width="230" height="100"></a>
        </div>
        <div class="element">
            <form action="Index.php" method="get">
                <input type="search" id="titre" name="titre" placeholder="Recherche par titres"> 
                <button class="square_btn">valider</button>   
            </form>
            <form method="get">
                <input type="date" name="date" id="name">
                <button class="square_btn">valider</button>
            </form>
        </div>
        
        <form action="Index.php" method="get">
        <input  class="square_btn" type="submit" name="genre" value="genre">
    </form>
    <form action="Index.php" method="get">
        <input class="square_btn" type="submit" name="distrib" value="distrib">
    </form>
    <div class="element">
            <a href="connexion.php"><input  class="square_btn" type="button" value="Membres"></a>
        </div>
    </section>
</header>