<?php
/*
 * Project:     Mumble Channel Viewer
 * License:     GNU General Public License, version 2
 * Link:		http://www.gnu.org/licenses/gpl-2.0.html
 * -----------------------------------------------------------------------
 * Began:       2011
 * Date:        $Date$
 * -----------------------------------------------------------------------
 * @author      $Author$
 * @copyright   20011 Command Channel Corporation
 * @link        http://CommandChannel.com
 * @package     mumbleviewer
 * @version     $Rev$
 * 
 * $Id$
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$plang = array_merge($plang, array(
  'helloworld'                 => 'Hello World',
  'portal_gelloworld_text'     => 'Hello World',
  'pk_mumbleviewer_datauri'   => 'Data URI',
  'pk_mumbleviewer_datauri_help'   => 'Enter the CVP Uniform Resource Identifier given to you by your hosting provider.',
  'pk_mumbleviewer_dataformat'     => 'Data Format',
  'pk_mumbleviewer_dataformat_help'     => 'Select the data format specified by your hosting provider.',
  'pk_mumbleviewer_iconstyle'     => 'Icon Style',
  'pk_mumbleviewer_iconstyle_help'     => 'Select the style of icons that prefer.',
));
?>
