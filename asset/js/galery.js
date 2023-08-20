
const loadingSpinner = document.getElementById('loading-spinner');

const imageContainer = document.getElementById('imageContainer');
// Avant d'envoyer la requête fetch
loadingSpinner.classList.remove('hidden'); // Affiche l'animation



const apiCall = (a) => {
  const api = `./apiPic.php?a=${a}`;
  fetch(api)
    .then(response => response.json())
    .then(data => {
      // Traitez les données reçues
      data.forEach(element => {
        console.log(element);

        const boxElement = document.createElement('div'); // Créer la div
        boxElement.className = 'box'; // Ajouter la classe

        const imageElement = document.createElement('img');
        imageElement.src = `${element.url_traitee}`;
        imageElement.className = 'img'; // Ajouter la classe à l'image
        // imageElement.id = `${element.id}`;
        imageElement.setAttribute('data', `${element.url_originale}`)

        const legend = document.createElement('div');
        legend.classList.add('legend');
        legend.innerText = element.date;

        const item = document.createElement('div');
        item.className = 'item';

        boxElement.appendChild(imageElement); // Ajouter l'image à la div
        // imageContainer.appendChild(boxElement); // Ajouter la div au conteneur
        boxElement.appendChild(legend);
        item.appendChild(boxElement);
        imageContainer.appendChild(item);

      });


      // Une fois le traitement terminé, masquez l'animation
      loadingSpinner.classList.add('hidden');






      full();


      const macy = Macy({
        container: '#imageContainer',
        trueOrder: false,
        waitForImages: false,
        margin: 5,
        columns: 5,
        breakAt: {
          1200: 4,
          940: 3,
          520: 3,
          450: 2
        },

      });
      macy;
      


    })



    .catch(error => {
      // Gérez les erreurs
      console.error('Une erreur s\'est produite :', error);
      loadingSpinner.classList.add('hidden'); // Assurez-vous de masquer l'animation en cas d'erreur également
    });

}


let a = 30;
// let a = document.documentElement.clientHeight;
// let b = document.documentElement.clientWidth;

// console.log((Math.trunc(a / b) + 1)*10);
// console.log(Math.sqrt((a*a) + (b*b),2));

apiCall(a);

window.addEventListener('scroll', () => {
  const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

  // console.log(scrollTop,scrollHeight,clientHeight);

  if (clientHeight + scrollTop >= scrollHeight - 70) {

    loadingSpinner.classList.remove('hidden');

    // console.log(a);
    apiCall(a);
  }
});




const full = () => {
  const img = document.querySelectorAll('.img');
  img.forEach((e) => {
    e.addEventListener('click', (e) => {
      const data = (e.target.attributes.data.value);
      


      const full = document.createElement('div');
      full.className = 'full';

      const imgFull = document.createElement('img');
      imgFull.src = `${data}`;

      full.appendChild(imgFull);

      document.body.appendChild(full);

      document.body.style.overflow = 'hidden';

      imgFull.addEventListener('click', () => {
        document.body.removeChild(full);
        document.body.style.removeProperty('overflow');


      })

    })
  })
}

const btnNav = document.getElementById('remove');


btnNav.addEventListener('click', () => {
  const nav = document.querySelector('aside .nav');
  nav.classList.toggle('navActive');
  
})

window.addEventListener('scroll', ()=>{
  btnNav.style.visibility = 'visible';
})

