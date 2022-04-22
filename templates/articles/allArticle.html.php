<section id="index">
    <article id="allFiltre">
        <form id="filtre" action="" method="post">
            <div>
                <h2>Categorie</h2>
                <?php
                $categori = filtre($articles, "name");
                foreach ($categori as $cat) {
                ?>
                    <input type="checkbox" value="<?= $cat ?>" name="category[]"><?= $cat ?>
                <?php } ?>
            </div>
            <div>
                <h2>Genre</h2>
                <?php
                $genre = filtre($articles, "genre");
                foreach ($genre as $gen) {
                ?>
                    <input type="checkbox" value="<?= $gen ?>" name="genre[]"><?= $gen ?>
                <?php } ?>
            </div>
            <div>
                <h2>Auteur</h2>
                <?php
                $auteur = filtre($articles, "auteur");
                foreach ($auteur as $aut) {
                ?>
                    <input type="checkbox" value="<?= $aut ?>" name="auteur[]"><?= $aut ?>
                <?php } ?>
            </div>
            <div>
                <h2>Collection</h2>
                <?php
                $collection = filtre($articles, "collection");
                foreach ($collection as $coll) {
                ?>
                    <input type="checkbox" value="<?= $coll ?>" name="collection[]"><?= $coll ?>
                <?php } ?>
            </div>
            <div>
                <h2>Edition</h2>
                <?php
                $editeur = filtre($articles, "edition");
                foreach ($editeur as $edit) {
                ?>
                    <input type="checkbox" value="<?= $edit ?>" name="edition[]"><?= $edit ?>
                <?php } ?>
            </div>

            <button type="submit"> rechercher</button>
        </form>
    </article>

    <article id="allCards">

</section>

<?php
/* 
                Function filtre prend en parametre un tableau et un champ de selection de colonne
                Il retourne un tableau
                */
function filtre($tableau, $champ)
{
    $filtre = array_column($tableau, $champ);
    $colonne = [];
    foreach ($filtre as $i) {


        if (!in_array($i, $colonne)) {
            array_push($colonne, $i);
        }
    }
    return $colonne;
} ?>
<!-- =================================================================================================== -->
<script>
    debugger
    const tableau = <?php echo json_encode($articles); ?>;

    pop(tableau)

    //==============================================================================================

    /* 
     le paramettre tableau est un array
     fera apparaitre les cards en fonction de la donnée en parametre
    */
    function pop(tableau) {
        tableau.forEach(element => {
            console.log("./upload/" + element.file);
            //a = document.createElement('article');
            let contenaire = document.createElement('div');
            contenaire.className = "cards";

            let des = document.createElement('a');
            des.href = "index.php?controller=article&task=showOne&id=" + element.id_article;

            let img = document.createElement('img');
            img.src = "./upload/" + element.file;
            img.alt = "";
            img.className = "miniCard";

            let minContenaire = document.createElement('div');
            minContenaire.className = "info"

            let p1 = document.createElement('p');
            p1.innerText = "auteur : " + element.auteur;

            let p2 = document.createElement('p');
            p2.innerText = "genre : " + element.genre;

            let p3 = document.createElement('p');
            p3.innerText = "collection : " + element.collection;

            let p4 = document.createElement('p');
            p4.innerText = "edition : " + element.edition;

            let titre = document.createElement('h3');
            titre.innerText = element.titre;

            minContenaire.appendChild(p1);
            minContenaire.appendChild(p2);
            minContenaire.appendChild(p3);
            minContenaire.appendChild(p4);
            des.appendChild(img);
            des.appendChild(minContenaire);
            contenaire.appendChild(des);
            contenaire.appendChild(titre);
            document.getElementById('allCards').appendChild(contenaire);
        })

    }



    //==========================================================================================
    // let back = document.getElementsByClassName('rendre')
    // console.log(back);
    // let item
    // for (item of back) {
    document.getElementById('filtre').addEventListener('submit', (event) => {
        event.preventDefault();
        console.log(event);
        debugger
        //let id = event.target.dataset.id
        let URL = "index.php?controller=article&task=filtreSelection"
        let form = document.getElementById('filtre')
        let formData = new FormData(form)
        //formData.append(id)
        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {
                debugger

                let x = document.getElementById('allCards')
                // on boucle pour suprmier tous les enfant de index
                while (x.firstChild) {
                    x.removeChild(x.firstChild)
                }

                pop(data)
                //pop(data)
            })

    })
</script>