<?php
namespace amekusa\Kniphe\collection;

class CompositeNode extends Node {
	
	public function isParentOf(CompositeNode $xNode) {
	}
	
	public function isChildOf(CompositeNode $xNode) {
	}
	
	public function hasParent() {
	}
	
	public function hasChildren() {
	}
	
	public function getParent() {
	}
	
	public function getChild($xIndex) {
	}
	
	protected function setParent(CompositeNode $xNewParent) {
	}
	
	public function addChild(CompositeNode $xNewChild, $xIndex = null, $xOverwrites = false) {
		if ($xNewChild->hasParent()) {
			if ($xNewChild->isChildOf($this)) throw new \RuntimeException("Child Duplication");
			else throw new \RuntimeException("Another Parent's Child");
		}
	}
}