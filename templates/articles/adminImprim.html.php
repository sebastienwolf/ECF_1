<section id="profil" class="profil">
    <h2> Carte adhérent </h2>
    <article id="yesprint">
        <img src="./upload/profil.webp" alt="">
        <div id="profilUser">

            <p>
                <b>Prenom :</b> <?= $user[0]['prenom'] ?>
                <b>Nom :</b> <?= $user[0]['nom'] ?>
            </p>
            <p><b>Mail :</b> <?= $user[0]['mail'] ?></p>
            <p><b>Adresse :</b> <?= $user[0]['adress'] ?></p>
            <p><b>Ville :</b> <?= $user[0]['city'] ?></p>
            <p><b>Code postal :</b> <?= $user[0]['cp'] ?></p>
            <p><b>Votre grade :</b> <?= $user[0]['type'] ?></p>
            <p><b>Numéro de carte :</b> <?= $user[0]['id_user'] ?></p>

            <!-- <p><b>Mot de passe :</b> *******</p> -->
        </div>


    </article>
    <form>
        <input class="bn634-hover bn27" id="impression" name="impression" type="button" onclick="imprimer_page()" value="Imprimer cette page" />
    </form>
    <a class="bn634-hover bn27" href="index.php?controller=users&task=adminUsers"> retour</a>

</section>
<script type="text/javascript">
    function imprimer_page() {
        window.print();
    }
</script>