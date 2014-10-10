<?php
namespace amekusa\Kniphe\math;
/**
 * Functions :: Math :: Kniphe
 * @since 2013-09-25
 * @version 2013-09-25
 */

function range($xValue, $xMinValue, $xMaxValue) {
	if ($xValue < $xMinValue) return $xMinValue;
	if ($xValue > $xMaxValue) return $xMaxValue;
	return $xValue;
}

function average($xNums) {
	return array_sum(flat_array(func_get_args())) / count($xNums);
}

function is_odd($xN) {
	return ($xN % 2) != 0;
}

function is_even($xN) {
	return ($xN % 2) == 0;
}
?>