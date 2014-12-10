<?php
namespace amekusa\Kniphe\web\google;
use amekusa\Kniphe as Kn;

/**
 * Google Maps
 */
class Map {
	protected $lat, $lng;
	protected $locationName;
	
	public function __construct() {
	}
	
	public function getUrl() {
		$r = 'https://maps.google.co.jp/maps';
		
		$params = array ();
		
		if (isset($this->lat) && isset($this->lng)) {
			$params['ll'] = "{$this->lat},{$this->lng}";
		}
		
		if ($this->locationName) {
			$params['q'] = $this->locationName;
		}
		
		$q = http_build_query($params);
		if ($q) $r .= '?' . $q;
		
		return $r;
	}
	
	public function getLocationName() {
		return $this->locationName;
	}
	
	public function setPos($xLat, $xLng) {
		if (!$xLat || !$xLng) return;
		$this->lat = $xLat;
		$this->lng = $xLng;
	}
	
	public function setLocationName($xName) {
		$this->locationName = $xName;
	}
}
?>