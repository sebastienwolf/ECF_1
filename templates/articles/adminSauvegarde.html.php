<section id="tableau">
    <h2> SAUVEGARDE</h2>
    <p>
        la sauvegarde ce fait tous les jours à 22h00 à la racine de votre ordinateur <br>
        voici la commande utilisé avec un crontask pour qu'elle ce répete tous les jours. </p>
    <p id="requete">
        00 22 * * * mysqldump -u backuper demo > demo-dump-$(data +%F).sql
    </p>


    <a class="bn634-hover bn27" href="index.php?controller=article&task=index"> retour</a>

</section>