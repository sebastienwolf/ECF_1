<section id="index">
    <?php
    if (isset($articles[0]['Type'])) {
        foreach ($articles as $article) {
    ?>

            <article>
                <?php if ($article['Type'] == "image") { ?>
                    <img src="./upload/<?= $article['imageArticle'] ?>" />
                <?php } else { ?>
                    <video controls src="upload/<?= $article['imageArticle'] ?>">La vidéo n'a pas pu ce charger</video>
                <?php } ?>
                <div>
                    <h3><?= $article['titre'] ?></h3>
                    <p><?= $article['dateE'] ?><br>
                        Auteur : <?= $article['pseudo'] ?> &#149; Catégorie : <?= $article['theme'] ?> <br>
                        <button class="bn632-hover bn25"><a style="color: white;" href="index.php?controller=article&task=showOne&id=<?= $article['idArticle'] ?>">En savoir plus</a></button>
                    </p>
                </div>
            </article>

        <?php }
    } else { ?>
        <h2> Vous n'avez pas mit de vidéo.</h2>
    <?php } ?>





</section>
<!-- =================================================================================================== -->
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




    // document.getElementById('search').addEventListener('submit', event => {
    //     event.preventDefault();

    //     // on recurepère les données de data des bouton
    //     let URL = "index.php?controller=article&task=showFiltre&id=search"

    //     form = document.getElementById('search')
    //     formData = new FormData(form)

    //     fetch(URL, {
    //             body: formData,
    //             method: "post"
    //         })
    //         .then(function(response) {
    //             return response.text()
    //         })
    //         .then(function(data) {
    //             console.log(data)
    //             i = JSON.parse(data)

    //             debugger


    //             let x = document.getElementById('index')
    //             // on boucle pour suprmier tous les enfant de index
    //             while (x.firstChild) {
    //                 x.removeChild(x.firstChild)
    //             }


    //             i.forEach(element => {


    //                 const fichier = "./upload/" + element.imageArticle;
    //                 const titre = element.titre;
    //                 const pseudo = element.pseudo;
    //                 const date = element.dateE;
    //                 const categori = element.theme;
    //                 const type = element.Type;
    //                 const url = "index.php?controller=article&task=showOne&id=" + element.idArticle

    //                 const contenair = document.createElement('article');
    //                 const image = document.createElement('img');
    //                 const Video = document.createElement('video')
    //                 const minicontenaire = document.createElement('div');
    //                 const nom = document.createElement('h3');
    //                 const p1 = document.createElement('p');
    //                 //const p2 = document.createElement('p');
    //                 const lien = document.createElement('a');
    //                 const saut = document.createElement('br');

    //                 if (type == "image") {
    //                     image.src = fichier
    //                 } else {
    //                     Video.src = fichier
    //                 }
    //                 lien.href = url
    //                 lien.textContent = "En savoir plus"
    //                 nom.textContent = titre

    //                 let text = date + "<br> " + "Auteur : " + pseudo + " &#149; Categorie : " + categori + "<br>" + "<button class='bn632-hover bn25'>" + "<a style='color: white;' href=" + lien + "> En savoir plus </button>"

    //                 p1.innerHTML = text


    //                 if (type == "image") {
    //                     contenair.appendChild(image)
    //                 } else {
    //                     contenair.appendChild(Video)
    //                 }
    //                 contenair.appendChild(minicontenaire)
    //                 minicontenaire.appendChild(nom)
    //                 minicontenaire.appendChild(p1)
    //                 index.appendChild(contenair)

    //             });






    //         })


    // })


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

                        let text = date + "<br> " + "Auteur : " + pseudo + " &#149; Categorie : " + categori + "<br>" + "<button class='bn632-hover bn25'>" + "<a style='color: white;' href=" + lien + "> En savoir plus </button>"
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