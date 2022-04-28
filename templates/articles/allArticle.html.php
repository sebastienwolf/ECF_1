<section id="index">
    <article id="allFiltre">

        <form id="filtre" class="filtre" name="form0" action="" method="POST">
            <select name="idCat" id="category">
            </select>
            <select name="idGen" id="genre"></select>
            <select name="idAut" id="auteur"></select>
            <select name="idCol" id="collection"></select>
            <select name="idEdit" id="edition"></select>
            <button class="bn634-hover bn27" type="submit"> Rechercher</button>
        </form>
    </article>

    <article id="allCards">
    </article>

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
    const tableau = <?php echo json_encode($articles); ?>;
    const filtre1 = <?php echo json_encode($idCat); ?>;
    const filtre2 = <?php echo json_encode($idGen); ?>;
    const filtre3 = <?php echo json_encode($idAut); ?>;
    const filtre4 = <?php echo json_encode($idCol); ?>;
    const filtre5 = <?php echo json_encode($idEdit); ?>;

    popCat("category", filtre1)
    popFiltre("genre", filtre2)
    popFiltre("auteur", filtre3)
    popFiltre("collection", filtre4)
    popFiltre("edition", filtre5)

    pop(tableau)
    //==============================================================================================
    // faire descendre les filtres
    document.getElementById("superFiltre").addEventListener('click', event => {
        // toogle permet de voir si la classe est active alors il l'enlève sinon il le mets
        document.getElementById("filtre").classList.toggle("active")

    })


    //==============================================================================================

    /* 
     le paramettre tableau est un array
     fera apparaitre les cards en fonction de la donnée en parametre
    */
    function pop(tableau) {
        tableau.forEach(element => {
            const verif = Object.values(<?php echo json_encode($control); ?>);
            //let verif =


            console.log(verif);


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
            if (verif.includes("auteur")) {
                let p1 = document.createElement('p');
                p1.innerText = "Auteur : " + element.auteur;
                minContenaire.appendChild(p1);

            }
            if (verif.includes("genre")) {

                let p2 = document.createElement('p');
                p2.innerText = "Genre : " + element.genre;
                minContenaire.appendChild(p2);

            }

            if (verif.includes("collection")) {

                let p3 = document.createElement('p');
                p3.innerText = "Collection : " + element.collection;
                minContenaire.appendChild(p3);

            }

            if (verif.includes("edition")) {

                let p4 = document.createElement('p');
                p4.innerText = "Edition : " + element.edition;
                minContenaire.appendChild(p4);

            }



            des.appendChild(img);
            des.appendChild(minContenaire);
            contenaire.appendChild(des);
            if (verif.includes("titre")) {

                let titre = document.createElement('h3');
                titre.innerText = element.titre;
                contenaire.appendChild(titre);

            }
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
        document.getElementById("filtre").classList.toggle("active")
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


                let x = document.getElementById('allCards')
                // on boucle pour suprmier tous les enfant de index
                while (x.firstChild) {
                    x.removeChild(x.firstChild)
                }

                let e = document.getElementById('category')
                // on boucle pour suprmier tous les enfant de index
                while (e.firstChild) {
                    e.removeChild(e.firstChild)
                }
                let a = document.getElementById('genre')
                // on boucle pour suprmier tous les enfant de index
                while (a.firstChild) {
                    a.removeChild(a.firstChild)
                }
                let b = document.getElementById('auteur')
                while (b.firstChild) {
                    b.removeChild(b.firstChild)
                }
                let c = document.getElementById('collection')
                while (c.firstChild) {
                    c.removeChild(c.firstChild)
                }
                let d = document.getElementById('edition')
                while (d.firstChild) {
                    d.removeChild(d.firstChild)
                }

                const filtre1 = <?php echo json_encode($idCat); ?>;
                const filtre2 = <?php echo json_encode($idGen); ?>;
                const filtre3 = <?php echo json_encode($idAut); ?>;
                const filtre4 = <?php echo json_encode($idCol); ?>;
                const filtre5 = <?php echo json_encode($idEdit); ?>;
                popCat("category", filtre1)
                popFiltre("genre", filtre2)
                popFiltre("auteur", filtre3)
                popFiltre("collection", filtre4)
                popFiltre("edition", filtre5)
                pop(data)
                //pop(data)
            })

    })




    //==============================================================================================

    /* 
     le paramettre tableau est un array
     fera apparaitre les filtre en fonction de la donnée en parametre
    */
    function popCat(id, tableau) {

        let i = 1
        let vide = document.createElement('option');
        vide.innerText = "Choix"
        vide.value = 0
        document.getElementById(id).appendChild(vide);

        tableau.forEach(element => {
            let contenaire = document.createElement('option');
            contenaire.value = i
            contenaire.innerText = element
            document.getElementById(id).appendChild(contenaire);
            i += 1
        })

    }
    //==============================================================================================

    /* 
     le paramettre tableau est un array
     fera apparaitre les filtre en fonction de la donnée en parametre
    */
    function popFiltre(id, tab) {

        let i = 0
        const tableau = Array.from(tab);
        let vide = document.createElement('option');
        vide.innerText = "Choix"
        vide.value = 0
        document.getElementById(id).appendChild(vide);

        tableau.forEach(element => {
            let contenaire = document.createElement('option');
            contenaire.value = element
            contenaire.innerText = element
            document.getElementById(id).appendChild(contenaire);
            i += 1
        })

    }

    //==========================================================================================
    //filtre 1
    document.getElementById('category').addEventListener('change', (event) => {
        event.preventDefault();
        debugger
        let URL = "index.php?controller=article&task=filtre1"
        let form = document.getElementById('category')
        let formData = new FormData()
        formData.append('idCat', form.value)
        //formData.append(id)
        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {

                console.log(data.idAut);
                let a = document.getElementById('genre')
                // on boucle pour suprmier tous les enfant de index
                while (a.firstChild) {
                    a.removeChild(a.firstChild)
                }
                let b = document.getElementById('auteur')
                while (b.firstChild) {
                    b.removeChild(b.firstChild)
                }
                let c = document.getElementById('collection')
                while (c.firstChild) {
                    c.removeChild(c.firstChild)
                }
                let d = document.getElementById('edition')
                while (d.firstChild) {
                    d.removeChild(d.firstChild)
                }

                popFiltre('genre', data.idGen)
                popFiltre('auteur', data.idAut)
                popFiltre('collection', data.idCol)
                popFiltre('edition', data.idEdit)

            })

    })

    //==========================================================================================
    //filtre 2
    document.getElementById('genre').addEventListener('change', (event) => {
        event.preventDefault();
        debugger
        let URL = "index.php?controller=article&task=filtre1"
        let form = document.getElementById('genre')
        let formData = new FormData()
        formData.append('idGen', form.value)

        //formData.append(id)
        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {

                let b = document.getElementById('auteur')
                while (b.firstChild) {
                    b.removeChild(b.firstChild)
                }
                let c = document.getElementById('collection')
                while (c.firstChild) {
                    c.removeChild(c.firstChild)
                }
                let d = document.getElementById('edition')
                while (d.firstChild) {
                    d.removeChild(d.firstChild)
                }

                popFiltre('auteur', data.idAut)

                popFiltre('collection', data.idCol)

                popFiltre('edition', data.idEdit)

            })

    })
    //==========================================================================================
    //filtre 3
    document.getElementById('auteur').addEventListener('change', (event) => {
        event.preventDefault();
        debugger
        let URL = "index.php?controller=article&task=filtre1"
        let form = document.getElementById('auteur')
        let formData = new FormData()
        formData.append('idAut', form.value)

        //formData.append(id)
        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {

                let c = document.getElementById('collection')
                while (c.firstChild) {
                    c.removeChild(c.firstChild)
                }
                let d = document.getElementById('edition')
                while (d.firstChild) {
                    d.removeChild(d.firstChild)
                }
                popFiltre('collection', data.idCol)

                popFiltre('edition', data.idEdit)

            })

    })
    //==========================================================================================
    //filtre 4
    document.getElementById('collection').addEventListener('change', (event) => {
        event.preventDefault();
        debugger
        let URL = "index.php?controller=article&task=filtre1"
        let form = document.getElementById('collection')
        let formData = new FormData()
        formData.append('idCol', form.value)

        //formData.append(id)
        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {

                let d = document.getElementById('edition')
                while (d.firstChild) {
                    d.removeChild(d.firstChild)
                }

                popFiltre('edition', data.idEdit)

            })

    })
</script>