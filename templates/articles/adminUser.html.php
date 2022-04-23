<section>
    <div>
        <a href="index.php?controller=page&task=Inscription">Ajouter un utilisateur</a>
    </div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
                <th scope="col">Mail</th>
                <th scope="col">Adresse</th>
                <th scope="col">Ville</th>
                <th scope="col">Code postal</th>
                <th scope="col">Role</th>
                <th scope="col"></th>

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
            debugger
            let mod = document.createElement('a');
            mod.innerText = "modifier";
            mod.className = "modifier";
            mod.href = "index.php?controller=users&task=adminProfil&id=" + element['id_user'];

            // let lien = document.createElement('a')
            // lien.href = "index.php?controller=users&task=adminProfil&id=" + element['id_user'];
            // mod.appendChild(lien)
            a.appendChild(mod);

            let sup = document.createElement('button');
            sup.innerText = "suprimer";
            sup.dataset.id = element['id_user'];
            sup.className = "suprimer";
            sup.onclick = function() {
                alert("Voulez vous suprimer " + element['prenom'] + " " + element['nom']);
            };
            a.appendChild(sup);
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