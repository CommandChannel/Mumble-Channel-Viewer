<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Mumble Viewer Demo</title>
	<!-- Copy everything below this line -->
	<link rel="stylesheet" href="mumbleChannelViewer.css" type="text/css" />
	<!-- Copy everything above this line -->
	<style type="text/css">
		body { font: 0.8em Georgia; }
		#icons { margin: 0; padding: 0; list-style-type: none; }
		#icons li { display: inline; float: left; text-align: center; margin: 1em; border: 1px solid #c0c0c0; padding: 0.5em; }
		#icons li:hover { background-color: #f6f6f6; }
		h3 { clear: both; }
		a, a:visited { color: #4d72db; text-decoration: none; }
		a:hover { color: #bb1a00; }
	</style>
</head>
<body>
	<h1>Mumble Viewer Demo</h1>
	<p>This is a demo of the Mumble Viewer. Make sure to set the correct value for <em>$dataUrl</em> first. Be sure to also include the CSS link to <em>mumbleChannelViewer.css</em> in your page.</p>

	<!-- Copy everything below this line. The "class" values can be changed for a different appearance. Possible values are listed further down. -->
	<div id="mumbleViewer" class="mumbleViewerIconsDefault mumbleViewerColorBlack">
		<?php
			require_once( 'mumbleChannelViewer.php' );
			$dataUrl = 'http://json/serverId=1';		// Enter your JSON URL between the single quotes (')
			echo MumbleChannelViewer::render( $dataUrl, 'json' );
		?>
	</div>
	<!-- Copy everything above this line -->
	
	<h2>Icon and Color Values</h2>
	<p>The icons and colors used for the viewer can be manipulated by changing the <em>class</em> attribute on the <em>mumbleViewer</em> <strong>div</strong> element. Possible options are listed below:</p>
	
	<h3>Icon Sets</h3>
	<ul id="icons">
		<li>Default: <strong>mumbleViewerIconsDefault</strong><br />
			<img src="images/mumbleViewerIcons.png" />
		</li>
		<li><a href="http://mumble-tower.de/downloads/mumble-skin/far-cry-2-skin">Far Cry 2</a>: <strong>mumbleViewerIconsFarCry2</strong><br />
			<img src="images/mumbleViewerIconsFarCry2.png" />
		</li>
		<li><a href="http://mumble-tower.de/downloads/mumble-skin/nextgen-mumble-skin">NextGen</a>: <strong>mumbleViewerIconsNextGen</strong><br />
			<img src="images/mumbleViewerIconsNextGen.png" />
		</li>
		<li><a href="http://mumble-tower.de/downloads/mumble-skin/sc-germania-firon">SC Germania</a>: <strong>mumbleViewerIconsSCGermania</strong><br />
			<img src="images/mumbleViewerIconsSCGermania.png" />
		</li>
	</ul>
	
	<h3>Color Values</h3>
	<ul>
		<li style="color: Aqua;">mumbleViewerColorAqua</li>
		<li>mumbleViewerColorBlack</li>
		<li style="color: Blue;">mumbleViewerColorBlue</li>
		<li style="color: Fuchsia;">mumbleViewerColorFuchsia</li>
		<li style="color: Gray;">mumbleViewerColorGray</li>
		<li style="color: Green;">mumbleViewerColorGreen</li>
		<li style="color: Lime;">mumbleViewerColorLime</li>
		<li style="color: Maroon;">mumbleViewerColorMaroon</li>
		<li style="color: Navy;">mumbleViewerColorNavy</li>
		<li style="color: Olive;">mumbleViewerColorOlive</li>
		<li style="color: Purple;">mumbleViewerColorPurple</li>
		<li style="color: Red;">mumbleViewerColorRed</li>
		<li style="color: Silver;">mumbleViewerColorSilver</li>
		<li style="color: Teal;">mumbleViewerColorTeal</li>
		<li>mumbleViewerColorWhite</li>
		<li style="color: Yellow;">mumbleViewerColorYellow</li>
	</ul>
</body>
</html>