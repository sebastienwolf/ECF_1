<section id="tableau">
    <div>
        <a id="addUser" class="bn634-hover bn27" href="index.php?controller=page&task=Inscription">Ajouter un utilisateur</a>
    </div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Mail</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code postal</th>
                <th>Rôle</th>
                <th>Carte</th>
                <th>Situation</th>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody id="case">

        </tbody>
    </table>
</section>


<script>
    const tableau = <?php echo json_encode($allUsers); ?>;

    pop(tableau)

    //==============================================================================================

    /* 
     *le paramettre tableau est un array
     *il permet d'afficher les élement du tableau en fonction du nombre d'element du tableau
     */
    function pop(tableau) {
        const x = document.getElementById('case');


        //boucle pour crée autant de ligne tr que le nombre de ligne du tableau
        tableau.forEach(element => {
            //crée un l'élement tr

            a = document.createElement('tr');
            a.id = "r" + element.id_user;

            for (const i in element) {

                //si autre que id_article alors on crée un td avec une valeur sinon un button avec valeur et data-id
                if (i !== "pwd") {
                    let col = document.createElement('td');
                    col.innerText = element[i];
                    a.appendChild(col);
                }
            }
            let colIprim = document.createElement('td');
            let modImprim = document.createElement('a');
            let Imprim = document.createElement('button');
            modImprim.innerText = "Imprimer";
            modImprim.className = "imprim";
            modImprim.href = "index.php?controller=users&task=adminImprim&id=" + element['id_user'];
            Imprim.appendChild(modImprim)
            colIprim.appendChild(Imprim);
            a.appendChild(colIprim);

            let colSit = document.createElement('td');
            let modSit = document.createElement('a');
            let situation = document.createElement('button');
            modSit.innerText = "Imprimer";
            modSit.className = "situation";
            modSit.href = "index.php?controller=article&task=adminSituation&id=" + element['id_user'];
            situation.appendChild(modSit)
            colSit.appendChild(situation);
            a.appendChild(colSit);


            let col = document.createElement('td');
            let mod = document.createElement('a');
            let modify = document.createElement('button');
            mod.innerText = "Modifier";
            mod.className = "modifier";
            mod.href = "index.php?controller=users&task=adminProfil&id=" + element['id_user'];

            // let lien = document.createElement('a')
            // lien.href = "index.php?controller=users&task=adminProfil&id=" + element['id_user'];
            // mod.appendChild(lien)
            modify.appendChild(mod)
            col.appendChild(modify);
            a.appendChild(col);

            let col2 = document.createElement('td');
            let sup = document.createElement('button');
            sup.innerText = "Supprimer";
            sup.dataset.id = element['id_user'];
            sup.className = "suprimer";
            sup.onclick = function() {
                alert("Voulez vous suprimer " + element['prenom'] + " " + element['nom']);
            };
            col2.appendChild(sup);
            // on met les deux button dans le td
            a.appendChild(col2);

            //on mest tout ça dans le tableau
            x.appendChild(a)


        });
    }
    //========================================================================================================
    let modifier = document.getElementsByClassName('modifier')
    let supr = document.getElementsByClassName('suprimer')
    let itemSupr

    for (itemSupr of supr) {

        itemSupr.addEventListener('click', (event) => {
            event.preventDefault()
            let a = event.target.dataset.id
            let URL = "index.php?controller=users&task=delete&id=" + a
            console.log(a);
            let id = ("r" + a)

            fetch(URL)
                .then(function(response) {
                    return response.text()
                })
                .then(function(data) {

                    document.getElementById(id).remove()
                })
        })
    }
</script>