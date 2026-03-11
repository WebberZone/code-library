<?php
/**
 * Plugin Name: Top 10 - Custom Bot Exclusions
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Adds custom monitoring and crawler user agents to Top 10's bot exclusion list.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Add custom bot user agents to Top 10's exclusion list.
 *
 * Top 10 already ships with a list of common search crawler user agents.
 * Use this filter to extend it with monitoring services (UptimeRobot, Pingdom,
 * StatusCake) or any internal bots that would otherwise inflate view counts.
 *
 * Each string is matched as a case-insensitive substring against the visitor's
 * user agent, so partial strings are fine.
 *
 * @param array $bot_user_agents List of bot user agent strings.
 *
 * @return array Updated list with custom entries appended.
 */
function tptn_add_custom_bots( $bot_user_agents ) {
	$custom_bots = array(
		'uptimerobot',
		'pingdom',
		'statuscake',
		'site24x7',
		'hetrixtools',
	);

	return array_merge( $bot_user_agents, $custom_bots );
}
add_filter( 'tptn_bots', 'tptn_add_custom_bots' );
