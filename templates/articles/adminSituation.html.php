<section id="tableau">

    <h2>Les locations en cours de <?= $articles[0]['prenom'] ?> <?= $articles[0]['nom'] ?></h2>

    <table>
        <thead>
            <tr>
                <th>Réservation</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date de réservation</th>
                <th>Date de retour</th>
                <th>Reste</th>
                <th>
                    <p class="rendre">Retourner l'article </p>
                </th>



            </tr>
        </thead>
        <tbody id="case">

        </tbody>
    </table>

    <form>
        <input class="bn634-hover bn27" id="impression" name="impression" type="button" onclick="imprimer_page()" value="Imprimer cette page" />
    </form>

    <a class="bn634-hover bn27" href="index.php?controller=users&task=adminUsers"> retour</a>

</section>


<script type="text/javascript">
    function imprimer_page() {
        window.print();
    }
</script>
<!-- =================================================================================================== -->
<script>
    const tableau = <?php echo json_encode($articles); ?>;

    pop(tableau)

    //==============================================================================================

    /* 
     le paramettre tableau est un array
     il permet d'afficher les élement du tableau en fonction du nombre d'element du tableau
    */
    function pop(tableau) {
        const x = document.getElementById('case');


        //boucle pour crée autant de ligne tr que le nombre de ligne du tableau
        tableau.forEach(element => {
            //crée un l'élement tr

            a = document.createElement('tr');
            a.id = element.id_article;
            if (element.reste < 0) {
                //a.style.background = 'red';
                a.className = "retard"
            }

            for (const i in element) {
                debugger

                //si autre que id_article alors on crée un td avec une valeur sinon un button avec valeur et data-id
                // if (i !== "id_user" || i !== "prenom" || i !== "nom") {
                if (i == "id_pret" || i == "titre" || i == "auteur" || i == "date_depart" || i == "date_retour" || i == "reste" || i == "id_article") {

                    if (i !== "id_article") {
                        let col = document.createElement('td');
                        col.innerHTML = element[i];
                        a.appendChild(col);
                    } else {
                        let tdButton = document.createElement('td');
                        let col = document.createElement('button');
                        col.innerHTML = "Rendre";
                        col.dataset.id = element[i];
                        col.dataset.user = element.id_user
                        col.className = "rendre"


                        tdButton.appendChild(col);
                        a.appendChild(tdButton);
                    }

                    //on mest tout ça dans le tableau
                    x.appendChild(a)
                }
            }
        });
    }

    //==========================================================================================
    let back = document.getElementsByClassName('rendre')
    console.log(back)
    let item
    for (item of back) {
        item.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm("Voulez vous rendre cette article ?")) {
                let id = event.target.dataset.id;
                let user = event.target.dataset.user;
                let URL = "index.php?controller=article&task=back&id=" + id
                let formData = new FormData();
                //formData.append(id)
                fetch(URL)
                    .then(function(response) {
                        return response.text()
                    })
                    .then(function(data) {
                        debugger
                        const x = document.getElementById(id);

                        x.remove()
                        //pop(data)
                    })
            }
        })

    }
</script>