<section id="tableau">

    <h2>Voici toutes vos réservations effectué </h2>

    <table>
        <thead>
            <tr>
                <th>Numéro de réservation</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Genre</th>
                <th>Collection</th>
                <th>Edition</th>
                <th>Rendu le :</th>



            </tr>
        </thead>
        <tbody id="case">

        </tbody>
    </table>




</section>
<!-- =================================================================================================== -->
<script>
    const tableau = <?php echo json_encode($articles); ?>;
    debugger
    pop(tableau)

    //==============================================================================================

    /* 
     le paramettre tableau est un array
     il permet d'afficher les élement du tableau en fonction du nombre d'element du tableau
    */
    function pop(tableau) {
        const x = document.getElementById('case');


        //boucle pour crée autant de ligne tr que le nombre de ligne du tableau
        tableau.forEach(element => {
            //crée un l'élement tr

            a = document.createElement('tr');
            a.id = element.id_article;
            for (const i in element) {

                //si autre que id_article alors on crée un td avec une valeur sinon un button avec valeur et data-id
                if (i !== "id_article") {
                    let col = document.createElement('td');
                    col.innerHTML = element[i];
                    a.appendChild(col);
                }
            }
            //on mest tout ça dans le tableau
            x.appendChild(a)

        });
    }
</script>