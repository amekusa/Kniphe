<?php
namespace amekusa\Kniphe;

/**
 * Functions
 * 
 * @author amekusa <post@amekusa.com>
 */
interface functions {
	const required = true;
}

/**
 * <p lang="ja">
 * 任意の PHP ディレクティブが任意の値になっているかを確認します。
 * 任意の値になっていない、あるいは null なら、ini_set() 関数で値を変更します。
 * 変更に失敗した場合はエラーを発生させます。
 * </p>
 * 
 * @param string $xName The name of PHP directive
 * @param mixed $xValue The value of PHP directive
 */
function verify_ini($xName, $xValue) {
	$x = init_get($xName);
	if ($x === false) new Exception('No such PHP directive: "' . $xName . '".');
	if ($x !== '' && $x === $xValue) return;
	if (ini_set($xName, $xValue) === false) new Exception('The value of the PHP directive: "' . $xName . '" must be "' . $xValue . '". The actual value is "' . ini_get($xName) . '".');
}

/**
 * <p lang="ja">指定された値の型を文字列として返します。値がオブジェクトの場合はそのクラス名を返します。</p>
 * 
 * @param mixed $xValue
 * @return string
 */
function type($xValue) {
	if (is_object($xValue)) return get_class($xValue);
	if (is_bool($xValue)) return 'boolean';
	if (is_int($xValue)) return 'integer';
	if (is_float($xValue)) return 'float';
	if (is_string($xValue)) return 'string';
	if (is_array($xValue)) return 'array';
	if (is_resource($xValue)) return 'resource';
	return gettype($xValue);
}

/**
 * Returns whether the type of $xValue matches $xType or not.
 * <p lang="ja">
 * $xValue の型が $xType とマッチするか否かを判定します。
 * $xType がクラス名なら、$xValue instanceof $xType の比較結果を返します。
 * </p>
 * 
 * @param unknown $xValue
 * @param unknown $xType
 * @return boolean
 */
function type_matches($xValue, $xType) {
	if ($xType === 'bool' || $xType === 'boolean') return is_bool($xValue);
	if ($xType === 'int' || $xType === 'integer') return is_int($xValue);
	if ($xType === 'float') return is_float($xValue);
	if ($xType === 'string') return is_string($xValue);
	if ($xType === 'array') return is_array($xValue);
	if ($xType === 'object') return is_object($xValue);
	if ($xType === 'resource') return is_resource($xValue);
	
	if ($xType === 'mixed') return true;
	if ($xType === 'numeric') return is_numeric($xValue);
	if ($xType === 'callable') return is_callable($xValue);
	if ($xType === 'scalar') return is_scalar($xValue);
	if ($xType === 'vector') return !is_scalar($xValue);
	
	if ($xType === 'long') return is_long($xValue);
	if ($xType === 'double') return is_double($xValue);
	if ($xType === 'real') return is_real($xValue);
	
	if (class_exists($xType)) return $xValue instanceof $xType;
	
	return $xType === gettype($xValue);
}

function is_array_like($xValue) {
	if (is_array($xValue)) return true;
	if (is_object($xValue)) {
		if ($xValue instanceof \ArrayAccess) return true;
	}
	return false;
}

function is_iterable($xValue) {
	if (is_array($xValue)) return true;
	if (is_object($xValue)) {
		if ($xValue instanceof \Traversable) return true;
	}
	return false;
}

function bool($xValue) {
	if (is_bool($xValue)) return $xValue;
	if (is_string($xValue)) return strings_are_equal($xValue, 'true', true);
	return (bool) $xValue;
}

function boolean($xValue) {
	return bool($xValue);
}

function int($xValue) {
	if (is_int($xValue)) return $xValue;
	return (int) $xValue;
}

function integer($xValue) {
	return int($xValue);
}

function str($xValue) {
	if (is_string($xValue)) return $xValue;
	if (is_array($xValue)) return '';
	
	if (is_object($xValue)) {
		if (!is_callable(array ($xValue, '__toString'))) return '';
	}
	
	return (string) $xValue;
}

function string($xValue) {
	return str($xValue);
}

function null_safe($xVar, $xAltValue) {
	return isset($xVar) ? $xVar : $xAltValue;
}

function empty_safe($xVar, $xAltValue) {
	return empty($xVar) ? $xAltValue : $xVar;
}

/**
 *
 * @param string $xConstant
 * @param mixed $xAltValue
 * @param bool $xDefines
 * @return mixed
 */
function undfn_safe($xConstant, $xAltValue = null, $xDefines = false) {
	if (defined($xConstant)) return constant($xConstant);
	if ($xDefines) define($xConstant, $xAltValue);
	return $xAltValue;
}

/**
 * Alias of {@link undfn_safe()}
 */
function undefined_safe($xConstant, $xAltValue = null, $xDefines = false) {
	return undfn_safe($xConstant, $xAltValue, $xDefines);
}

/**
 * If the array:$xArray has the key:$xKey, $xArray[$xKey] is returned.
 * Otherwise $xAltValue is returned.
 * <p lang="ja">
 * 配列:$xArray がキー:$xKey を保持している場合はそのキーに対応する値を返します。
 * 保持していない場合は $xAltValue を返します。
 * </p>
 * 
 * @param mixed[] $xArray
 * @param integer|string $xKey
 * @param mixed $xAltValue
 * @return see the description
 */
function enter_array(&$xArray, $xKey, $xAltValue = null) {
	if (empty($xArray)) return $xAltValue;
	return array_key_exists($xKey, $xArray) ? $xArray[$xKey] : $xAltValue;
}

function arrays_are_equal(array $xArrayX, array $xArrayY) {
	foreach ($xArrayX as $nKey => $n) {
		foreach ($xArrayY as $mKey => $m) {
			if ($mKey !== $nKey) return false;
			if ((is_array($m) && is_array($n)) && !arrays_are_equal($m, $n)) return false;
			if ($m !== $n) return false;
		}
	}
	return true;
}

/**
 * #UNTESTED
 * 
 * @param mixed $xArgs
 * @return array
 */
function flat_array($xArgs) {
	$r = array ();
	
	$args = (func_num_args() > 1) ? func_get_args() : (is_array($xArgs)) ? $xArgs : array (
			$xArgs);
	
	foreach ($args as $iArg) {
		if (is_array($iArg)) $r = array_merge($r, flat_array($iArg));
		else $r[] = $iArg;
	}
	
	return $r;
}

function array_about($xField, $xArray) {
	$r = array ();
	foreach ($xArray as $iElm) {
		$r[] = get($xField, $iElm);
	}
	return $r;
}

function get($xName, $xFrom, $xAltValue = null) {
	if (is_object($xFrom)) {
		$x = array ($xFrom, 'get' . ucfirst($xName));
		if (is_callable($x)) return call_user_func($x);
		else $vars = get_object_vars($xFrom);
	
	} else if (is_array_like($xFrom)) $vars = $xFrom;
	else return $xAltValue;
	
	return enter_array($vars, $xName, $xAltValue);
}

function string_is_mb($xString) {
	return mb_strlen($xString, mb_internal_encoding()) < strlen($xString);
}

function strings_are_equal($xStringX, $xStringY, $xCaseInsensitive = false) {
	if ($xCaseInsensitive) return strcasecmp($xStringX, $xStringY) === 0;
	return $xStringX === $xStringY;
}

/**
 * Checks whether $xSbjStr contains $xObjStr or not.
 * 
 * @param string $xSbjStr
 * @param string $xObjStr
 * @param boolean $xCaseInsensitive
 * @return boolean
 */
function string_contains($xSbjStr, $xObjStr, $xCaseInsensitive = false) {
	return $xCaseInsensitive ? (stripos($xSbjStr, $xObjStr) !== false) : (strpos($xSbjStr, $xObjStr) !== false);
}

function repeat_string($xString, $xRepetition = 1) {
	$r = str($xString);
	for ($n = 0; $n < $xRepetition; $n++)
		$r .= $r;
	return $r;
}

/**
 * Gets the extention from a file path.
 * 
 * @param $xPath
 * @return
 *
 */
function ext($xPath) {
	return substr($xPath, strrpos($xPath, '.') + 1);
}

function ordinal_number($xNumber, $xWithSupTag = false) {
	$suffix;
	if (abs($xNumber) % 100 < 21 && abs($xNumber) % 100 > 4) $suffix = 'th';
	else {
		switch ($xNumber % 10) {
			case 1:
				$suffix = 'st';
				break;
			case 2:
				$suffix = 'nd';
				break;
			case 3:
				$suffix = 'rd';
				break;
		}
	}
	if ($xWithSupTag) $suffix = '<sup>' . $suffix . '</sup>';
	return $xNumber . $suffix;
}

function on_shutdown() {
	$lastError = error_get_last();
	if (isset($lastError)) {
		switch ($lastError['type']) {
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_CORE_WARNING:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:
				
				// これらのエラー (Fatal error など) は自動的にエラーハンドラに渡されないので、ここで渡す
				echo 'Unhandled Error'; // TESTCODE
				//handle_error($lastError['type'], $lastError['message'], $lastError['file'], $lastError['line']);
				handle_exception(new ErrorException($lastError['message'], 0, $lastError['type'], $lastError['file'], $lastError['line']));
		}
	}
}

function handle_error($xErrorNo, $xErrorMsg, $xErroredFile, $xErroredLine) { // INPROGRESS
	switch ($xErrorNo) {
		case E_ERROR:
		case E_USER_ERROR:
			echo 'Critical error handled'; // TESTCODE
		//handle_exception(new CriticalErrorException($xErrorMsg, 0, $xErrorNo, $xErroredFile, $xErroredLine));
		//throw new CriticalErrorException($xErrorMsg, 0, $xErrorNo, $xErroredFile, $xErroredLine));
	}
	throw new ErrorException($xErrorMsg, 0, $xErrorNo, $xErroredFile, $xErroredLine);
}

function handle_exception($xException) {
	try {
		echo 'Handling exception'; // TESTCODE
		if ($xException instanceof ResumableException) {
			if (!$xException->forcesTerminate()) return;
			// Resumes the program
		}
		
		put_runtime_log('The uncaught exception: ' . express(get_class($xException)) . ' occured with the message: ' . express($xException->getMessage()));
		if ($xException instanceof Detailable) put_runtime_log($xException->getDetail());
		
		if (context()->get('TEST_MODE')) {
			show_runtime_log();
			exit();
		}
		
		// UNTESTED プロダクトモードで例外が発生した場合はキャッシュされた静的なページを表示
		$cache = FILE_ENTRY . '.cache';
		if (file_exists($cache)) {
			put_warning_msg('申し訳ございません。最新のページの取得に失敗しました。<br />現在、' . date('c', filemtime($cache)) . 'に保存（キャッシュ）された静的なページを表示しています。');
			/*
			 * ALTER 警告文はキャッシュファイルに付加しないと意味無し
			 */
			ob_end_clean();
			echo file_get_contents($cache);
			exit();
		} else
			header('HTTP/1.0 500 Internal Server Error');
	
	} catch (Exception $e) {
		exit('The exception: ' . express(get_class($e)) . ' occured while handling the another exception: ' . express(get_class($xException)));
	}
}

function buf($xCallback = null, $xForcesPush = false) {
	static $buffers = array ();
	
	if (is_null($xCallback)) return array_pop($buffers);
	
	ob_start();
	invoke($xCallback);
	$r = ob_get_clean();
	if ($xForcesPush || !empty($r)) $buffers[] = $r;
	
	return $r;
}

function buffer($xCallback = null, $xForcesPush = false) {
	return buf($xCallback, $xForcesPush);
}

function invoke($xCallback) {
	if (is_callable($xCallback)) return call_user_func($xCallback);
	if (is_string($xCallback)) {
		if (substr($xCallback, -1) != ';') $xCallback .= ';';
		return eval(substr($xCallback, -1) == ';' ? $xCallback : ($xCallback . ';'));
	}
}

function template($xTemplate, $xVariables) {
	$r = xTemplate;
	
	return $r;
}

/*
 * #WIP
 * function parse_args($xArgs, $xValueDelimiter = ',') {
 * $r = array ();
 * if (is_array($xArgs)) {
 * foreach ($xArgs as $nKey => $n) {
 * $r[$nKey] = parse_args
 * }
 * } else if (is_string($xArgs)) {
 * parse_str($xArgs, $r);
 * }
 * return $r;
 * }
 */
?>