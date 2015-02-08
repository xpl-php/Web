<?php

namespace xpl\Web;

class Response extends \xpl\Http\Response 
{
	protected $request_mimetype;
	protected $type;
	
	/**
	 * Construct response.
	 */
	public function __construct(Request $request) {
		$this->send_body = ! $request->is('HEAD');
		$this->request_mimetype = $request->getMimetype();
	}
	
	public function getRequestMimetype() {
		return $this->request_mimetype;
	}
	
	public function setType(Response\TypeInterface $type) {
		$this->type = $type;
		return $this;
	}
	
	public function getType($rtn_object = false) {
		
		if (! isset($this->type)) {
			return null;
		}
		
		return $rtn_object ? $this->type : $this->type->getName();
	}
	
	public function getTypeObject() {
		return isset($this->type) ? $this->type : null;
	}
	
	public function send($exit = true) {
		
		if ($this->send_body) {
			
			if (! isset($this->type)) {
				$this->type = new Response\Html();
			}
			
			$raw_body = $this->getBody();
			$formatted = $this->type->format($raw_body);
			
			$this->setBody($formatted);
			
			$this->setContentType($this->type->getMimetype());
		}
		
		parent::send($exit);
	}

}
