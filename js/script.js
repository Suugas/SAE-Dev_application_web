const envoyer = document.getElementById('envoyer');
const zoneTexte = document.querySelector('.composer textarea');

// Envoie le texte de la zone de rédaction à publier.php au clic sur « Touiter »
envoyer.addEventListener('click', async () => {
    const texte = zoneTexte.value.trim();

    if (texte === '') {
        return;
    }

    const donnees = new FormData();
    donnees.append('message', texte);

    const reponse = await fetch('publier.php', { method: 'POST', body: donnees });
    const resultat = await reponse.json();

    if (resultat.succes) {
        zoneTexte.value = '';
    } else {
        console.log(resultat.erreur);
    }
});
