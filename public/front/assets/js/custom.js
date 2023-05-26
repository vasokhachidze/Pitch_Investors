/* $(document).ready(function () {
  $(".business-for-sale-slider.owl-carousel").owlCarousel();

}); */
$("a.serch-btn-2").click(function () {
	$(".serch-bg").show(200);
	$("a.serch-btn-2").hide();
	$(".custom-nav-link-menu").hide();
});
$("a.serch-btn").click(function () {
	$("a.serch-btn-2").show(100);
	$(".serch-bg").hide();
	$(".custom-nav-link-menu").show(100);
});




// read-more ///
function myFunction() {
	var dots = document.getElementById("dots");
	var moreText = document.getElementById("more");
	var btnText = document.getElementById("myBtn");

	if (dots.style.display === "none") {
		dots.style.display = "inline";
		btnText.innerHTML = "Read more";
		moreText.style.display = "none";
	} else {
		dots.style.display = "none";
		btnText.innerHTML = "Read less";
		moreText.style.display = "inline";
	}
}




$(".banner-slider.owl-carousel").owlCarousel({
	loop: false,
	margin: 10,
	autoplay: false,
	responsiveClass: true,
	responsive: {
		0: {
			items: 1,
			nav: true,
		},
		600: {
			items: 1,
			nav: false,
		},
		1000: {
			items: 1,
			nav: true,
			loop: false,
		},
	},
});


$(".business-for-sale-slider.owl-carousel").owlCarousel({
	loop: true,
	margin: 10,
	autoplay: true,
	responsiveClass: true,
	responsive: {
		0: {
			items: 1,
			nav: true,
		},
		600: {
			items: 1,
			nav: false,
		},
		1000: {
			items: 1,
			nav: true,
			loop: false,
		},
	},
});

$(".testmonial-slider.owl-carousel").owlCarousel({
	loop: true,
	margin: 10,
	responsiveClass: true,
	responsive: {
		0: {
			items: 1,
			nav: true,
		},
		750: {
			items: 2,
			nav: false,
		},
		1000: {
			items: 3,
			nav: true,
			loop: false,
		},
	},
});


$(".about-us-slider.owl-carousel").owlCarousel({

	loop: true,
	margin: 10,
	responsiveClass: true,
	responsive: {
		0: {
			items: 1,
			nav: true,
			stagePadding: 0,
		},
		768: {
			items: 1,
			nav: true,
			stagePadding: 120,
		},
		992: {
			items: 2,
			nav: false,
			stagePadding: 160,
		},
		1099: {
			items: 2,
			nav: false,
			stagePadding: 200,
		},
		1399: {
			items: 2,
			nav: false,

			stagePadding: 270,
		},

	},
});

$(window).scroll(function () {
	if ($(this).scrollTop() > 10) {
		$('header').addClass('sticky')
	} else {
		$('header').removeClass('sticky')
	}
});

$(function () {
	AOS.init();
});
AOS.init({
	disable: function () {
		var maxWidth = 768;
		return window.innerWidth < maxWidth;
	}
});

$('document').ready(function () {
	$('button.navbar-toggle').click(function () {
		var navbar_obj = $($(this).data("target"));
		navbar_obj.toggleClass("open");
	});
});





window.onload = (event) => {
	initMultiselect();
};

function initMultiselect() {
	checkboxStatusChange();

	document.addEventListener("click", function (evt) {
		var flyoutElement = document.getElementById('myMultiselect'),
			targetElement = evt.target; // clicked element

		do {
			if (targetElement == flyoutElement) {
				// This is a click inside. Do nothing, just return.
				//console.log('click inside');
				return;
			}

			// Go up the DOM
			targetElement = targetElement.parentNode;
		} while (targetElement);

		// This is a click outside.
		toggleCheckboxArea(true);
		//console.log('click outside');
	});
}

function checkboxStatusChange() {
	/* var multiselect = document.getElementById("mySelectLabel");
	var multiselectOption = multiselect.getElementsByTagName('option')[0];
  
	var values = [];
	var checkboxes = document.getElementById("mySelectOptions");
	var checkedCheckboxes = checkboxes.querySelectorAll('input[type=checkbox]:checked');
  
	for (const item of checkedCheckboxes) {
	  var checkboxValue = item.getAttribute('value');
	  values.push(checkboxValue);
	}
  
	var dropdownValue = "R";
	if (values.length > 0) {
	  dropdownValue = values.join(', ');
	}
  
	multiselectOption.innerText = dropdownValue; */
}

function toggleCheckboxArea(onlyHide = false) {
	/* var checkboxes = document.getElementById("mySelectOptions");
	var displayValue = checkboxes.style.display;
  
	if (displayValue != "block") {
	  if (onlyHide == false) {
		checkboxes.style.display = "block";
	  }
	} else {
	  checkboxes.style.display = "none";
	} */
}


// //Get the button
// var mybutton = document.getElementById("myscrollbtn");

// // When the user scrolls down 20px from the top of the document, show the button
// window.onscroll = function () { scrollFunction() };

// function scrollFunction() {
// 	if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
// 		mybutton.style.display = "block";
// 	} else {
// 		mybutton.style.display = "none";
// 	}
// }

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
	document.body.scrollTop = 0;
	document.documentElement.scrollTop = 0;
}

// read-more read-less dynamic///
function read_more_less_text(dotsDiv,more,myBtn) {
	var dots = document.getElementById(dotsDiv);
	var moreText = document.getElementById(more);
	var btnText = document.getElementById(myBtn);

	if (dots.style.display === "none") {
		dots.style.display = "inline";
		btnText.innerHTML = "Read more";
		moreText.style.display = "none";
	} else {
		dots.style.display = "none";
		btnText.innerHTML = "Read less";
		moreText.style.display = "inline";
	}
}