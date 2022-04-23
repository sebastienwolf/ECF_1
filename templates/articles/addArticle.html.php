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
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault()
        let URL = "index.php?controller=article&task=add";

        let form = document.getElementById('form')
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