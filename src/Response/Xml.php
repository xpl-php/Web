<?php

namespace xpl\Web\Response;

class Xml implements TypeInterface {
	
	public function getName() {
		return 'xml';
	}
	
	public function format($body) {
		
		if (is_object($body)) {
				
			if (method_exists($body, 'xmlSerialize')) {
				$body = $body->xmlSerialize();
			
			} else if (method_exists($body, 'toArray')) {
				$body = $body->toArray();
			
			} else {
				$body = get_object_vars($body);
			}
		
		} else if (is_scalar($body)) {
			$body = array('content' => $body);
		}
		
		return xml_write_document($body, 'XML');
	}
	
	public function getMimetype() {
		return 'text/xml';
	}
	
}
