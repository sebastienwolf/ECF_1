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
        if ($articles[0]['emprunt'] == false) { ?>
            <p>stock : Disponible</p>
        <?php } else { ?>
            <p>stock : indisponible</p>

        <?php }

        if (isset($_SESSION['userType']) && $articles[0]['emprunt'] == false) { ?>
            <!-- <button id="tata" type="submit" class="bn632-hover bn25" data-id="<?= $articles[0]['idArticle'] ?>">Réservation</button> -->
            <button class="bn632-hover bn25"><a href="index.php?controller=article&task=reservation&id=<?= $articles[0]['id_article'] ?>"> réservation</a></button>

        <?php }
        if ($_SESSION['userType'] == "admin") { ?>
            <button id="reserver" class="bn632-hover bn25"><a href="index.php?controller=article&task=modifArticle&id=<?= $articles[0]['id_article'] ?>"> modifier</a></button>
        <?php } ?>
    </div>

</article>

<script>
    document.getElementById("reserver").addEventListener('submit', event => {
        event.preventDefault();
        debugger
        let id = document.getElementById('reserver').dataset.id;
        debugger
        // on recurepère les données de data des bouton
        let URL = "index.php?controller=article&task=reservation"
        let formData = new FormData()
        formData.append('id', id)

        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.text()
            })
            .then(function(data) {
                location.reload()
            })
    })