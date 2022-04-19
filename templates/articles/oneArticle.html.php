<article class="oneArticle">


    <img class="fichierOne" src="./upload/<?= $articles[0]['file'] ?>" class="card__image" alt="" />
    <div>
        <h3 class="card__title"><?= $articles[0]['titre'] ?></h3>
        <hr>
        <p>auteur : <?= $articles[0]['auteur'] ?> </p>
        <p>genre : <?= $articles[0]['genre'] ?> &#149; categorie : <?= $articles[0]['name'] ?></p>
        <p>Edition : <?= $articles[0]['edition'] ?> &#149; collection : <?= $articles[0]['collection'] ?></p>
        <hr>
        <p id="description"> Description :</p>
        <p><?= $articles[0]['description'] ?></p>
        <?php
        if ($_SESSION['userType'] == "admin") { ?>
            <button class="bn632-hover bn25"><a href="index.php?controller=article&task=modifArticle&id=<?= $articles[0]['idArticle'] ?>"> modifier</a></button>
        <?php } ?>
    </div>

</article>