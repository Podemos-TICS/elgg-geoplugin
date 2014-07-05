<?php
/**
 * Display location for the wire
 * 
 * 
 */

$post = elgg_extract('entity', $vars, FALSE);
$owner = $post->getOwnerEntity();

$city = $owner->city;
$region = $owner->region;

if ($city) {
	echo '<div class="user-location">';
	echo '<img src="' . elgg_get_site_url() . 'mod/geoplugin/_graphics/location.png' . '" />';
	echo $city . ', ' . $region;
	echo '</div>';
}