<?php
/*
Plugin Name: bbPress New Topic Notifications to Inbox
Plugin URI: http://vamospace.com
Description: Send notification to the admin email when a new topic posted.
Version: 1.0
Author: Sabri Taieb
Author URI: http://vamospace.com
 * 
*/


if( !class_exists('cz_bbp_new_topic_notif') )
{
	class cz_bbp_new_topic_notif
	{
		
		public function __construct(  )
		{
			/** Actions **/
			add_action( 'bbp_new_topic',        array( $this, 'send_to_inbox' ),    10, 4   );
			
		}// End Func
	
		public function send_to_inbox( $topic_id = 0, $forum_id = 0, $anonymous_data = false, $topic_author = 0 )
		{
			
			// Topic & Blog Info
			$blog_name		= wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
			$admin_email	= wp_specialchars_decode( get_option( 'admin_email' ), ENT_QUOTES );
			$cz_topic			= array(
				'title'		=> html_entity_decode( strip_tags( bbp_get_topic_title( $topic_id ) ), ENT_NOQUOTES, 'UTF-8'),
				'excerpt'	=> html_entity_decode( strip_tags( bbp_get_topic_excerpt( $topic_id, 99 ) ), ENT_NOQUOTES, 'UTF-8'),
				'author'	=> bbp_get_topic_author( $topic_id ),
				'url'		=> bbp_get_topic_permalink( $topic_id )
			);		
		
			// Email Template
			$email_template =   __( 'Hello', 'cz_bbp_new_p_notif' ) . "!\n\n";
			$email_template .=  __( 'A new topic has been posted.', 'cz_bbp_new_p_notif' ) . "\n\n";
			$email_template .=  __( 'Title', 'cz_bbp_new_p_notif' ) . " : " . $cz_topic['title'] . "\n";
			$email_template .=  __( 'Author', 'cz_bbp_new_p_notif' ) ." : " . $cz_topic['author'] . "\n";
			$email_template .=  __( 'Excerpt', 'cz_bbp_new_p_notif' ) ." : " . $cz_topic['excerpt'] . "\n\n";
			$email_template .=  __( 'URL', 'cz_bbp_new_p_notif' ) . " : " . $cz_topic['url'];

		
			// Send Email
			$email_subject  = $blog_name . " " . __( 'New Topic', 'cz_bbp_new_p_notif' ) . ' - ' . $cz_topic['title'];
			@wp_mail( $admin_email, $email_subject, $email_template );
			
		}// End Func
	
	}new cz_bbp_new_topic_notif();

}// End If
