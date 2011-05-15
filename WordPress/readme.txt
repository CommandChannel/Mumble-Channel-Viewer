=== Plugin Name ===
Contributors: CommandChannel
Donate link: http://sourceforge.net/donate/index.php?group_id=147372
Tags: mumble, murmur, voip, viewer, channel
Requires at least: 3.1.1
Tested up to: 3.1.2
Stable tag: 2.1.0

Shows your Mumble server's channels and who's connected. It also displays status icons (i.e. if a user is muted or deafened).

== Description ==

The **Mumble Channel Viewer** will display all of the channels in your Mumble server, as well as who is in those channels, and their current status (i.e. registered, muted, deafened, etc).

This widget communicates with your Mumble server using the [Channel Viewer Protocol](http://mumble.sourceforge.net/Channel_Viewer_Protocol) (CVP). If you host your own Mumble server you can implement the CVP using [MumPI](http://mumble.sourceforge.net/Mumble_PHP_Interface). You can find a service provider that implements the CVP on [this list](http://mumble.sourceforge.net/Hosters).

Requirements:

* PHP >= 5.2.0
* fopen_wrappers() must be [enabled](http://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen)

== Installation ==

1. Download the zipped plugin file to your local machine
2. Login to WordPress, and on the *Plugins* menu click *Add New*
3. On the *Install Plugins* page, click *Upload* then browse for the zipped file and click *Install Now*
4. Once you receive the message *Plugin installed successfully* click on *Activate Plugin*
5. Under the *Appearance* menu, click on *Widgets* and add the *Mumble Channel Viewer* widget to a widget area
6. Enter the URL to your CVP server and the data format (`JSON` or `XML`) and click *Save*

== Frequently Asked Questions ==

= Do I enter the JSON or JSONP URL? =

You should enter the **JSON** URL.

= Is XML supported? =

Not yet.

== Screenshots ==

1. Configuration options for the Mumble Channel Viewer.
2. How the Mumble Channel Viewer looks on the default Twenty Ten theme.

== Changelog ==

= 2.1.0 =
* Added font and icon style options

= 2.0.3 =
* Added requirements and screenshots to the readme

= 2.0.2 =
* Made code more conformant with the WordPress coding standards
* Updated CSS to accomodate the Twenty Ten theme

= 2.0.0 =
* Updated widget to use the standard Channel Viewer Protocol

= 1.0.0 =
* Initial release (using a proprietary protocol).

== Upgrade Notice ==

= 2.1.0 =
Adds a couple of cosmetic options. Should not be considered a critical update.

= 2.0.2 =
Enhances code readability, fixes some minor formatting issues with the Twenty Ten theme. Not a critical update.

= 2.0.0 =
This version is compatible with all vendors who implement the CVP, including self-hosters.