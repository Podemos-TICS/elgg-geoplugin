<?php
/* ***********************************************************************
 * @author : Cim
 * @link http://www.demyx.com
 * ***********************************************************************/

	register_elgg_event_handler('init','system','geoplugin_init');
	
	function geoplugin_init() 
	{
		elgg_register_event_handler('login', 'user', 'user_location');
		elgg_register_event_handler('create', 'user', 'user_location');

		if (elgg_get_context() == 'activity') {
			elgg_extend_view('page/elements/head', 'geoplugin/css');
			elgg_extend_view('river/object/thewire/create', 'geoplugin/river');
		}

		if (elgg_get_context() == 'thewire') {
			elgg_extend_view('page/elements/head', 'geoplugin/css');
			elgg_extend_view('object/thewire', 'geoplugin/thewire');
		}
	}

	function user_location($event, $object_type, $object) {
		if (($object) && ($object instanceof ElggUser))
		{
			if (elgg_get_plugin_user_setting("geoplugin_post_geolocation", $object->guid, "geoPlugin") == "yes")
			{
				// Try to get IP address
				if (getenv('HTTP_CLIENT_IP')) {
					$ip_address = getenv('HTTP_CLIENT_IP');
				} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
					$ip_address = getenv('HTTP_X_FORWARDED_FOR');
				} elseif (getenv('HTTP_X_FORWARDED')) {
					$ip_address = getenv('HTTP_X_FORWARDED');
				} elseif (getenv('HTTP_FORWARDED_FOR')) {
					$ip_address = getenv('HTTP_FORWARDED_FOR');
				} elseif (getenv('HTTP_FORWARDED')) {
					$ip_address = getenv('HTTP_FORWARDED');
				} else {
					$ip_address = $_SERVER['REMOTE_ADDR'];
				}

				// creates two metadata for each user
				$url = 'http://www.geoplugin.net/json.gp?ip=' . $ip_address;
				$json = file_get_contents($url);
				$data = json_decode($json, TRUE);
				$city = $data['geoplugin_city']; // saves their city
				$region = $data['geoplugin_region']; // saves their state/region

				create_metadata($object->guid, 'city', $city, '', 0, ACCESS_PUBLIC);
				create_metadata($object->guid, 'region', $region, '', 0, ACCESS_PUBLIC);
			}
			else
			{
				create_metadata($object->guid, 'city', "", '', 0, ACCESS_PUBLIC);
				create_metadata($object->guid, 'region', "", '', 0, ACCESS_PUBLIC);
			}
		}
	}