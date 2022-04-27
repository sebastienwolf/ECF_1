<section id="sauvegarde">
    <h2>
        Personalisation de la page d'accueil
    </h2>

    <form id="form" action="" method="post">
        <div>
            <label>Titre : </label>
            <input type="checkbox" value="1" name="titre" checked>
        </div>
        <div>
            <label>Auteur : </label>

            <input type="checkbox" value="1" name="auteur" checked>
        </div>
        <div>
            <label>Genre : </label>

            <input type="checkbox" value="1" name="genre" checked>
        </div>
        <div>
            <label>Collection : </label>

            <input type="checkbox" value="1" name="collection" checked>
        </div>
        <div>
            <label>Edition : </label>

            <input type="checkbox" value="1" name="edition" checked>
        </div>
        <div>
            <label>Description : </label>

            <input type="checkbox" value="1" name="description" checked>
        </div>

        <button type="submit" class="creer bn634-hover bn27" name="creer">Personaliser</button>
    </form>
    <h3 id="erreur"></h3>


</section>
<script>
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault();

        if (confirm("Voulez vous créer ce compte ?")) {

            let URL = "index.php?controller=article&task=personalisation";
            let form = document.getElementById('form')
            let formData = new FormData(form)

            fetch(URL, {
                    body: formData,
                    method: "post"
                })
                .then(function(response) {
                    return response.json()
                })
                .then(function(data) {
                    location.reload();
                })
        }


    })
</script>