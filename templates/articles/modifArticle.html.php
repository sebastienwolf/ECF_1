<section>

    <form id="form" action="" method="POST">

    </form>
    <a href="index.php?controller=article&task=showOne&id=<?= $articles[0]['id_article'] ?>">Retour.............................................................</a>
</section>
<section>
    <div id="showImg">

    </div>
</section>
<script>
    const tableau = <?php echo json_encode($articles); ?>;
    const showCat = <?php echo json_encode($cat); ?>;



    pop(tableau, showCat)

    //==============================================================================================

    /* 
     *le paramettre tableau est un array
     *il permet d'afficher les élement du tableau en fonction du nombre d'element du tableau
     */
    function pop(tableau, showCat) {
        const x = document.getElementById('form');
        const cible = ["", "Titre :", "Auteur :", "Genre :", "Collection :", "Edition :", "Categorie :", "description :", "Image :"]
        let chiffre = 0



        //boucle pour crée autant de ligne tr que le nombre de ligne du tableau
        tableau.forEach(element => {
            //crée un l'élement tr
            for (const i in element) {
                if (i !== "id_article") {
                    let label = document.createElement('label');
                    label.innerText = cible[chiffre];
                    x.appendChild(label);
                }
                if (i !== "description" && i !== "file" && i !== "name") {
                    let col = document.createElement('input');
                    col.type = "text"
                    col.name = i
                    if (i == "id_article") {
                        col.hidden = "hidden"
                        col.value = element[i]
                    }
                    col.placeholder = element[i];

                    x.appendChild(col);
                }
                if (i == "name") {
                    debugger
                    let select = document.createElement('select');
                    select.name = "category"
                    let choix = document.createElement('option');
                    choix.innerText = element[i];
                    choix.value = 0;
                    select.appendChild(choix)

                    showCat.forEach(e => {
                        let option = document.createElement('option');
                        option.innerText = e['name'];
                        option.value = e['id_category'];
                        select.appendChild(option)
                    })

                    x.appendChild(select)
                }

                if (i == "description") {
                    let select = document.createElement('textarea');
                    select.cols = "30"
                    select.rows = "30"
                    select.name = i
                    select.placeholder = element[i]
                    x.appendChild(select)
                }
                if (i == "file") {
                    debugger
                    let col = document.createElement('input');
                    col.type = "file";
                    col.name = i;
                    col.placeholder = element[i];

                    x.appendChild(col);

                    let cacher = document.createElement('input');
                    cacher.type = "text";
                    cacher.name = "del";
                    cacher.value = element[i];
                    cacher.hidden = "hidden";

                    x.appendChild(cacher);

                    const contenaire = document.getElementById('showImg');
                    let img = document.createElement('img');
                    img.src = "./upload/" + element[i];
                    img.alt = "";
                    contenaire.appendChild(img);
                }
                chiffre++

            }

            let mod = document.createElement('button');
            mod.innerText = "valider";
            mod.id = "valider";
            mod.type = "submit";
            mod.onclick = function() {
                alert("Voulez vous faire les changements.");
            };
            //on mest tout ça dans le tableau
            x.appendChild(mod);

        });

    }




    //========================================================================================
    //========================================================================================
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault()
        debugger

        const form = document.getElementById('form')
        const content = document.getElementById('showImg')
        let URL = "index.php?controller=article&task=valideModif"
        debugger
        let formData = new FormData(form)

        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {
                debugger
                while (form.firstChild) {
                    form.removeChild(form.firstChild)
                }
                while (content.firstChild) {
                    content.removeChild(content.firstChild)
                }
                let tab = Object.values(data.retour);
                let y = Object.values(data.cat);

                pop(tab, y);
            })
    })
</script>