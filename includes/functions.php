<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Function to retrieve EDD data records for a customer.
 * @param Int $id The customer id.
 *
 * @return Array The result of the query.
 *  ['id'] Int
 *  ['label'] String
 *  ['slug'] String
 *  ['sites'] Serialized Array
 *  ['status'] String
 *  ['parent_id'] Int
 */
function get_edd_data( $id ) {
    global $wpdb;

    $sub_sql = "SELECT DISTINCT(`post_id`) FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_key` = '_edd_sl_user_id' AND `meta_value` = " . intval( $id );

    $sql = "SELECT `post_id` AS id, MAX(`label`) AS label, MAX(`slug`) AS slug, MAX(`sites`) AS sites, MAX(`status`) AS status, MAX(`parent`) AS parent_id FROM(SELECT `post_id`, null AS sites, `meta_value` AS status, null AS label, null AS slug, null AS parent FROM `". $wpdb->prefix . "postmeta` WHERE `post_id` IN (" . $sub_sql . ") AND `meta_key` = '_edd_sl_status' UNION ALL SELECT m.post_id, m.meta_value AS sites, null AS status, null AS label, null AS slug, p.post_parent AS parent FROM `" . $wpdb->prefix . "postmeta` AS m INNER JOIN `" . $wpdb->prefix . "posts` AS p ON p.id = m.post_id WHERE m.post_id IN (" . $sub_sql . ") AND m.meta_key = '_edd_sl_sites' UNION ALL SELECT m.post_id, null AS sites, null AS status, p.post_title AS label, p.post_name AS slug, null AS parent FROM `" . $wpdb->prefix . "postmeta` AS m INNER JOIN `" . $wpdb->prefix . "posts` AS p ON p.id = m.meta_value WHERE m.post_id IN (" . $sub_sql . ") AND m.meta_key = '_edd_sl_download_id' ) T GROUP BY `post_id`";

    $result = $wpdb->get_results( $sql, 'ARRAY_A' );

    return $result;
}
