<section id="formulaire">

    <form id="form" action="" method="POST">

    </form>
    <p id="message"></p>
    <a class="bn634-hover bn27" href="index.php?controller=article&task=showOne&id=<?= $articles[0]['id_article'] ?>">Retour</a>
</section>
<!-- <section>
    <div id="showImg">

    </div>
</section> -->
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

            for (const i in element) {
                debugger
                let div = document.createElement('div');

                if (i !== "id_article") {
                    let label = document.createElement('label');
                    label.innerText = cible[chiffre];
                    div.appendChild(label);
                    x.appendChild(div);
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

                    div.appendChild(col);
                    x.appendChild(div);
                }
                if (i == "name") {
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

                    div.appendChild(select)
                    x.appendChild(div);

                }

                if (i == "description") {

                    let select = document.createElement('textarea');
                    select.cols = "30"
                    select.rows = "30"
                    select.name = i
                    select.placeholder = element[i]
                    div.appendChild(select)
                    x.appendChild(div);

                }
                if (i == "file") {

                    let col = document.createElement('input');
                    col.type = "file";
                    col.name = i;
                    col.placeholder = element[i];

                    div.appendChild(col);
                    x.appendChild(div);


                    let cacher = document.createElement('input');
                    cacher.type = "text";
                    cacher.name = "del";
                    cacher.value = element[i];
                    cacher.hidden = "hidden";

                    div.appendChild(cacher);
                    x.appendChild(div);


                    // const contenaire = document.getElementById('showImg');
                    // let img = document.createElement('img');
                    // img.src = "./upload/" + element[i];
                    // img.alt = "";
                    // contenaire.appendChild(img);
                }
                chiffre++


            }

            let mod = document.createElement('button');
            mod.innerText = "valider";
            mod.id = "valider";
            mod.type = "submit";

            mod.className = "bn634-hover bn27"
            //on mest tout ça dans le tableau
            x.appendChild(mod);

        });

    }




    //========================================================================================
    //========================================================================================
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault()

        if (confirm("Voulez vous faire ces modification tetette?")) {
            const form = document.getElementById('form')
            const content = document.getElementById('showImg')
            let URL = "index.php?controller=article&task=valideModif"

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
                    // while (content.firstChild) {
                    //     content.removeChild(content.firstChild)
                    // }
                    let tab = Object.values(data.retour);
                    let y = Object.values(data.cat);

                    pop(tab, y);
                    document.getElementById('message').innerText = "Changement effectué"
                    alert('changement effectué');
                })
        }
    })
</script>