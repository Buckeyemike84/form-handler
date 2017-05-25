<?php
/************************************************************************

	Form Validation Functions v.3.2 (To be included in form.class.php)
	Rev. Sept 10, 2016

	Created by John Maddox

	PCRE (Perl Compatible Regular Expressions)

	This is a collection of common validation expressions designed for form.class.php

	alpha - Letters only. Spaces okay.
	numeric - Numbers only. No spaces.
	name - Letters, dashes, periods. Spaces okay.
	extended - Letters, numbers, spaces, &amp; these symbols ! # $ ? ( ) . , - ' : +
	login - Letters, numbers, dashes, underscores, ampersand, &amp; periods.
	fileName - Letters, numbers, dashes, underscores, &amp; periods.
	address - Ex. 111 John Ct #12
	state - Two character abbreviation. Ex. CA
	zip - 5 digits zip code
	phone - ex. 888.888.8888 x88
	email - Ex. name@<?php echo SITE_URL; ?>
	pass - 6-25 Chars. Letters, numbers, symbols ~!@#$%^&*+`=|:";'?,./\
	url - Ex. http://<?php echo SITE_URL; ?>
	dynamicUrl - Letters, numbers, &amp; dashes. Lower Case. Ex. your-company
	dollar - Ex. 115.00
	date - Ex. YYYY-MM-DD
	time - Ex. HH:MM (24 hr Clock)

**************************************************************************/

$exp_array = array(
	'alpha' =>
		"/^[a-z ]+$/i",
	'numeric' =>
		"/^[0-9]+$/",
	'name' =>
		"/^[a-z.\- ]+$/i",
	'extended' =>
		"/^[[:alnum:]!#$?().,\-':+ ]+$/i",
	'login' =>
		"/^[[:alnum:]\-_.@]+$/i",
	'fileName' =>
		"/^[[:alnum:]\-_.]+$/i",
	'address' =>
		"/^[[:alnum:]\-.'# ]+$/i",
	'state' =>
		"/^[a-z]{2}$/i",
	'zip' =>
		"/^[0-9]{5}$/i",
	'phone' =>
		"/^(\()?[0-9]{3}(\))?[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}( [ext. ]+[0-9]{1,5})?$/i",
	'email' =>
		"/^[[:alnum:]_.-]+@[[:alnum:].-]+\.[a-z]{2,4}$/i",
	'pass' =>
		"/^[[:alnum:]~!@#$%^&*+`=|:\";'?,.\/\\\\]{6,}$/i",
	'url' =>
		"/^http(s)?:\/\/[[:alnum:]._\-]+\.[a-z]{1,5}[[:alnum:]\/=._\-?]*$/i",
	'dynamicUrl' =>
		"/^[a-z\-]+$/",
	'dollar' =>
		"/^[0-9]+\.[0-9]{2}$/",
	'date' =>
		"/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/",
	'time' =>
		"/^[0-9]{2}(:)?[0-9]{2}$/"
);
?>
