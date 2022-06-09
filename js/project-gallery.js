jQuery(function($) {
		var selectedClass = "";
		$(".fil-cat").click(function(){
		selectedClass = $(this).attr("data-rel");

     $(".articles").fadeTo(100, 0.1);
		$(".articles article").not("."+selectedClass).fadeOut().removeClass('scale-anm');
    setTimeout(function() {
      $("."+selectedClass).fadeIn().addClass('scale-anm');
      $(".articles").fadeTo(300, 1);
    }, 300);

	});
});
