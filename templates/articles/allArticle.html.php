<section id="index">

    <article id="allCards">

</section>
<!-- =================================================================================================== -->
<script>
    debugger
    const tableau = <?php echo json_encode($articles); ?>;

    pop(tableau)

    //==============================================================================================

    /* 
     le paramettre tableau est un array
     fera apparaitre les cards en fonction de la donnée en parametre
    */
    function pop(tableau) {
        tableau.forEach(element => {
            console.log("./upload/" + element.file);
            //a = document.createElement('article');
            let contenaire = document.createElement('div');
            contenaire.className = "cards";

            let des = document.createElement('a');
            des.href = "index.php?controller=article&task=showOne&id=" + element.id_article;

            let img = document.createElement('image');
            img.src = "./upload/" + element.file;
            img.alt = "";
            img.className = "miniCard";

            let minContenaire = document.createElement('div');
            minContenaire.className = "info"

            let p1 = document.createElement('p');
            p1.innerText = "auteur : " + element.auteur;

            let p2 = document.createElement('p');
            p2.innerText = "genre : " + element.genre;

            let p3 = document.createElement('p');
            p3.innerText = "collection : " + element.collection;

            let p4 = document.createElement('p');
            p4.innerText = "edition : " + element.edition;

            let titre = document.createElement('h3');
            titre.innerText = element.titre;

            minContenaire.appendChild(p1);
            minContenaire.appendChild(p2);
            minContenaire.appendChild(p3);
            minContenaire.appendChild(p4);
            des.appendChild(img);
            des.appendChild(minContenaire);
            contenaire.appendChild(des);
            contenaire.appendChild(titre);
            document.getElementById('allCards').appendChild(contenaire);
        })

    }



    //==========================================================================================
    let back = document.getElementsByClassName('rendre')
    console.log(back);
    let item
    for (item of back) {
        item.addEventListener('click', (event) => {
            event.preventDefault();

            let id = event.target.dataset.id
            let URL = "index.php?controller=article&task=back&id=" + id
            let formData = new FormData()
            //formData.append(id)
            fetch(URL)
                .then(function(response) {
                    return response.text()
                })
                .then(function(data) {
                    debugger
                    const x = document.getElementById(id);

                    x.remove()
                    //pop(data)
                })

        })
    }
</script>