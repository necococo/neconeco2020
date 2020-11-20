
<<<<<<< HEAD
// Get the container element
var btns = document.getElementById("btns");
console.log(btns);
var dropDown1 =  document.getElementById("dropdown1");
console.log(dropDown1);
dropDown1.addEventListener("click", function() {
    var activated = btns.getElementsByClassName("activated");
    console.log(activated.length);
    activated[0].classList.remove("activated");
=======
$(function () {
    // Remove Search if user Resets Form or hits Escape!
	$('body, .navbar-collapse form[role="search"] button[type="reset"]').on('click keyup', function(event) {
		console.log(event.currentTarget);
		if (event.which == 27 && $('.navbar-collapse form[role="search"]').hasClass('active') ||
			$(event.currentTarget).attr('type') == 'reset') {
			closeSearch();
		}
	});

	function closeSearch() {
        var $form = $('.navbar-collapse form[role="search"].active')
		$form.find('input').val('');
		$form.removeClass('active');
	}

	// Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
	$(document).on('click', '.navbar-collapse form[role="search"]:not(.active) button[type="submit"]', function(event) {
		event.preventDefault();
		var $form = $(this).closest('form'),
			$input = $form.find('input');
		$form.addClass('active');
		$input.focus();

	});
	// ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
	// if your form is ajax remember to call `closeSearch()` to close the search container
// 	$(document).on('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function(event) {
// 		event.preventDefault();
// 		var $form = $(this).closest('form'),
// 			$input = $form.find('input');
// 		$('#showSearchTerm').text($input.val());
//         closeSearch()
// 	});
>>>>>>> 47387a204ebce36358decc699d662246e8e0b4b4
});
   