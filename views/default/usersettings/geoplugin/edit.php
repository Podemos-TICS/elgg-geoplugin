<?php

$plugin = elgg_extract("entity", $vars);
$page_owner = elgg_get_page_owner_entity();

$noyes_options = array(
    "no" => elgg_echo("option:no"),
    "yes" => elgg_echo("option:yes")
);

if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
    $body  = "<div>";
    $body .= elgg_echo("geoplugin:settings:enabled") . "<br />";
    $body .= elgg_view("input/dropdown", array("name" => "params[geoplugin_post_geolocation]", "options_values" => $noyes_options, "value" => $plugin->getUserSetting("geoplugin_post_geolocation", $page_owner->getGUID()))) . "<br />";
    $body .= elgg_echo("geoplugin:settings:enabled:note");
    $body .= "</div>";
    echo $body;
}