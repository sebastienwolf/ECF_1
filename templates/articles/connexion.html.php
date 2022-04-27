<section id="formulaire">
    <article class="contact">
        <h2>
            Connexion
        </h2>
        <div>
            <form id="form" action="index.php?controller=users&task=connexion" method="post">
                <input type="email" placeholder="E-mail" name="mail" class="inputConnec">
                <input type="password" placeholder="Mot de passe" name="password" class="inputConnec">
        </div>
        <div class="spaceButton">
            <button class="bn634-hover bn27" type="submit" name="connexion">Connexion</button>
        </div>
        </form>
        <div>
            <button class="bn634-hover bn27" name='inscription'><a href="index.php?controller=page&task=inscription"> Inscription</a></button>
        </div>

        <h3 id="erreur"></h3>


    </article>
</section>

<script>
    document.getElementById('form').addEventListener('submit', event => {
        event.preventDefault();
        //let url = "index.php?controller=users&task=connexion"


        // console.log(document.cookie)
        // document.cookie = "PHPSESSID=;"
        // console.log(document.cookie)



        let URL = "index.php?controller=users&task=connexion"

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
                console.log(data)
                let err = data;

                switch (err) {
                    case '1':
                        //location.reload();
                        document.location.href = "index.php?controller=article&task=index"
                        alert("vous êtes connecté")
                        break;
                    case '2':
                        document.getElementById('erreur').innerHTML = "<p style='color:yellow'>il y a une erreur dans le mot de passe ou le mail</p>";
                        break;
                    case '3':
                        document.getElementById('erreur').innerHTML = "<p style='color:yellow'> l'utilisateur n'existe pas</p>";
                        break;

                }
            })


    })
</script>