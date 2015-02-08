<?php

namespace xpl\Web\Response;

use xpl\Dependency\DI;

class Json implements TypeInterface 
{
	
	/**
	 * Request parameter to designate a pretty-printed response.
	 * @var string
	 */
	const DEV_PARAM = 'dev';
	
	/**
	 * Whether the dev parameter is set.
	 * @var boolean
	 */
	protected $is_dev = false;
	
	/**
	 * Response mimetype.
	 * @var string
	 */
	protected $mimetype = 'application/json';
	
	public function __construct(DI $di) {
		$this->is_dev = $di['request']->hasParam(static::DEV_PARAM);
	}
	
	public function getName() {
		return 'json';
	}
	
	public function getMimetype() {
		return $this->mimetype;
	}
	
	public function format($body) {
		
		if (is_scalar($body)) {
			$body = array('content' => $body);
		
		} else if (is_object($body)) {
			
			if ($body instanceof \JsonSerializable) {
				$body = $body->jsonSerialize();
			} else {
				$body = method_exists($body, 'toArray') ? $body->toArray() : get_object_vars($body);
			}
		}
		
		$flags = JSON_NUMERIC_CHECK|JSON_FORCE_OBJECT;
		
		if ($this->is_dev) {
			$flags |= JSON_PRETTY_PRINT;
		}
		
		return json_encode($body, $flags);
	}
	
}
