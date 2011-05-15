The Joomla! Mumble Channel Viewer is a module for Joomla! that allows you to easily display your Mumble server status on your Joomla! powered website.

### Requirements ###
- Joomla! >= 1.5.0
- PHP >= 5.2.0 ([fopen wrappers](http://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen) must be enabled)

### Configuration ###
There are several options for available for configuring the look and behavior of the Joomla! Mumble Channel Viewer.

Once you change a configuration option you will need to clear your com_modules cache to see the new setting immediately.

#### Data URL ####
This is the URL to the endpoint that implements the [Channel Viewer Protocol](http://mumble.sourceforge.net/Channel_Viewer_Protocol) (CVP). You should get this URL from your Mumble service provider. If you host your own Mumble server, you must use a [third-party application](http://mumble.sourceforge.net/3rd_Party_Applications) to provide this endpoint. Keep in mind that JSON is used, *not* JSONP (there should be no *callback* argument in your URL).

#### Data Format ####
Per the CVP specification the options for this are JSON or XML. Please note that XML is *not* currently supported by the Joomla! Mumble Channel Viewer.

#### Icon Style ####
Sets which icon set your viewer will use.

#### Font Color ####
Allows you to change the font color used to render channel and user names.