=== Google Trends Widget ===
Contributors: ithoib
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=D29TQWBD42HMN
Tags: google, trends, widget
Requires at least: 3.0.1
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Widget to display google trends item from specified countries which linked to search page.

== Description ==

If you are member of Internet Marketing DOJO, I think you know about this plugin.
This plugin will help you to maximize your index in google and get country targeted visitor to your autoblog.

Features:
* Support 47 countries
* Cache support
* Unlimited widget instances

== Installation ==

1. In your WordPress admin panel, go to Plugins > New Plugin, search for "Google Trends Widget" and click "Install now". Alternatively, download the plugin and upload the contents of igtrends2.zip to your plugins directory, which may be /wp-content/plugins/.
1. Activate the plugin Google Trends Widget through the 'Plugins' menu in WordPress.
1. Go to Appearance > Wiget to place Google Trends Widget in your widget area


== Frequently Asked Questions ==

= How to change search permalink =

Go to Plugin > Editor, select Google Trends Widget
Replace this code :


`echo '<li><a href="'.get_bloginfo('url').'/?s='.$hot->title.'">'.$hot->title.'</a></li>'; `

With this code

`echo '<li><a href="'.get_bloginfo('url').'/search/'.$this->clean($hot->title).'">'.$hot->title.'</a></li>'; `


== Changelog ==

= 1.0 =
* First version uploaded to wordpress directory