function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

let img = document.getElementById('danceimage');

let random = randomIntFromInterval(1, 5);

img.setAttribute('src', 'img/dance' + random + '.gif')

img.style.marginLeft = '5px';