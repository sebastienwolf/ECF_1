<section class="form">
    <article class="" id="">

        <form id="articleAdd" action="" method="post" enctype="multipart/form-data">
            <h2>Ajouter une vidéo</h2>

            <!-- <label for=""><b>Type :</b></label>
            <select type="select" name="type">
                <option value="video">Video</option>
                <option value="image">Image</option>
            </select> -->
            <label for=""><b>Titre :</b></label>
            <input type="text" name="titre" placeholder="Titre">
            <label for=""><b>Categorie :</b></label>
            <select type="select" name="categorie">
                <?php
                foreach ($themes as $theme) {
                ?>
                    <option value="<?= $theme['idCategorie'] ?>"><?= $theme['theme'] ?></option>

                <?php
                }
                ?>
            </select>
            <label for=""><b>Description :</b></label>
            <textarea name="description" id="" cols="30" rows="10"></textarea>
            <input class="filehidden" type="file" name="fichier">
            <!-- <button type="button" class="bn633-hover bn26">Choisir un fichier</button> -->


            <button type="submit" class="creer bn633-hover bn26" name="creer">Envoyer votre article</button>
            <button id="retour" class="bn633-hover bn26">Retour</button>
        </form>
        <h3 id="erreur"></h3>
    </article>
</section>

<script>
    document.getElementById('articleAdd').addEventListener('submit', event => {
        event.preventDefault()

        let URL = "index.php?controller=article&task=addArticle";

        let form = document.getElementById('articleAdd')
        let formData = new FormData(form)
        debugger
        fetch(URL, {
                body: formData,
                method: "post"
            })
            .then(function(response) {
                return response.json()
            })
            .then(function(data) {
                console.log(data)

                let err = data;

                switch (err) {
                    case 1:
                        document.location.href = "index.php?controller=article&task=index"
                        alert("Votre fichier est envoyé")
                        break;
                    case 2:
                        document.getElementById('erreur').innerHTML = "<p style='color:red'>Il manque une donnée.</p>";
                        break;
                    case 3:
                        document.getElementById('erreur').innerHTML = "<p style='color:red'> Le fichier n'est pas comptabile avec notre site.<br> Utilisé un format : jpg, jpeg, png, bmp, tif, mp4, mov, avi, wmv.</p>";
                        break;
                    case 4:
                        document.getElementById('erreur').innerHTML = "<p style='color:red'>Le fichier ne peux dépassé les 5M.</p>";
                        break;
                    case 5:
                        document.getElementById('erreur').innerHTML = "<p style='color:red'>Une erreur est survenue avec ce fichier</p>";
                        break;

                }
            })


    })
</script>