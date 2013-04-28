
<div id="item-body">

<?php 
	global $list_post_atts, $list_post_query, $wp_query, $tkf, $bp;
   if(function_exists(bp_has_groups)){
	if ( bp_has_groups('user_id='.bp_displayed_user_id()) ) : 
	
	$groups_post_ids = array();
	
	while ( bp_groups() ) : bp_the_group(); 
	  
		$group_post_id = groups_get_groupmeta( bp_get_group_id(), 'group_post_id' );
		$group_type = groups_get_groupmeta( bp_get_group_id(), 'group_type' );
		
		if($group_type == $bp->current_component){
			$cpt4bp_post_ids[] = $group_post_id;
		}
		
	endwhile;

	do_action( 'bp_after_groups_loop' );
	endif;
}

// $list_post_atts = create_template_builder_args('apps');

// echo list_posts_template_builder_css();
global $the_lp_query;
$the_lp_query = new WP_Query( array( 'post_type' => $bp->current_component, 'post__in' => $cpt4bp_post_ids, 'posts_per_page' => 99, 'author' => get_current_user_id() ) );

	//get_template_part( 'cpt4bp-loop' );
	cpt4bp_locate_template('cpt4bp/bp/members-post-loop.php');

if(function_exists('wp_pagenavi')){
	wp_pagenavi( array( 'query' => $meins) );	
}


 do_action( 'bp_after_postsonprofile_body' ) ?>                

</div><!-- #item-body -->