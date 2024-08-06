
const trailerButton = document.getElementById('trailerButton');
const trailerPopup = document.getElementById('trailerPopup');
const closePopup = document.getElementById('closePopup');
const trailerVideo = document.getElementById('trailerVideo');


trailerButton.addEventListener('click', function() {
    trailerPopup.style.display = 'block';
    trailerVideo.play();  
});


closePopup.addEventListener('click', function() {
    trailerPopup.style.display = 'none';
    trailerVideo.pause();
    trailerVideo.currentTime = 0; 
});


window.addEventListener('click', function(event) {
    if (event.target == trailerPopup) {
        trailerPopup.style.display = 'none';
        trailerVideo.pause();
        trailerVideo.currentTime = 0;
    }
});
