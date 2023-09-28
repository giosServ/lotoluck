// Inicio de función JS para Slider

//AUTO SLIDER

var sliderIndex = 0; 
var sliderImages = document.querySelectorAll('.slider-container a'); 
setInterval(function() { 
    sliderImages[sliderIndex].classList.remove('active'); 
    sliderIndex = (sliderIndex + 1) % sliderImages.length; 
    sliderImages[sliderIndex].classList.add('active');
 }, 5000);

 //BOTONES CONTROL DE IMG DEL SLIDER

 var prevButton = document.querySelector('.slider-prev'); 
 var nextButton = document.querySelector('.slider-next'); 
 
 prevButton.addEventListener('click', function() { 
     sliderImages[sliderIndex].classList.remove('active');
    sliderIndex = (sliderIndex - 1 + sliderImages.length) % sliderImages.length; 
    sliderImages[sliderIndex].classList.add('active'); }); 
    nextButton.addEventListener('click', function() { sliderImages[sliderIndex].classList.remove('active'); 
    sliderIndex = (sliderIndex + 1) % sliderImages.length; 
    sliderImages[sliderIndex].classList.add('active');
 });

 