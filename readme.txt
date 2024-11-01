=== wptf-image-gallery ===
Contributors: sakush100 
Tags: gallery, lightbox, photo, image, slideshow, jquery
Requires at least: 3.0
Tested up to: 3.7.1
Stable tag: trunk
License: GPLv2 or later

WordPress True Fullscreen (WPTF) Gallery is a modern gallery plugin that supports true fullscreen and have a lot of features built with it.

== Description ==

WPTF is a WordPress plugin, using which an image gallery system can be built. Below are the main features of this Gallery plugin

*   Simple, responsive and cross browser supported.
*   All modern mobile phones are supported, including default browsers of android and iphone.
*   **Slideshow**, **Best Fit to screen**, **Crop Fit to screen** modes for images are available
*   Launch directly in fullscreen if don\'t want to view description and comments OR launch in description mode.
*   jQuery powered pagination is provided for smooth user experience and save load on server.
*   Multiple thumbnail styles to choose from.
*   <a href=\"http://plugins.phploaded.com/wptf-lite/\" target=\"_blank\" title=\"wptf-image-gallery\">Click Here to see live demo</a>

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.
== Frequently Asked Questions ==

<h3 id=\"usage\">

**Usage Instructions**<a href=\"http://plugins.phploaded.com/wptf-lite/wp-admin/admin.php?page=wptf-goptions.php#toc\"></a></h3> 
**Creating galleries : **From \'WPTF Gallery\' tab, you can create, view manage and delete galleries. To create a new gallery, enter the details and press \"create gallery\". Gallery is now created with shortcode and settings you provided.

**Adding images in gallery : **From \'WPTF Gallery\' tab, click on \'Manage\' in desired row. Here you add, edit and delete images for this particular gallery.

**Editing settings : **From \'WPTF Gallery\' tab, click on \'Settings\' to open settings, here you can change the required options.

**Displaying galleries : **From \'WPTF Gallery\' tab, you can copy the shortcode for the desired gallery, then paste in any page, post, widget or custom post types to display the gallery. Additionally you can customize the gallery by customizing shortcode options.

**Shortcode Options : **In the generated shortcode, if you can additionally define some options. They are explained below :

    [wptf items_per_page=\"20\" mode=\"mbox\" navigation=\"bottom\" id=\"4\"]
    

*   **items\_per\_page : **Used to generate gallery pagination. Just input how many items should be shown on each page, rest happens automatically.
*   **mode : **If you dont want description and comment systems, gallery can be launched directly in fullscreen mode by using ***fullscreen*** as value. otherwise dont use this property to load default mode.
*   **navigation : **Used to define pagination location. You can use ***top*** to display pagination only at top, ***bottom*** to display pagination only at bottom, ***both*** to display pagination at top and bottom, both. ***none*** to hide pagination.
== Screenshots ==
1. Default view of thumbnails

2. When a thumbnail is clicked, fb style lightbox is opened as shown

3. How it looks in fullscreen supported browsers

4. wp-admin view of the plugin

== Changelog ==
v1.0.3 Fixed mbox script authorization error

v1.0.2 Fixed crop mode issues in lightbox and added documentation

v1.0.1 none, initial version