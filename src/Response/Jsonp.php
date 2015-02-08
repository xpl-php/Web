<?php

namespace xpl\Web\Response;

use xpl\Dependency\DI;

class Jsonp extends Json
{
	
	/**
	 * Request parameter that sets the JSONP callback.
	 * @var string
	 */
	const CALLBACK_PARAM = 'callback';	
	
	/**
	 * JSONP callback function given in request parameter.
	 * @var string
	 */
	protected $callback;
	
	public function __construct(DI $di) {
		
		if ($di['request']->hasParam(static::CALLBACK_PARAM)) {
			
			$callback = $di['request']->getParam(static::CALLBACK_PARAM);
			
			$this->callback = filter_var($callback, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH|FILTER_FLAG_STRIP_BACKTICK);
		}
		
		parent::__construct($di);
	}
	
	public function getName() {
		return 'jsonp';
	}
	
	public function format($body) {
		
		if (empty($this->callback)) {
			return parent::format($body);
		}
		
		$this->mimetype = 'text/javascript';
		
		if (is_scalar($body)) {
			$body = array('content' => $body);
		
		} else if (is_object($body)) {
			
			if ($body instanceof \JsonSerializable) {
				$body = $body->jsonSerialize();
			} else {
				$body = method_exists($body, 'toArray') ? $body->toArray() : get_object_vars($body);
			}
		}
		
		return $this->callback.'('.json_encode($body, JSON_NUMERIC_CHECK).')';
	}
	
}
