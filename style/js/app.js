/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : app.js
  */

/**
 * Fonction qui update la balise ou j'affiche le temps
 * @param {*} val 
 */
function UpdateSlider(val) {
    var slider = document.getElementById('slider');
    var temps = document.getElementById('sec2');
    temps.innerHTML = val + " secondes";
}

/**
 * Fonction qui change le volume de l'audio player
 * @param {*} val 
 */
function UpdateVolume(val) {
    var audio = document.getElementById('player');
    audio.volume = val/100;
    console.log(audio.volume);
}

/**
 * Fonction qui passe à la prochaine musique
 */
function NextMusic() {
    document.getElementById('formGame').submit();
}