<?php

namespace xpl\Web\Response;

interface TypeInterface {
	
	/**
	 * Returns the response type's name for identification.
	 * 
	 * @return string
	 */
	public function getName();
	
	/**
	 * Formats the response body according to the type's format.
	 * 
	 * @param mixed $body Response body content.
	 * @return string Formatted body content.
	 */
	public function format($body);
	
	/**
	 * Returns the content-type MIME to send with responses of this type.
	 * 
	 * @return string
	 */
	public function getMimetype();
	
}
