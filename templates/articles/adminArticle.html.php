<section>

    <form id="form" action="" method="POST">
        <label for="">Titre :</label>
        <input type="text" name="titre" placeholder="Titre">
        <label for="">Auteur :</label>
        <input type="text" name="auteur" placeholder="Auteur">
        <label for=""> Genre :</label>
        <input type="text" name="genre" placeholder="Genre">
        <label for="">Collection :</label>
        <input type="text" name="collection" placeholder="collection">
        <label for="">Edition :</label>
        <input type="text" name="edition" placeholder="edition">
        <label for="">Catégorie :</label>
        <select name="category" id="">
            <?php
            foreach ($themes as $theme) {
            ?>
                <option value="<?= $theme['id_category'] ?>"><?= $theme['name'] ?></option>

            <?php
            }
            ?>

        </select>
        <label for="">Description :</label>
        <textarea name="description" id="" cols="30" rows="10"></textarea>
        <label for="">Image :</label>
        <input type="file" name="image">
        <button type="submit" onclick="return window.confirm('Êtes vous sûr de vouloir ajouter cette articles ?')"> Ajouter l'article</button>
    </form>
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
        const cible = ["", "titre", "auteur", "genre", 'collection', 'edition', '', '', 'emprunt', ]
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