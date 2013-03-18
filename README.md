# Notify Keyword Behavior for CakePHP #

Notify admin by email each time a field contain selected keyword

## Installation

1. Copy NotifyKeywordBehavior.php to /Model/Behavior/ folder

2. Add the following code to your model

	public $actsAs = array(
		'NotifyKeyword' => array(
			'emailTo' => 'zhaff@yahoo.com',
			'keyword' => 'bomb'
		)
	);
	
3. Change emailTo and keyword to your own needs.