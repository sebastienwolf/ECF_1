<section id="formulaire">
    <h2>
        Inscription
    </h2>

    <form id="form" action="" method="post">
        <div>
            <input type="text" name="nom" placeholder="Nom">
        </div>
        <div>
            <input type="text" name="prenom" placeholder="Prénom">
        </div>
        <div>
            <input type="email" name="mail" placeholder="Mail">
        </div>
        <div>
            <input type="password" name="password" placeholder="Mot de Passe">
        </div>
        <div>
            <input type="text" name="adresse" placeholder="Adresse">
        </div>
        <div>
            <input type="text" name="ville" placeholder="Ville">
        </div>
        <div>
            <input type="text" name="cp" placeholder="Code Postal">
        </div>
        <div>
            <?php
            $type = $_SESSION['userType'];
            if ($type == "admin") { ?>
                <select type="select" name="type">
                    <option value="utilisateur">utilisateur</option>
                    <option value="admin">admin</option>
                </select>
            <?php } ?>
        </div>

        <button type="submit" class="creer bn634-hover bn27" name="creer">Créer</button>
    </form>
    <h3 id="erreur"></h3>


</section>


<script>
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault();
        if (confirm("Voulez vous créer ce compte ?")) {
            //  let url = "index.php?controller=users&task=connexion"
            let URL = "index.php?controller=users&task=inscription"

            let form = document.getElementById('form')
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
                    console.log("test", data)
                    debugger
                    let err = data;


                    switch (err) {
                        case '1':
                            document.location.href = 'index.php?controller=page&task=connexion'
                            alert('Vous êtes inscrit, vous pouvez vous connecter');
                            break;
                        case '2':
                            document.getElementById('erreur').innerHTML = "<p style='color:red'> le mail est déjà utilsé</p>";
                            break;
                        case '3':
                            document.getElementById('erreur').innerHTML = "<p style='color:red'> il manque une donnée</p>";
                            break;
                        case '4':
                            document.getElementById('erreur').innerHTML = "<p style='color:red'> le pseudo est déjà utilisé</p>";
                            break;
                        case '5':
                            document.location.href = 'index.php?controller=users&task=adminUsers'
                            alert('Vous rajouter un utilisateur');
                            break;


                    }
                })
        }


    })
</script>