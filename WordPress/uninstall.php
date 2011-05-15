<?php
/*  Copyright 2010 - 2011 Command Channel Corporation

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();

wp_deregister_style( "mumble-channel-viewer" );
delete_option( 'mumble_channel_viewer_data_uri' );
delete_option( 'mumble_channel_viewer_data_format' );
delete_option( 'mumble_channel_viewer_icon_style' );
delete_option( 'mumble_channel_viewer_font_color' );

?>