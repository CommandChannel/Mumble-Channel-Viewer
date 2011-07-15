<?php
/*
 * Project:     Mumble Channel Viewer
 * License:     GNU General Public License, version 2
 * Link:	http://www.gnu.org/licenses/gpl-2.0.html
 * -----------------------------------------------------------------------
 * Began:       2011
 * Date:        $Date$
 * -----------------------------------------------------------------------
 * @author      $Author$
 * @copyright   2011 Command Channel Corporation
 * @link        http://CommandChannel.com
 * @package     mumbleviewer
 * @version     $Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');
	exit;
}

// You have to define the Module Information
$portal_module['mumbleviewer'] = array(
	'name'		=> 'Mumble Channel Viewer Module',
	'path'		=> 'mumbleviewer',
	'version'	=> '1.0.0',
	'author'	=> 'Mike Johnson',
	'contact'	=> 'support@commandchannel.com',
	'description'   => 'Displays Mumble server information',
	'positions'     => array('left1', 'left2', 'right', 'middle'),
	'install'       => array(
		'autoenable'        => '0',
		'defaultposition'   => 'right',
		'defaultnumber'     => '6',
		'visibility'        => '0',
		'collapsable'       => '1',
	),
);

$portal_settings['mumbleviewer'] = array(
	'pk_mumbleviewer_datauri'     => array(
		'name'      => 'pk_mumbleviewer_datauri',
		'language'  => 'pk_mumbleviewer_datauri',
		'property'  => 'text',
		'size'      => '30',
		'help'      => 'pk_mumbleviewer_datauri_help',
	),
	'pk_mumbleviewer_dataformat'     => array(
		'name'      => 'pk_mumbleviewer_dataformat',
		'language'  => 'pk_mumbleviewer_dataformat',
		'property'  => 'dropdown',
		'size'      => '30',
		'options'	=> array('json' => 'JSON', 'xml' => 'XML'),
		'help'      => 'pk_mumbleviewer_dataformat_help',
	),
	'pk_mumbleviewer_iconstyle'     => array(
		'name'      => 'pk_mumbleviewer_iconstyle',
		'language'  => 'pk_mumbleviewer_iconstyle',
		'property'  => 'dropdown',
		'options'	=> array('mumbleViewerIconsDefault' => 'Default', 'mumbleViewerIconsFarCry2' => 'Far Cry 2', 'mumbleViewerIconsNextGen' => 'NextGen', 'mumbleViewerIconsSCGermania' => 'SC Germania'),
		'help'      => 'pk_mumbleviewer_iconstyle_help',
	)
);

if(!function_exists(mumbleviewer_module)){
	function mumbleviewer_module(){
		global $eqdkp , $user , $tpl, $db, $plang, $conf_plus, $eqdkp_root_path;

		$dataUri = $conf_plus['pk_mumbleviewer_datauri'];
		$dataFormat = $conf_plus['pk_mumbleviewer_dataformat'];
		$iconStyle = $conf_plus['pk_mumbleviewer_iconstyle'];

		$output .= "<link rel='stylesheet' type='text/css' href='{$eqdkp_root_path}portal/mumbleviewer/mumbleChannelViewer.css' />";
		$output .= "<script>document.getElementById('txtmumbleviewer').innerHTML = '" . $conf_plus['pk_mumbleviewer_headtext'] . "';</script>";
		$output .= "<div id='mumbleViewer' class='{$iconStyle}'>";

		if ( $dataUri && $dataFormat ) {
			$mumbleViewerInclude = $eqdkp_root_path . 'portal/mumbleviewer/mumbleChannelViewer.php';
			if (is_file($mumbleViewerInclude)) {
				require_once( $mumbleViewerInclude );
				$output .= MumbleChannelViewer::render( html_entity_decode( $dataUri ), $dataFormat );
			}
		}
		$output .= "</div>";

		return $output;
	}
}
?>
