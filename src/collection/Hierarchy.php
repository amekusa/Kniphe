<?php
namespace amekusa\Kniphe\collection;

use amekusa\Kniphe as Kn;

class Hierarchy extends Link {
	protected $parent; // <Linkable>
	protected $children = array ();
	protected $gen = 0;
	
	public function __construct(Linkable $xFrom) {
		parent::__construct($xFrom);
	}
	
	public function getParent() {
		return $this->parent;
	}
	
	public function getChildren() {
		return $this->children;
	}
	
	public function setParent(Linkable $xParent) {
		$this->parent = $xParent;
	}
	
	public function addChild(Linkable $xChild) {
		$this->children[] = $xChild;
	}
}

?>