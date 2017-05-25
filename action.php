<?php
require('includes/form.class.php');

// setup validator
// maps form inputs to validation type
// instructions listed in form.class.php, chk options in form.vars.php
$var_array = array(
	'fullname' => array('req' => true, 'chk' => 'name'),
	'nickname' => array('req' => false, 'chk' => 'name'),
	'email' => array('req' => true, 'chk' => 'email'),
	'custom' => array('req' => true, 'exp' => "/^(John)$/"),
	'options' => array('req' => true, 'chk' => 'alpha'),
	'details' => array('req' => false, 'chk' => 'extended'),
	'message' => array('req' => true, 'chk' => false),
	'activate' => array('req' => false, 'box' => true),
	'color' => array('req' => true, 'chk' => 'alpha'),
	'gcb_optionOne' => array('req' => false, 'box' => true),
	'gcb_optionTwo' => array('req' => false, 'box' => true),
	'gcb_optionThree' => array('req' => false, 'box' => true),
	'gcb_notlisted' => array('req' => false, 'box' => true),
	'more_info' => array('req' => false, 'chk' => 'extended'),
	'terms' => array('req' => true, 'box' => true)
);

// default variables
$action = 0; // error
$message = 'Please correct and resubmit';

// execute validator
$form = new form($var_array,$_POST);

// update db if no errors
if(!$form->e){
	// access validated data using $form->f[]
	// ex $form->f['fullname'];

	// write to database or send email, etc.
	// IMPORTANT: data is validated, but NOT escaped.

	$message = 'Form submitted, thank you!';

	// clear form
	$action = 2; // action 2 clears form, action 1 keeps form data
}

// return results
echo '['.$action.',"'.$message.'",'.$form->error_list().']';
?>
