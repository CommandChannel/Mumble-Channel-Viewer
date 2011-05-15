<?php
/**
 * Helper class for the Mumble Channel Viewer module
 *
 * @package MumbleChannelViewer
 * @author Mike Johnson <mikej@commandchannel.com>; Doug Gilbert <gilbert.159@osu.edu>
 * @copyright Copyright (c) 2011, Command Channel Corporation
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
 * @version 1.0
 */
class MumbleChannelViewer
{
	/**
	 * @since 1.0
	 * @todo Add XML format support and input validation.
	 * @param string $dataUri URI that will return information about a Mumble server.
	 * @param string $dataFormat The format the data will be in (i.e. xml or json).
	 * @return string An HTML unordered list containing all of the channels and users currently connected to the Mumble server.
	*/
	static function render($dataUri, $dataFormat = "json")
	{
		if ($dataFormat == "json")
			return self::renderJson($dataUri);
		else if ($dataFormat == "xml")
			return "<div class='mumbleChannelViewer-error'>The XML format is not supported yet.</div>";
		else
			return "<div class='mumbleChannelViewer-error'>The data format {$dataFormat} is not supported.</div>";
	}

	/**
	 * @since 1.0
	 * @param string $jsonUri URI that will return information about a Mumble server in JSON format.
	 * @return string An HTML unordered list containing all of the channels and users currently connected to the Mumble server.
	*/
	protected static function renderJson($jsonUri)
	{
		$httpOptions = array(
			'http' => array(
				'method'		=> 'GET',
				'timeout'		=> 10.0,
				'user_agent'	=> 'Joomla! Mumble Channel Viewer 1.0'
			)
		);
		$httpContext = stream_context_create($httpOptions);
		$jsonRaw = file_get_contents($jsonUri, false, $httpContext);
		if ($jsonRaw == false)
			return "<div class='mumbleChannelViewer-error'>Unable to connect to the specified Mumble server.</div>";

		$jsonDecoded = json_decode($jsonRaw, true);
		if ($jsonDecoded == null)
			return "<div class='mumbleChannelViewer-error'>Unable to parse the returned information as JSON.</div>";

		return self::renderChannel($jsonDecoded["root"], true);
	}

	/**
	 * Recursively parses a channel and compiles information about subchannels and users.
	 * @since 1.0
	 * @param array $currentChannel The channel to parse.
	 * @param bool $renderUl True if an opening UL tag has aleady been generated (i.e. this usually happens when $currentChannel is not the first channel in the list of subchannels); otherwise, false.
	 * @return string An HTML unordered list containing all of the subchannels and users.
	*/
	protected static function renderChannel($currentChannel, $renderUl) {
		$output = null;
		if ($renderUl)
			$output .= "<ul>";

		$output .= "<li>";		// Start of the LI element for this channel
		if (isset($currentChannel["x_connecturl"]))
			$output .= "<a href=\"{$currentChannel["x_connecturl"]}\">{$currentChannel["name"]}</a>";
		else
			$output .= "<span class='mumbleChannelViewer-channel'>{$currentChannel["name"]}</span>";

		$subStarted = false;

		foreach ($currentChannel["channels"] as $subChannel) {
			$output .= self::renderChannel($subChannel, !$subStarted);		// recursively render each subchannel
		}

		if (count($currentChannel["users"]) > 0) {		// render each user for the current channel
			if (!$subStarted) {		// If there were no subchannels, and there are users in this channel, then we need to open a new UL element to hold the users.
				$output .= "<ul>";
				$subStarted = true;
			}

			foreach ($currentChannel["users"] as $currentUser) {
				$output .= self::renderUser($currentUser);
			}
		}

		if ($subStarted)
			$output .= "</ul>";		// Closes the child UL element (used if there are channels below this one or users in this channel).

		$output .= "</li>";		// End of the LI element for this channel

		if ($renderUl)
			$output .= "</ul>";

		return $output;
	}

	/**
	 * Parses user information (such as mute and deafened status).
	 * @since 1.0
	 * @param array $user The user to parse.
	 * @return string An HTML list item element that contains the user's name and any relevant status icons.
	*/
	protected static function renderUser($user) {
		$output = "<li>";

		if ($user["userid"] > 0)
			$output .= "<span class='mumbleChannelViewer-authenticated mumbleChannelViewer-statusIcon'>Authenticated</span>";
		if ($user["suppress"])
			$output .= "<span class='mumbleChannelViewer-suppressed mumbleChannelViewer-statusIcon'>Suppressed</span>";
		if ($user["selfDeaf"])
			$output .= "<span class='mumbleChannelViewer-selfDeafened mumbleChannelViewer-statusIcon'>Self-Deafened</span>";
		if ($user["deaf"])
			$output .= "<span class='mumbleChannelViewer-deafened mumbleChannelViewer-statusIcon'>Server-Deafened</span>";
		if ($user["selfMute"])
			$output .= "<span class='mumbleChannelViewer-selfMuted mumbleChannelViewer-statusIcon'>Self-Muted</span>";
		if ($user["mute"])
			$output .= "<span class='mumbleChannelViewer-muted mumbleChannelViewer-statusIcon'>Server-Muted</span>";
		$output .= "<span class='mumbleChannelViewer-user'>{$user["name"]}</span></li>";

		return $output;
	}
}
?>
