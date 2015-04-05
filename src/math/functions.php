<?php
namespace amekusa\Kniphe\math;

/**
 * Math Functions
 */
interface functions {
	const required = true;
}

function range($xValue, $xMinValue, $xMaxValue) {
	if ($xValue < $xMinValue) return $xMinValue;
	if ($xValue > $xMaxValue) return $xMaxValue;
	return $xValue;
}

function mean($xNums) {
	return array_sum(flat_array(func_get_args())) / count($xNums);
}

function odd($xN) {
	return ($xN % 2) != 0;
}

function even($xN) {
	return ($xN % 2) == 0;
}
