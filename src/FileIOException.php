<?php
namespace amekusa\Kniphe;

class FileIOException extends IOException {
	
	protected function _closeStream() {
		return fclose($this->stream);
	}
}
?>