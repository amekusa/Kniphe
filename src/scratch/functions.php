<?php
namespace amekusa\Kniphe\scratch;
/**
 * Draft functions
 * @author Satoshi Soma
 */

function body_html_of_dom_doc(\DOMDocument $xDoc) {
	$doc = $xDoc->cloneNode(false);
	$body = $xDoc->getElementsByTagName('body')->item(0);
	foreach ($body->childNodes as $iC) {
		$doc->appendChild($doc->importNode($iC->cloneNode(true), true));
	}
	return $doc->saveHTML();
}

function inner_html_of_dom(\DOMNode $xNode) {
	if (!$xNode->hasChildNodes()) return '';
	
	/* Only for PHP 5.3.6+
	foreach ($children as $iC)
			$r .= $xNode->ownerDocument->saveHTML($iC);
	*/
	
	/*
	$doc = $xNode->ownerDocument;
	foreach ($children as $iC) {
		//$iDoc = new \DOMDocument($doc->version, $doc->encoding);
		$iDoc = $doc->cloneNode(false);
		$iDoc->preserveWhiteSpace = false;
		$iDoc->appendChild($iDoc->importNode($iC->cloneNode(true), true));
		$r .= $iDoc->saveHTML();
	}
	*/
	
	$doc = null;
	if (!isset($xNode->ownerDocument)) $doc = new \DOMDocument();
	else $doc = $xNode->ownerDocument->cloneNode(false);
	foreach ($xNode->childNodes as $iC) {
		$doc->appendChild($doc->importNode($iC->cloneNode(true), true));
	}
	$r = $doc->saveHTML();
	return mb_convert_encoding($r, $doc->encoding, 'HTML-ENTITIES');
}

function dom_as_html(\DOMNode $xNode) {
	$doc = null;
	if (!isset($xNode->ownerDocument)) $doc = new \DOMDocument();
	else $doc = $xNode->ownerDocument->cloneNode(false);
	$doc->appendChild($doc->importNode($xNode->cloneNode(true), true));
	$r = $doc->saveHTML();
	return mb_convert_encoding($r, $doc->encoding, 'HTML-ENTITIES');
}

/**
 * More precise equality.
 * @param \DOMNode $xNode1
 * @param \DOMNode $xNode2
 * @return boolean
 */
function doms_are_equal(\DOMNode $xNode1, \DOMNode $xNode2) {
	if ($xNode1->isSameNode($xNode2)) return true;
	if ($xNode1 != $xNode2) return false;
	if ($xNode1->nodeValue != $xNode2->nodeValue) return false;
	
	if ($xNode1 instanceof \DOMCharacterData) {
		if ($xNode1->data != $xNode2->data) return false;
	}
	
	if ($xNode1->hasChildNodes()) {
		if (!$xNode2->hasChildNodes()) return false;
		
		foreach ($xNode1->childNodes as $iC) {
			foreach ($xNode2->childNodes as $jC) {
				if (!doms_are_equal($iC, $jC)) return false;
			}
		}
	} else if ($xNode2->hasChildNodes()) return false;
	
	return true;
}

/*
function first_meaningful_child_of_dom(\DOMNode $xNode, $xIncludesComments = false) {
	if (!$xNode->hasChildNodes()) return null;
	foreach ($xNode->childNodes as $iC) {
		if ($iC instanceof \DOMComment)
		
		if ($iC instanceof \DOMCharacterData) {
			if (!ctype_space($iC->data)) return $iC;
		}
	}
}
*/
?>