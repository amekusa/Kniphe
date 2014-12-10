<?php
namespace amekusa\Kniphe\collection;

abstract class Link {
	protected $to; // <Linkable>
	
	public function __construct(Linkable $xTo) {
		$this->to = $xTo;
	}
}