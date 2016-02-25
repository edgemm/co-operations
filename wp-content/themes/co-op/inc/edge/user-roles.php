<?php

// modify Administrator display name
function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles like this...
    //$roles = $wp_roles->get_names();
    //print_r($roles);

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['administrator']['name'] = 'Edge Admin';
    $wp_roles->role_names['administrator'] = 'Edge Admin';
}
add_action('init', 'change_role_name');

// Add Client Admin role
function edgemm_add_user_roles() {

	$result = add_role( 'client_admin', 'Admin',
		array(
			'delete_others_pages'		=> true,
			'delete_others_posts'		=> true,
			'delete_pages'				=> true,
			'delete_posts'				=> true,
			'delete_private_pages'		=> true,
			'delete_private_posts'		=> true,
			'delete_published_pages'	=> true,
			'delete_published_posts'	=> true,
			'edit_others_pages'			=> true,
			'edit_others_posts'			=> true,
			'edit_pages'				=> true,
			'edit_posts'				=> true,
			'edit_private_pages'		=> true,
			'edit_private_posts'		=> true,
			'edit_published_pages'		=> true,
			'edit_published_posts'		=> true,
			'manage_categories'			=> true,
			'manage_links'				=> true,
			'moderate_comments'			=> true,
			'publish_pages'				=> true,
			'publish_posts'				=> true,
			'read'						=> true,
			'read_private_pages'		=> true,
			'read_private_posts'		=> true,
			'upload_files'				=> true,
			'edit_users'				=> true,
			'create_users'				=> true,
			'delete_users'				=> true
		)
	);

	// create only if role doesn't already exist	
	if ( null !== $result ) :
		return $result;
	endif;

}
add_action( 'init', 'edgemm_add_user_roles' );

// class to allow advanced manipulation of user role capabilities
class EdgeMM_User_Caps {

  // Add our filters
  function EdgeMM_User_Caps(){
    add_filter( 'editable_roles', array(&$this, 'editable_roles'));
    add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
  }

  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
    if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
      unset( $roles['administrator']);
    }
    return $roles;
  }

  // If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it
  function map_meta_cap( $caps, $cap, $user_id, $args ){

    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        case 'delete_user':
        case 'delete_users':
            if( !isset($args[0]) )
                break;
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        default:
            break;
    }
    return $caps;
  }

}

$edgemm_user_caps = new EdgeMM_User_Caps();


// hide admins from non-admins on WP Users page
function edgemm_hide_admins($user_search) {
  $user = wp_get_current_user();
  if (!current_user_can('administrator')) {
    global $wpdb;

    $user_search->query_where = 
        str_replace('WHERE 1=1', 
            "WHERE 1=1 AND {$wpdb->users}.ID IN (
                 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                    WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
                    AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')", 
            $user_search->query_where
        );
  }
}
add_action('pre_user_query','edgemm_hide_admins');

?>