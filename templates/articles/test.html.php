<nav>
    <div id="filtre">

        <!-- &darr;   fleche bas -->
        <!-- &uarr;   fleche haut -->
        <button class="filtre" data-id="dateUp">Date <span>&uarr;</span></button>

        <?php foreach ($themes as $theme) {
        ?>
            <button class="filtre" data-id="<?= $theme['idCategorie'] ?>"><?= $theme['theme'] ?></button>
        <?php } ?>

    </div>
</nav>


<section class="index">

    <article>
        <img id="fichier" src="" alt="">
        <div>
            <h3></h3>
            <p id="up"></p>
            <p id="down"></p>
        </div>
    </article>

</section>

<script>
    let pokemonListe = []
    async function showPokemon(params) {

        const URL = "index.php?controller=article&task=test";


        const reponse = await fetch(URL)
        const data = await reponse.json()

        pokemons = data.results;
        pokemonListe = pokemons;



        for (const pokemon of pokemons) {
            console.log(pokemon.url);


            const reponsePokemon = await fetch(pokemon.url)
            const dataPokemon = await reponsePokemon.json()

            // .then(reponse => reponse.json())
            // .then(dataPokemon => {
            console.log(dataPokemon)
            // ===============
            // const type = dataPokemon.types .0.type.name
            // ===============
            const name = dataPokemon.name
            const imgUrl = dataPokemon.sprites.front_default
            const carte = document.createElement('div')
            const img = document.createElement('img')
            const p = document.createElement('h2')

            img.src = imgUrl
            p.textContent = name

            carte.appendChild(img)
            carte.appendChild(p)
            main.appendChild(carte)


        }

        //}
    }


    const recherche = async (event) => {
        event.preventDefault()
        search = document.getElementById("send1").value
        let result = pokemonListe.filter((value, index, array) => {
            return value.name == search
        })
        console.log(result);
        return result || []
    }
    document.getElementById("recherche").addEventListener('click', recherche);

    showPokemon()
</script>