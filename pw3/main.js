
$(document).ready(function(){
	$('input').keypress(function(event){
		if(event.which === 13){
			var todoText = $(this).val();
			$(this).val("");
			$('ul').append('<li>' + todoText);
		}
	});



	$('ul').on('click', "span" , function(event){
		$(this).parent().fadeOut(500,function(){
			$(this).remove();
		});
		event.stopPropagation();
	});

	$('ul').on('click','li', function(){
        $(this).toggleClass('strike');    
      });

	$('ul').on('mouseenter', 'li', function(){
		$(this).append('<span class= "ic"><i class="fa fa-trash" style="font-size:25px"</i></span>');
	});

	$('h1').on('click', "span1" , function(event){
		$("input").slideToggle();
	});

	$("ul").on('mouseleave', 'li', function(){
		$(".ic").remove();
   
  	});
});