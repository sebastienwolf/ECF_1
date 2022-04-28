<section id="formulaire">
    <h2>Modification de l'utilisateur</h2>
    <form id="form" action="" method="POST">

    </form>
    <button class="bn634-hover bn27"><a href="index.php?controller=users&task=adminUsers">Retour</a></button>
</section>
<script>
    const tableau = <?php echo json_encode($users); ?>;

    pop(tableau)

    //==============================================================================================

    /* 
     *le paramettre tableau est un array
     *il permet d'afficher les élement du tableau en fonction du nombre d'element du tableau
     */
    function pop(tableau) {
        const x = document.getElementById('form');
        const cible = ["", "Prénom", "Nom", "Email", "Mot de passe", "Adresse", "Ville", "Code postal", "Rôle"]
        let chiffre = 0



        //boucle pour crée autant de ligne tr que le nombre de ligne du tableau
        tableau.forEach(element => {
            //crée un l'élement tr

            for (const i in element) {
                let div = document.createElement('div');
                if (i !== "id_user") {
                    let label = document.createElement('label');
                    label.innerText = cible[chiffre];
                    div.appendChild(label);
                }
                if (i !== "type") {
                    let col = document.createElement('input');
                    col.type = "text"
                    col.name = i
                    if (i == "id_user") {
                        col.hidden = "hidden"
                        col.value = element[i]
                    }
                    if (i !== "pwd") {
                        col.placeholder = element[i];
                    } else {
                        col.placeholder = "*********";
                    }
                    div.appendChild(col);
                }
                if (i == "type") {
                    let select = document.createElement('select');
                    select.name = "type"
                    let option1 = document.createElement('option');
                    option1.innerText = element[i];
                    let option2 = document.createElement('option');
                    option2.innerText = "utilisateur";
                    option2.value = "utilisateur";
                    let option3 = document.createElement('option');
                    option3.innerText = "admin";
                    option3.value = "admin";

                    select.appendChild(option1)
                    select.appendChild(option2)
                    select.appendChild(option3)
                    div.appendChild(select)
                }
                chiffre++
                x.appendChild(div)
            }

            let mod = document.createElement('button');
            mod.innerText = "Valider";
            mod.id = "valider";
            mod.type = "submit"

            mod.className = "bn634-hover bn27"
            //on mest tout ça dans le tableau

            x.appendChild(mod);

        });
    }


    //========================================================================================
    //========================================================================================
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault()
        if (confirm("Voulez vous faire ces changements ?")) {
            const form = document.getElementById('form')
            let URL = "index.php?controller=users&task=modifyAdmin"

            let formData = new FormData(form)

            fetch(URL, {
                    body: formData,
                    method: "post"
                })
                .then(function(response) {
                    return response.json()
                })
                .then(function(data) {

                    while (form.firstChild) {
                        form.removeChild(form.firstChild)
                    }
                    pop(data)
                })
        }
    })
</script>