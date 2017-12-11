<?php
/**
 * A user dashboard
 */

/**
 * Dashboard init
 *
 * @return void
 */
function dashboard_init() {
	elgg_register_page_handler('dashboard', 'dashboard_page_handler');

	if (elgg_is_logged_in()) {
		elgg_register_menu_item('topbar', [
			'name' => 'dashboard',
			'href' => 'dashboard',
			'text' => elgg_echo('dashboard'),
			'icon' => 'th-large',
			'priority' => 100,
			'section' => 'alt',
			'parent_name' => 'account',
		]);
	}
	
	elgg_register_plugin_hook_handler('get_list', 'default_widgets', 'dashboard_default_widgets');
}

/**
 * Dashboard page handler
 *
 * @return bool
 */
function dashboard_page_handler() {
	echo elgg_view_resource('dashboard');
	return true;
}

/**
 * Register user dashboard with default widgets
 *
 * @param string $hook   'get_list',
 * @param string $type   'default_widgets'
 * @param array  $return current return value
 * @param mixed  $params supplied params
 *
 * @return array
 */
function dashboard_default_widgets($hook, $type, $return, $params) {
	$return[] = [
		'name' => elgg_echo('dashboard'),
		'widget_context' => 'dashboard',
		'widget_columns' => 3,

		'event' => 'create',
		'entity_type' => 'user',
		'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
	];

	return $return;
}

return function() {
	elgg_register_event_handler('init', 'system', 'dashboard_init');
};
