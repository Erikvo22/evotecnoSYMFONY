//almacena slider en una variable
var slider = $('#slider');

//almacenar botones
var siguiente = $('#btn-next');
var anterior = $('#btn-prev');

//mover ultima imagen al primer lugar
$('#slider section:last').insertBefore('#slider section:first');


function moverD() {
	slider.animate({
	} ,700, function(){
		$('#slider section:first').insertAfter('#slider section:last');
	});
}

function moverI() {
	slider.animate({
	} ,700, function(){
		$('#slider section:last').insertBefore('#slider section:first');
	});
}


siguiente.on('click', function(){
	moverD();
});

anterior.on('click', function() {
	moverI();
});

function autoplay() {
	interval = setInterval(function(){
		moverD();
	}, 5000);
}

autoplay();