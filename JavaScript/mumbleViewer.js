/*
Copyright © 2010 Command Channel Corporation

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/


/* initializes the Mumble tree and adds the timer interval for updating the Mumble tree */
$(document).ready(function(){
	renderTree();
	window.setInterval(renderTree, 30000);		// 30 second delay between updates.

});

/* renders the complete Mumble tree, including the channels and users */
function renderTree() {
	document.getElementById("mumbleLoading").style.display = "block";
	jQuery.getJSON(mumbleChannelViewerJsonUri,
	function (data) {
		$("#mumbleTree").html(renderChannel(data.root, true));
		document.getElementById("mumbleLoading").style.display = "none";
	});
}

/* renders a complete channel (including sub-channels) */
function renderChannel(channel, renderUl) {
	var html = "";
	
	if (renderUl)
		html = html + "<ul>";
	
	if (channel.x_connecturl != undefined)
		html = html + "<li><a class='mumbleChannel' href='" + channel.x_connecturl + "'>" + channel.name + "</a>";
	else
		html = html + "<li><span class='mumbleChannel'>" + channel.name + "</span>";
	
	var subStarted = false;
	
	for (var i = 0; i < channel.channels.length; i++) {
		if (channel.channels[i].channels.length > 0 || channel.channels[i].users.length > 0) {
			html = html + renderChannel(channel.channels[i], !subStarted);
		}
		else {
			if (!subStarted) {
				html = html + "<ul>";
				subStarted = true;
			}
			if (channel.channels[i].x_connecturl != undefined)
				html = html + "<li><a class='mumbleChannel' href='" + channel.channels[i].x_connecturl + "'>" + channel.channels[i].name + "</a></li>";
			else
				html = html + "<li><span class='mumbleChannel'>" + channel.channels[i].name + "</span></li>";
		}
	}
	
	if (channel.users.length > 0) {
		if (!subStarted) {
			html = html + "<ul>";
			subStarted = true;
		}
		for (var i = 0; i < channel.users.length; i++) {
			html = html + renderUser(channel.users[i]);
		}
	}
	
	if (subStarted)
		html = html + "</ul>";
	html = html + "</li>";
	if (renderUl)
		html = html + "</ul>";
	return html;
}

/* renders a single user */
function renderUser(user) {
	var html = "";
	html = html + "<li>";
	if (user.userid > 0)
		html = html + "<span class='mumbleChannelViewer-authenticated mumbleChannelViewer-statusIcon'>Authenticated</span>";
	
	if (user.suppress)
		html = html + "<span class='mumbleChannelViewer-suppressed mumbleChannelViewer-statusIcon'>Suppressed</span>";
	
	if (user.selfDeaf)
		html = html + "<span class='mumbleChannelViewer-selfDeafened mumbleChannelViewer-statusIcon'>Self-Deafened</span>";
	
	if (user.deaf)
		html = html + "<span class='mumbleChannelViewer-deafened mumbleChannelViewer-statusIcon'>Server-Deafened</span>";
	
	if (user.selfMute)
		html = html + "<span class='mumbleChannelViewer-selfMuted mumbleChannelViewer-statusIcon'>Self-Muted</span>";
	
	if (user.mute)
		html = html + "<span class='mumbleChannelViewer-muted mumbleChannelViewer-statusIcon'>Server-Muted</span>";
	
	if (user.idlesecs < 30 || user.suppress || user.selfMute || user.mute )
		html = html + "<span class='mumbleChannelViewer-user'>" + user.name + "</span>";
	else
		html = html + "<span class='mumbleChannelViewer-user'>" + user.name + "</span>";		// TODO: add speaking icon
	html = html + "</li>";
	
	return html;
}