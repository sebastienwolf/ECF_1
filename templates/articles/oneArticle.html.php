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
            <button id="reservation" class="bn634-hover bn27" data-bool="true" data-id="<?= $articles[0]['id_article'] ?>" onclick="return window.confirm('Êtes vous sûr de vouloir réserver cette article ?')">
                Réservation</button>
        <?php }
        if ($_SESSION['userType'] == "admin") { ?>
            <div>
                <button id=" reserver" class="bn634-hover bn27"><a href="index.php?controller=article&task=modifArticle&id=<?= $articles[0]['id_article'] ?>"> modifier</a></button>
                <button id=" supprimer" class="bn634-hover bn27"><a href="index.php?controller=article&task=delete&id=<?= $articles[0]['id_article'] ?>&&file=<?= $articles[0]['file'] ?>" onclick="return window.confirm('Êtes vous sûr de vouloir suprimer cette article ?')"> suprimer</a></button>
            </div>
        <?php } ?>
        <div id="message" class="message">
            <p id="reponse"></p>
            <button class="bn634-hover bn27" id="retour">retour</button>
        </div>
    </div>

</article>

<script>
    document.getElementById("reservation").addEventListener('click', event => {
        event.preventDefault();
        let id = document.getElementById('reservation').dataset.id;
        let bool = document.getElementById('reservation').dataset.bool;
        let URL = "index.php?controller=article&task=reservation";
        let formData = new FormData();
        formData.append('id', id);
        formData.append('bool', bool);


        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.text()
            })
            .then(function(data) {
                debugger
                document.getElementById('reponse').innerHTML = data;
                document.getElementById('message').classList.toggle("active");
                location.reload()
            })
    })
    // ==============================================================================
    //retour
    document.getElementById("retour").addEventListener('click', event => {
        // toogle permet de voir si la classe est active alors il l'enlève sinon il le mets
        document.getElementById("message").classList.toggle("active")
    })
</script>