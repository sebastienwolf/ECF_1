<section>

    <form id="form" action="" method="POST">

    </form>
    <a href="index.php?controller=users&task=adminUsers">Retour.............................................................</a>
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
        const cible = ["", "Prénom", "Nom", "Email", "Mot de passe", "adresse", "Ville", "Code postal", "Role"]
        let chiffre = 0



        //boucle pour crée autant de ligne tr que le nombre de ligne du tableau
        tableau.forEach(element => {
            //crée un l'élement tr
            debugger
            for (const i in element) {
                if (i !== "id_user") {
                    let label = document.createElement('label');
                    label.innerText = cible[chiffre];
                    x.appendChild(label);
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
                    x.appendChild(col);
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
                    x.appendChild(select)
                }
                chiffre++

            }

            let mod = document.createElement('button');
            mod.innerText = "valider";
            mod.id = "valider";
            mod.type = "submit"
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
        const form = document.getElementById('form')
        let URL = "index.php?controller=users&task=modifyAdmin"
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
                pop(data)
            })
    })
</script>