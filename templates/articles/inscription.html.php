<section class="form">
    <article class="contact">
        <h2>
            Inscription
        </h2>
        <div>
            <form id="form" action="" method="post">
                <input type="text" name="nom" placeholder="Nom">
                <input type="text" name="prenom" placeholder="Prénom">
                <input type="email" name="mail" placeholder="Mail">
                <input type="password" name="password" placeholder="Mot de Passe">
                <input type="text" name="adresse" placeholder="Adresse">
                <input type="text" name="ville" placeholder="Ville">
                <input type="text" name="cp" placeholder="Code Postal">
                <?php
                $type = $_SESSION['userType'];
                if ($type == "admin") { ?>
                    <select type="select" name="type">
                        <option value="utilisateur">utilisateur</option>
                        <option value="admin">admin</option>
                    </select>
                <?php } ?>

                <button type="submit" class="creer bn633-hover bn26" name="creer">Créer</button>
            </form>
            <h3 id="erreur"></h3>
        </div>

    </article>
</section>


<script>
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault();
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


    })
</script>