<?php namespace amekusa\Kniphe\xml;

/**
 * Functions :: XML :: Kniphe
 */

/**
 * #DEPRECATED
 * @param unknown $xElemName
 * @param string $xContent
 * @param array $xAttrNames
 * @param array $xAttrValues
 * @throws IllegalArgumentException
 * @return string
 */
function xml_str($xElemName, $xContent = null, array $xAttrNames = null,
		array $xAttrValues = null) {
	$r = '<'.$xElemName;
	if (!empty($xAttrNames)) {
		$numAttrs = count($xAttrNames);
		if ($numAttrs !== count($xAttrValues)) throw new IllegalArgumentException();
		for ($i = 0; $i < $numAttrs; $i++) {
			$r .= ' '.$xAttrNames[$i].'="'.$xAttrValues[$i].'"';
		}
	}
	return $r.(is_null($xContent) ? ' />' : '>'.$xContent.'</'.$xElemName.'>');
}

/*
function xml_str($xElemName, $xAttributes = null, $xContent = null) {
	$r = '<'.$xElemName;
	if ()
	if (!empty($xAttrNames)) {
		$numAttrs = count($xAttrNames);
		if ($numAttrs !== count($xAttrValues)) throw new IllegalArgumentException();
		for ($i = 0; $i < $numAttrs; $i++) {
			$r .= ' '.$xAttrNames[$i].'="'.$xAttrValues[$i].'"';
		}
	}
	return $r.(is_null($xContent) ? ' />' : '>'.$xContent.'</'.$xElemName.'>');
}
*/

/**
 * @param unknown $xAttributes
 * @return array attribute/value sets
 * array ('attributeN' => valueN,...)
 * 
 * @author amekusa
 * @version 2013-11-12
 */
function parse_xml_attributes($xAttributes) {
	$r = array ();
	
	$matches = array ();
	preg_match_all('/\s+([a-zA-Z:_][a-zA-Z0-9:._-]*)=(".*?[^\\\\]"|\'.*?[^\\\\]\')/', ' '.$xAttributes, $matches);
	
	foreach ($matches[1] as $nKey => $n) {
		$r[$n] = substr($matches[2][$nKey], 1, -1);
	}
	
	return $r;
}
