<section class="form" id="">
    <article>
        <form id="modifierArticle" action="" method="post" enctype="multipart/form-data">
            <h2>Modification</h2>

            <label for=""><b>Titre :</b></label>
            <input type="text" name="titre" placeholder="<?= $articles[0]['titre'] ?>">
            <label for=""><b>Categorie :</b></label>
            <select type="select" name="categorie">
                <option value="0"><?= $articles[0]['theme'] ?></option>
                <?php
                foreach ($themes as $theme) {
                ?>
                    <option value="<?= $theme['idCategorie'] ?>"><?= $theme['theme'] ?></option>

                <?php
                }
                ?>
            </select>
            <label for=""><b>Description :</b></label>
            <textarea name="description" id="" cols="30" rows="10" placeholder="<?= $articles[0]['contenu'] ?>"></textarea>
            <label for=""><b>Modifier le fichier :</b></label>
            <input type="file" name="fichier">
            <input type="text" value="<?= $articles[0]['idArticle'] ?>" hidden name="id">
            <input type="text" value="<?= $articles[0]['imageArticle'] ?>" hidden name="deleteFichier">

            <button type="submit" class="creer bn633-hover bn26" name="creer">Valider les modifications</button>

        </form>
    </article>
    <article>
        <div id="delBack" class="delBack">
            <form id="delete" action="index.php?controller=article&task=delete&id=<?= $articles[0]['idArticle'] ?>" method="post">
                <input hidden type="text" name="fichier" value="<?= $articles[0]['imageArticle'] ?>">
                <button class="bn632-hover bn25" type="submit"> Supprimer</button>
            </form>
            <button class="bn632-hover bn25" id="retour">Retour</button>
        </div>
        <p id="erreur"></p>
    </article>

</section>

<script>
    document.getElementById('retour').addEventListener('click', event => {
        document.location.href = "index.php?controller=article&task=showOne&id=" + <?= $articles[0]['idArticle'] ?>
    })
    //====================================================================================

    //====================================================================================

    document.getElementById('modifierArticle').addEventListener('submit', event => {
        event.preventDefault();
        //let url = "index.php?controller=users&task=connexion"
        let URL = "index.php?controller=article&task=valideModif"

        let form = document.getElementById('modifierArticle')
        let formData = new FormData(form)
        formData.append('sendMessage', 'retour')

        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {
                console.log(data)
                debugger
                let err = data;
                if (data > 0) {


                    switch (err) {
                        case 1:
                            location.reload()
                            alert("Modification effectué.");
                            break;

                        case 3:
                            location.reload()
                            document.getElementById('erreur').innerHTML = "<p style='color:red'> Le fichier n'est pas comptabile avec notre site.<br> Utilisé un format : jpg, jpeg, png, bmp, tif, mp4, mov, avi, wmv.</p>";
                            break;
                        case 4:
                            location.reload()
                            document.getElementById('erreur').innerHTML = "<p style='color:red'>Le fichier ne peux dépassé les 5M.</p>";
                            break;
                        case 5:
                            location.reload()
                            document.getElementById('erreur').innerHTML = "<p style='color:red'>Une erreur est survenue avec ce fichier</p>";
                            break;

                    }
                } else {
                    location.reload()
                }
            })


    })
</script>