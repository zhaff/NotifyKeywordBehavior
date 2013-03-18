<?php

/**
 * Notify Keyword behavior
 *
 * PHP 5
 *
 * @copyright     Copyright 2013, neptuneScripts.com. (http://www.neptunescripts.com)
 * @author        Zharfan Mazli <zhaff@neptunescripts.com>
 */
class NotifyKeywordBehavior extends ModelBehavior {

	/**
	 * Default options for bare behavior usage
	 * 
	 * @var array 
	 */
	public $defaultOptions = array(
		'emailTo' => 'zhaff@yahoo.com',
		'keyword' => 'bomb'
	);

	/**
	 * This is where all runtime options are stored after being merged with defaults
	 * 
	 * @var array
	 * @access private 
	 */
	private $_options;

	/**
	 * Initiate behavior for the model using specified settings.
	 *
	 * 	You can pass options as per above.
	 * 
	 * @param Model $Model Model using the behavior
	 * @param array $options Options to override for model.
	 * @return void
	 */
	public function setup($Model, $options = array()) {
		if (!isset($this->_options[$Model->alias])) {
			$this->_options[$Model->alias] = $this->defaultOptions;
		}
		if (!is_array($options)) {
			$options = array();
		}
		$this->_options[$Model->alias] = array_merge($this->_options[$Model->alias], $options);
	}

	/**
	 * Before save method. Called before all saves
	 *
	 * Overriden to transparently check for fields that have contain defined keyword
	 * 
	 * @param Model $model
	 * @return bool
	 */
	public function beforeSave($Model) {

		$options = $this->_options[$Model->alias];

		$data = $Model->data[$Model->alias];

		foreach ($data as $field => $value) {

			$pos = strpos($value, $options['keyword']);

			if ($pos !== false) {

				$email = new CakeEmail();

				// load config
				$email->config('default');

				$emailTo = $options['emailTo'];

				// notify user 
				$email->subject('Keyword bomb detected')
						->emailFormat('html')
						->to($emailTo)
						->send('Keyword bomb detected in field ' . $field);
			}
		}

		return true;
	}

}