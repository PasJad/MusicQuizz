function UpdateSlider(val) {
    var slider = document.getElementById('slider');
    var temps = document.getElementById('sec2');
    temps.innerHTML = val + " secondes";
}

function UpdateVolume(val) {
    var audio = document.getElementById('player');
    audio.volume = val/100;
    console.log(audio.volume);
}

function NextMusic() {
    document.getElementById('formGame').submit();
}