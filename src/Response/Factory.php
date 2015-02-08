<?php

namespace xpl\Web\Response;

class Factory 
{
	
	protected $classes;
	
	public function __construct(array $class_map = array()) {
		
		$defaults = array(
			'html' => __NAMESPACE__.'\\Html',
			'json' => __NAMESPACE__.'\\Json',
			'jsonp' => __NAMESPACE__.'\\Jsonp',
			'xml' => __NAMESPACE__.'\\Xml',
			'api' => 'xpl\\Api\\Response\\Type',
		);
		
		$this->classes = array_replace($defaults, $class_map);
	}
	
	public function getTypeClass($type) {
		return isset($this->classes[$type]) ? $this->classes[$type] : null;
	}
	
	public function setTypeClass($type, $class) {
		$this->classes[$type] = $class;
	}
	
	public function hasTypeClass($type) {
		return isset($this->classes[$type]);
	}
	
	public function __invoke($type) {
		
		$class = $this->getTypeClass($type);
		
		if (! $class) {
			throw new \InvalidArgumentException("No class found for type: '$type'.");
		}
		
		return new $class();
	}
	
}
