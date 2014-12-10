<?php
namespace amekusa\Kniphe;

class FtpIOException extends IOException {
	
	protected function _closeStream() {
		return ftp_close($this->stream);
	}
}
?>