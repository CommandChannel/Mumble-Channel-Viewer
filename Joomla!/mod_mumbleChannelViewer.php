<?php
/**
 * Mumble Channel Viewer module entry point
 *
 * @package MumbleChannelViewer
 * @author Mike Johnson <mikej@commandchannel.com>; Doug Gilbert <gilbert.159@osu.edu>
 * @copyright Copyright (c) 2011, Command Channel Corporation
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
 * @version 2.1.0
 */
 
defined('_JEXEC') or die('Restricted Access');

/*include the stylesheet*/
$path =  JURI::base()."modules/mod_mumbleChannelViewer/";
JHTML::stylesheet('mod_mumbleChannelViewer.css',$path);

require_once( dirname(__FILE__).DS.'mumbleChannelViewer.php' );

$dataUrl = $params->get('dataUrl');
if (!filter_var($dataUrl, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED))
{
	JError::raiseWarning(500, JText::_("A valid URL was not supplied."));
	return;
}

if ($params->get('dataFormat') != 1)
	$dataFormat = "json";
else
	$dataFormat = "xml";

$cssClass = trim( $params->get('iconStyle') . ' ' . $params->get('fontColor') );

$cache = & JFactory::getCache();
echo "<div id='mumbleViewer' class='{$cssClass}'>";
echo $cache->call( array( 'MumbleChannelViewer', 'render' ), $dataUrl, $dataFormat );
echo '</div>';
?>