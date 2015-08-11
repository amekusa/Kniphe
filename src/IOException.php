<?php namespace amekusa\Kniphe;

abstract class IOException extends \RuntimeException {
	public $stream = null;
	
	public final function closeStream() {
		if (is_null($this->stream)) return;
		return $this->_closeStream();
	}
	
	protected abstract function _closeStream();
}
