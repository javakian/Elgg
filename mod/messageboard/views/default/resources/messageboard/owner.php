<?php
/**
 * Elgg Message board index page
 *
 * @package MessageBoard
 */

elgg_require_js('elgg/messageboard');

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof ElggUser) {
	throw new \Elgg\EntityNotFoundException();
}

$history_username = elgg_extract('history_username', $vars);
$history_user = get_user_by_username($history_username);

elgg_push_breadcrumb($page_owner->name, $page_owner->getURL());

$options = [
	'annotations_name' => 'messageboard',
	'guid' => $page_owner->guid,
	'order_by' => 'n_table.time_created desc, n_table.id desc',
	'preload_owners' => true,
	'no_results' => elgg_echo('messageboard:none'),
];

$title = elgg_echo('messageboard:owner', [$page_owner->name]);
$mb_url = '';

if ($history_user) {
	$options['annotations_owner_guid'] = $history_user->getGUID();
	$title = elgg_echo('messageboard:owner_history', [$history_user->name, $page_owner->name]);

	$mb_url = "messageboard/owner/$page_owner->username";
}

elgg_push_breadcrumb(elgg_echo('messageboard:board'), $mb_url);

if ($history_user) {
	elgg_push_breadcrumb($history_user->name);
}

$content = elgg_list_annotations($options);

$body = elgg_view_layout('content', [
	'filter' => false,
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $body);
