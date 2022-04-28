<section id="index">
    <?php
    //si des alerte exite les afficher
    if (!empty($alert)) {
        $number = count($alert);
        if ($number > 0) {
    ?>

            <div id="popup">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <?php
                    if ($number == 1) {
                    ?>
                        Vous avez <?= $number ?> article en retard
                    <?php } else { ?>
                        Vous avez <?= $number ?> articles en retard
                </p>
            <?php
                    } ?> <?php
                            foreach ($alert as $al) {
                            ?> <p> &#149; <?= $al['titre'] ?></p>

            <?php
                            } ?>
            </div>
        <?php
        }
    }
    if (!empty($alertAdmin)) {
        //si des alerte exite les afficher

        $numberAdmin = count($alertAdmin);
        if ($numberAdmin > 0) {
        ?>
            <div id="popupAdmin">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <?php
                    if ($numberAdmin == 1) {
                    ?>
                        Il y a <?= $numberAdmin ?> article en retard
                    <?php } else { ?>
                        Il y a <?= $numberAdmin ?> articles en retard
                </p>
            <?php
                    } ?>
            <a class="emprunt" href="index.php?controller=article&task=adminEmprunts">Emprunts</a>

            </div>

    <?php
        }
    } ?>
    <?php
    foreach ($categorie as $cat) {
    ?>
        <h2><?= $cat['name'] ?></h2>
        <article>


            <?php
            $i = 0;
            foreach ($articles as $art) {

                //création des cards par categori avec un total de 4 par categorie maximum
                if ($art['id_category'] == $cat['id_category']) {
            ?>
                    <div class="cards">
                        <a href="index.php?controller=article&task=showOne&id=<?= $art['id_article'] ?>">
                            <img class="miniCard" src="./upload/<?= $art['file'] ?>" alt="">
                            <div class="info">
                                <?php
                                if (in_array("auteur", $control)) {
                                ?>
                                    <p>Auteur : <?= $art['auteur'] ?> </p>
                                <?php }
                                if (in_array("genre", $control)) {
                                ?>
                                    <p>Genre : <?= $art['genre'] ?></p>
                                <?php }
                                if (in_array("collection", $control)) {
                                ?>
                                    <p>Collection : <?= $art['collection'] ?></p>
                                <?php }
                                if (in_array("edition", $control)) {
                                ?>
                                    <p>Edition : <?= $art['edition'] ?></p>
                                <?php } ?>

                            </div>
                        </a>
                        <h3><?= $art['titre'] ?></h3>

                    </div>
            <?php
                    $i++;
                    if ($i >= 4) {
                        $i = 0;
                        break;
                    }
                }
            } ?>

        </article>

    <?php } ?>



</section>