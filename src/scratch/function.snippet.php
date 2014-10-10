<?php
/**
 * Functions :: util :: WPELib(lesser)
 * @author Satoshi Soma
 * 
 * @version 2013-10-11 by S.Soma
 * 
 * #TODO Migrate to PHP Kniphe Project
 */

function vars($xVars) {
	if (is_array($xVars)) return $xVars;
	
	$r = array();
	if (is_string($xVars)) {
		parse_str($xVars, $r);
	}
	return $r;
}

function express_time($xTime, $xFormat) {
	if (is_int($xTime)) {
		return national_date('ja', $xFormat, $xTime);
	} else if (is_string($xTime)) {
		return national_date('ja', $xFormat, strtotime($xTime));
	}
}

function national_date($aCountry, $aFormat = 'Y-m-d H:i:s', $aTime) {
	$time = $aTime;
	
	$r = date($aFormat, $time);
	
	$patterns;
	$replacements;
	if (preg_match('/[^\\\]D/', $aFormat)) {
		$patterns = array('/sun/i', '/mon/i', '/tue/i', '/wed/i', '/thu/i',
				'/fri/i', '/sat/i');
		
		switch ($aCountry) {
		case 'ja':
			$replacements = array('日', '月', '火', '水', '木', '金', '土');
			break;
		}
		
	} else if (preg_match('/[^\\\]l/', $aFormat)) {
		$patterns = array('/sunday/i', '/monday/i', '/tuesday/i',
				'/wednesday/i', '/thursday/i', '/friday/i', '/saturday/i');
		
		switch ($aCountry) {
		case 'ja':
			$replacements = array('日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日',
					'土曜日');
			break;
		}
	}
	
	if (isset($patterns) && isset($replacements)) $r = preg_replace($patterns,
			$replacements, $r);
	
	return $r;
}

function alt_protocol($aUrl, $aProtocol = 'http') {
	return preg_replace('/^[^:]+:\/\//', $aProtocol.'://', $aUrl); // #UNTESTED
}
?>
