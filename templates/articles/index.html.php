<section id="index">
    <?php
    if (!empty($alert)) {
        $number = count($alert);
        if ($number > 0) {
    ?>

            <div id="popup">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <?php
                    if ($number == 1) {
                    ?>
                        Vous avez <?= $number ?> article en retard
                    <?php } else { ?>
                        Vous avez <?= $number ?> articles en retard
                </p>
            <?php
                    } ?> <?php
                            foreach ($alert as $al) {
                            ?> <p> &#149; <?= $al['titre'] ?></p>

            <?php
                            } ?>
            </div>
        <?php
        }
    }
    if (!empty($alertAdmin)) {

        $numberAdmin = count($alertAdmin);
        if ($numberAdmin > 0) {
        ?>
            <div id="popupAdmin">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <?php
                    if ($numberAdmin == 1) {
                    ?>
                        Il y a <?= $numberAdmin ?> article en retard
                    <?php } else { ?>
                        Il y a <?= $numberAdmin ?> articles en retard
                </p>
            <?php
                    } ?>
            <a class="emprunt" href="index.php?controller=article&task=adminEmprunts">Emprunts</a>

            </div>

    <?php
        }
    } ?>
    <?php
    foreach ($categorie as $cat) {
    ?>
        <h2><?= $cat['name'] ?></h2>
        <article>


            <?php
            $i = 0;
            foreach ($articles as $art) {


                if ($art['id_category'] == $cat['id_category']) {
            ?>
                    <div class="cards">
                        <a href="index.php?controller=article&task=showOne&id=<?= $art['id_article'] ?>">
                            <img class="miniCard" src="./upload/<?= $art['file'] ?>" alt="">
                            <div class="info">
                                <?php
                                if (in_array("auteur", $control)) {
                                ?>
                                    <p>Auteur : <?= $art['auteur'] ?> </p>
                                <?php }
                                if (in_array("genre", $control)) {
                                ?>
                                    <p>Genre : <?= $art['genre'] ?></p>
                                <?php }
                                if (in_array("collection", $control)) {
                                ?>
                                    <p>Collection : <?= $art['collection'] ?></p>
                                <?php }
                                if (in_array("edition", $control)) {
                                ?>
                                    <p>Edition : <?= $art['edition'] ?></p>
                                <?php } ?>

                            </div>
                        </a>
                        <h3><?= $art['titre'] ?></h3>

                    </div>
            <?php
                    $i++;
                    if ($i >= 4) {
                        $i = 0;
                        break;
                    }
                }
            } ?>

        </article>

    <?php } ?>



</section>

<script>
    // ==================== date changement de la fleche ====================================
    document.getElementById('date').addEventListener('click', event => {
        a = document.getElementById('date')
        if (a.dataset.id == "dateUp") {
            let x = "Date &uarr;"
            document.getElementById('date').innerHTML = x
            document.getElementById('date').dataset.id = "dateDown"
        } else {
            let x = "Date &darr;"
            document.getElementById('date').innerHTML = x
            document.getElementById('date').dataset.id = "dateUp"
        }

    })
    //===============================  search ============================================




    document.getElementById('search').addEventListener('submit', event => {
        event.preventDefault();

        // on recurepère les données de data des bouton
        let URL = "index.php?controller=article&task=showFiltre&id=search"

        form = document.getElementById('search')
        formData = new FormData(form)

        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.text()
            })
            .then(function(data) {
                console.log(data)
                i = JSON.parse(data)

                debugger


                let x = document.getElementById('index')
                // on boucle pour suprmier tous les enfant de index
                while (x.firstChild) {
                    x.removeChild(x.firstChild)
                }


                i.forEach(element => {


                    const fichier = "./upload/" + element.imageArticle;
                    const titre = element.titre;
                    const pseudo = element.pseudo;
                    const date = element.dateE;
                    const categori = element.theme;
                    const type = element.Type;
                    const url = "index.php?controller=article&task=showOne&id=" + element.idArticle

                    const contenair = document.createElement('article');
                    const image = document.createElement('img');
                    const Video = document.createElement('video')
                    const minicontenaire = document.createElement('div');
                    const nom = document.createElement('h3');
                    const p1 = document.createElement('p');
                    //const p2 = document.createElement('p');
                    const lien = document.createElement('a');
                    const saut = document.createElement('br');

                    if (type == "image") {
                        image.src = fichier
                    } else {
                        Video.src = fichier
                    }
                    lien.href = url
                    lien.textContent = "En savoir plus"
                    nom.textContent = titre

                    let text = date + "<br> " + "Auteur : " + pseudo + " &#149; Categorie : " + categori + "<br>" + "<button class='bn634-hover bn27'>" + "<a style='color: white;' href=" + lien + "> En savoir plus </button>"

                    p1.innerHTML = text


                    if (type == "image") {
                        contenair.appendChild(image)
                    } else {
                        contenair.appendChild(Video)
                    }
                    contenair.appendChild(minicontenaire)
                    minicontenaire.appendChild(nom)
                    minicontenaire.appendChild(p1)
                    index.appendChild(contenair)

                });






            })


    })


    // ==================== fetch filtre ====================================
    let i = document.getElementsByClassName('filtre')
    for (item of i) {
        console.log(item);

        item.addEventListener('click', event => {
            event.preventDefault();
            // on recurepère les données de data des bouton
            let a = event.target.dataset.id
            let URL = "index.php?controller=article&task=showFiltre&id=" + a



            fetch(URL)
                .then(function(response) {
                    return response.text()
                })
                .then(function(data) {
                    console.log(data)
                    i = JSON.parse(data)




                    let x = document.getElementById('index')
                    // on boucle pour suprmier tous les enfant de index
                    while (x.firstChild) {
                        x.removeChild(x.firstChild)
                    }


                    i.forEach(element => {


                        const fichier = "./upload/" + element.imageArticle;
                        const titre = element.titre;
                        const pseudo = element.pseudo;
                        const date = element.dateE;
                        const categori = element.theme;
                        const type = element.Type;
                        const url = "index.php?controller=article&task=showOne&id=" + element.idArticle

                        const contenair = document.createElement('article');
                        const image = document.createElement('img');
                        const Video = document.createElement('video')
                        const minicontenaire = document.createElement('div');
                        const nom = document.createElement('h3');
                        const p1 = document.createElement('p');
                        const p2 = document.createElement('p');
                        const p3 = document.createElement('p');
                        const p4 = document.createElement('p');
                        const p5 = document.createElement('p');
                        const saut = document.createElement('br');
                        const lien = document.createElement('a');
                        debugger
                        if (type == "image") {
                            image.src = fichier
                        } else {
                            Video.src = fichier
                        }
                        lien.href = url
                        lien.textContent = "En savoir plus"
                        nom.textContent = titre

                        let text = date + "<br> " + "Auteur : " + pseudo + " &#149; Categorie : " + categori + "<br>" + "<button class='bn634-hover bn27'>" + "<a style='color: white;' href=" + lien + "> En savoir plus </button>"
                        p1.innerHTML = text


                        if (type == "image") {
                            contenair.appendChild(image)
                        } else {
                            contenair.appendChild(Video)
                        }
                        contenair.appendChild(minicontenaire)
                        minicontenaire.appendChild(nom)
                        minicontenaire.appendChild(p1)
                        index.appendChild(contenair)


                    });






                })


        })
    }
</script>