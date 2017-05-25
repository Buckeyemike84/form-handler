<?php
/************************************************************************

	AJAX Form Processor Class v.3.2 (extends htmlpurifier)
	Rev. Sept. 10, 2016

	Created by John Maddox

	Requires $_POST and an array of variables:

	$var_array = array(
		'name' => array('req' => true, 'chk' => 'alpha'),
		'optional' => array('req' => false, 'chk' => 'alpha'),
		'custom' => array('req' => true, 'exp' => "/^(John)$/"),
		'option_list' => array('req' => true, 'chk' => 'numeric'),
		'textarea' => array('req' => true, 'chk' => false),
		'checkbox' => array('req' => false, 'box' => true),
		'tos' => array('req' => true, 'box' => true),
		'radio' => array('req' => true, 'chk' => 'alpha')
	);

	req : required (true/false)
	chk : targets pre-defined expressions in form.vars.php, if false will execute htmlpurifier
	exp : allows custom expression, use instead of chk
	box : defines behavior for checkboxes (returns 1 on true, 0 on false)

	Public Attributes:

		- $id - if 'id' is found in _POST, this will isolate it for updating purposess
		- $f - array of purified form variables (not escaped)
		- $e - array of input names that threw errors

	Public Functions:

		- construct() - validates all data, builds $id, $f, & $e
		- error_list() - converts error array to json for callback

**************************************************************************/

// stop if ajax variable is not present
if(!isset($_POST['ajax'])){
	echo '<h1>The form you submitted requires javascript.</h1>';
	echo '<p>Please enable javascript and try again.</p>';
	trigger_error('Ajax $_POST variable is not set.');
	exit();
}

// this class uses htmlpurifier on all non-validated variables.
// http://htmlpurifier.org/
require('htmlpurifier/library/HTMLPurifier.auto.php');

class form extends HTMLPurifier {

	public $id;
	public $f = array();
	public $e = array();

	# Construct() - Sets initial vars
	public function __construct($var_array,$post_array){

		parent::__construct();

		// $exp_array()
		require('form.vars.php');

		// get id
		if(isset($post_array['id']) && is_numeric($post_array['id'])){ // set id if found
			$this->id = $post_array['id'];
		}

		// cycle through var_array, check each post variable
		foreach($var_array as $k => $v){

			$this->f[$k] = '';

			if($v['req'] && (!isset($post_array[$k]) || $post_array[$k] == '')){ // check for required empty values
				$this->e[$k] = 'Required.';

			}else if(isset($v['box'])){ // process checkboxes
				$this->f[$k] = (isset($post_array[$k])) ? 1 : 0;

			}else if($post_array[$k] != ''){ // set validation type

				if(isset($v['exp'])){
					$exp = $v['exp'];
				}else if($v['chk'] === false){
					$exp = false;
				}else if(isset($v['chk'])){
					$exp = $exp_array[$v['chk']];
				}else{
					trigger_error('Invalid form array - $exp_array missing key ('.$v['chk'].')');
				}

				// validate
				if($data = $this->validate($post_array[$k],$exp)){
					$this->f[$k] = $data;
				}else{
					$this->e[$k] = 'Invalid.';
				}

			} // eof empty check
		} // eof foreach
	} // eof construct

	# error_list() - convert error array to js format
	public function error_list(){

		$return = '[';

		if($this->e){
			$x=0;
			foreach($this->e as $name => $r){
				if($x){
					$return .= ',';
				}
				$return .= '["'.$name.'","'.$r.'"]';
				$x=1;
			}
		}
		$return .= ']';
		return $return;
	}

	# validate() - returns T or F on validated data
	private function validate($data,$exp){

		$return=false;
		$data = trim($data);

		if($exp === false){
			// IMPORTANT: runs unvalidated data through htmlpurifier
			$return = $this->purify($data);
		}else if($exp && preg_match($exp,$data)){
			$return = $data;
		}

		return $return;
	}
}
?>
