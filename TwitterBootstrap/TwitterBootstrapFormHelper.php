<?php
App::uses('FormHelper', 'View/Helper');

/**
 * Twitter Bootstrap Form Helper
 *
 * @package Mirux
 * @subpackage Mirux.View.Helper
 * @version 1.0
 * @author Renato Moya (http://www.renatomoya.cl)
 */
class TwitterBootstrapFormHelper extends FormHelper {

	/**
	 * Default options for Twitter Bootstrap inputs
	 *
	 * @var array
	 */
	private $inputOptions = array(
		'label' => null,
		'error' => array(
			'wrap' => 'span',
			'class' => 'help-block',
		),
		'class' => 'xlarge',
		'div' => false,
	);

	/**
	 * Override default input with Twitter Bootstrap options
	 *
	 * @param string $fieldName Field name
	 * @param array $options Option array
	 * @return string
	 * @author Renato Moya (http://www.renatomoya.cl)
	 */
	public function input($fieldName, $options = array()) {
		$options = array_merge($this->inputOptions, $options);
		$error = null;

		if ($options['error'] !== false) {
			$error = $this->error($fieldName, null, $options['error']);
		}

		$options['error'] = false;

		$result = parent::input($fieldName, array_merge($options, array('label' => false)));
		$result .= $error;
		$result = $this->Html->tag('div', $result, array('class' => 'input'));

		if ($options['label'] !== false) {
			$result = $this->label($options['label']) . $result;
		}

		$class = 'clearfix';

		if (!empty($error)) {
			$class .= ' error';
		}

		return $this->Html->tag('div', $result, array('class' => $class));
	}

	/**
	 * InlineInputs with Twitter Bootstrap options
	 *
	 * @param array $fields the fieldName as key and value as options of the field.
	 * @param array $options General options array.
	 * @return string
	 * @author Renato Moya (http://www.renatomoya.cl)
	 */
	public function inlineInputs($fields, $options = array()) {
		$defaults = array('inputs-separator' => ' ');
		$defaults = $options + $defaults;
		$inputs = array();
		$fieldsName = array();
		$errors = array();

		foreach ($fields as $fieldName => $options) {
			$options = array_merge($this->inputOptions, $options);
			$fieldsName[] = $fieldName;

			//if ($options['error'] !== false) {
			if (!empty($options['error'])) {
				$errors[] = $this->error($fieldName, null, $options['error']);
			}

			$options['error'] = false;

			$input = parent::input($fieldName, array_merge($options, array('label' => false)));

			$inputs[] = $input;
		}

		$result = $this->Html->tag('div', join($defaults['inputs-separator'], $inputs), array('class' => 'inline-inputs'));

		if (!empty($defaults['help-block']) && empty($errors[0])) {
			$result .= $this->Html->tag('span', $defaults['help-block'], array('class' => 'help-block'));
		}
		
		// Just show the first error.
		if (!empty($errors)) {
			$result .= $errors[0];
		}

		$result = $this->Html->tag('div', $result, array('class' => 'input'));

		if ($defaults['label'] !== false) {
			$result = $this->label(array_shift($fieldsName), $defaults['label']) . $result;
		}

		$class = 'clearfix';

		if (!empty($errors[0])) {
			$class .= ' error';
		}

		return $this->Html->tag('div', $result, array('class' => $class));
	}
}
