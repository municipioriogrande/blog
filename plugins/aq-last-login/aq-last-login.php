<?php

/*
Plugin Name: Último login
Author: Ariela Quinzi
Description: Guarda la fecha y hora de última sesión del usuario, y muestra en columna en el perfil.
Version: 1.0
*/


/* 
source: https://www.wpbeginner.com/plugins/how-to-show-users-last-login-date-in-wordpress/
*/

add_action( 'wp_login', 'user_last_login', 10, 2 );
function user_last_login( $user_login, $user ) {
	update_user_meta( $user->ID, 'last_login', time() );
}

function wpb_lastlogin($user_id) { 
	$last_login = get_the_author_meta('last_login', $user_id);
	$the_login_date = ( $last_login ) ? human_time_diff($last_login) : "Nunca";
	return $the_login_date; 
} 

add_filter( 'manage_users_columns', 'new_modify_user_table' );
function new_modify_user_table( $column ) {
	$column['last_login'] = 'Última sesión';
	return $column;
}

add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
function new_modify_user_table_row( $val, $column_name, $user_id ) {
	switch ($column_name) {
		 case 'last_login' :
			  return wpb_lastlogin($user_id);
		 default:
	}
	return $val;
}


