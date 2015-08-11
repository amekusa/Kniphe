<?php namespace amekusa\Kniphe\web;

use amekusa\Kniphe as Kn;

/**
 * Functions :: Web :: Kniphe
 * @version 2014-01-14
 */

function current_url($xWithoutQueryString = false) {
	$uri = $_SERVER['REQUEST_URI'];
	if (!$xWithoutQueryString) return $uri;
	
	$x = strrpos($uri, '?');
	if ($x === false) return $uri;
	return substr($uri, 0, $x);
}

function current_protocol() {
	return strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos(
			$_SERVER["SERVER_PROTOCOL"], '/'))).'://';
}

/**
 * TODO
 * @param unknown $xUrl
 * @return unknown
 */
function abs_url($xUrl) {
	if (preg_match('/^([a-z]+:)?\/{2}[^\/].*/i', $xUrl)) return $xUrl;
	if (preg_match('/^\/[^\/].*/i', $xUrl)) {
		
	}
}

function dom_str($xName, $xAttributes) {
}

function parse_access_log_line($xTarget) {
	$r = array();
	$matches = array();
	$pattern = '/^([^ ]+) ([^ ]+) ([^ ]+) (\[[^\]]+\]) "(.*) (.*) (.*)" ([0-9\-]+) ([0-9\-]+) "(.*)" "(.*)"$/';
	preg_match($pattern, $xTarget, $matches);
	
	$r['ALL'] = enter_array($matches, 0);
	$r['REMOTE_HOST'] = enter_array($matches, 1);
	$r['LOG_NAME'] = enter_array($matches, 2);
	$r['USER'] = enter_array($matches, 3);
	$r['TIME'] = enter_array($matches, 4);
	$r['METHOD'] = enter_array($matches, 5);
	$r['REQUEST'] = enter_array($matches, 6);
	$r['PROTOCOL'] = enter_array($matches, 7);
	$r['STATUS'] = enter_array($matches, 8);
	$r['BYTES'] = enter_array($matches, 9);
	$r['REFERER'] = enter_array($matches, 10);
	$r['USER_AGENT'] = enter_array($matches, 11);
	
	return $r;
}

/**
 * パスから絶対URLを作成
 *
 * @param string $path パス
 * @param int $default_port デフォルトのポート（そのポートである場合にはURLに含めない）
 * @return string URL
 * 
 * @link http://www.programming-magic.com/20080628015044/
 */
function path_to_url($path, $default_port = 80){
	//ドキュメントルートのパスとURLの作成
	$document_root_url = $_SERVER['SCRIPT_NAME'];
	$document_root_path = $_SERVER['SCRIPT_FILENAME'];
	while(basename($document_root_url) === basename($document_root_path)){
		$document_root_url = dirname($document_root_url);
		$document_root_path = dirname($document_root_path);
	}
	if($document_root_path === '/')  $document_root_path = '';
	if($document_root_url === '/') $document_root_url = '';

	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] !== 'off')? 'https': 'http';
	$port = ($_SERVER['SERVER_PORT'] && $_SERVER['SERVER_PORT'] != $default_port)? ':'.$_SERVER['SERVER_PORT']: '';
	$document_root_url = $protocol.'://'.$_SERVER['SERVER_NAME'].$port.$document_root_url;

	//絶対パスの取得 (realpath関数ではファイルが存在しない場合や、シンボリックリンクである場合にうまくいかない)
	$absolute_path = realpath($path);
	if(!$absolute_path)
		return false;
	if(substr($absolute_path, -1) !== '/' && substr($path, -1) === '/')
		$absolute_path .= '/';

	//パスを置換して返す
	$url = str_replace($document_root_path, $document_root_url, $absolute_path);
	if($absolute_path === $url)
		return false;
	return $url;
}

function session_started() {
	return !session_id();
}
