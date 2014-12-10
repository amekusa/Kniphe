<?php
namespace amekusa\Kniphe\collection;

class Node {
	protected $port;
	
	public function __construct() {
		$this->port = new NodePort();
	}
}