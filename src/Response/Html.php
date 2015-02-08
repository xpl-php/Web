<?php

namespace xpl\Web\Response;

class Html implements TypeInterface 
{
	
	public function getName() {
		return 'html';
	}
	
	public function getMimetype() {
		return 'text/html';
	}
	
	public function format($body) {
		
		if (empty($body)) {
			return '';
		}
		
		if (is_callable($body)) {
			$body = call_user_func($body);
		}
		
		if (is_scalar($body) || method_exists($body, '__toString')) {
			return (string)$body;
		}
		
		xpl_log("Response format error: ".__CLASS__.' in '.__FILE__);
		
		throw new \InvalidArgumentException("HTML response body must be string(able), given: ".gettype($body));
	}
	
}
