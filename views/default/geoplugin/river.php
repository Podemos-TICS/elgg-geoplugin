<?php
/**
 * Display location only for wire post in the activity view
 * 
 * 
 */

$subject = $vars['item']->getSubjectEntity();

$city = $subject->city;
$region = $subject->region;

if ($city) { 
	echo '<div class="user-location">';
	echo '<img src="' . elgg_get_site_url() . 'mod/geoplugin/_graphics/location.png' . '" />';
	echo $city . ', ' . $region ;
	echo '</div>';
}