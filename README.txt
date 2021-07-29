=== Code Tot - Gravity Form Tracking ===
Contributors: codetot, khoipro
Donate link: https://codetot.com
Tags: gravity forms, addons
Requires at least: 3.0.1
Tested up to: 5.8
Stable tag: 5.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Seamless save marketing campaign

== Description ==

This is a Gravity Forms addons. It requires your website must have Gravity Forms installed.

== Installation ==

**Setup form's fields**

- In each form editing, add 3 **hidden fields**:

```
UTM Source
UTM Size
UTM Campaign
```

In each field, please enable "Enable dynamic field population" and set key value as:

```
utm_source
utm_size
utm_campaign
```

Then activate this plugin by uploading via website or extract a zip file.

1. Upload `ct-gf-tracking.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= Any extra work after installing this plugin? =

To make this plugin works, you must add 3 hidden fields. See installation steps for more information.

= How do we could see collected data? =

In form's entry list.

== Screenshots ==

1. /assets/screenshot-1.png
2. /assets/screenshot-2.png
3. /assets/screenshot-3.png

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* First release
