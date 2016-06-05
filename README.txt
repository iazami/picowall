=== Plugin Name ===
Contributors: mhazami
Donate link: http://www.iazami.ir/
Tags: comments, spam
Requires at least: 3.8.0
Tested up to: 4.5.2
Stable tag: 4.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Resize images on the fly.

== Description ==

With this plugin installed, you can resize images on the fly.
just define size and the way that you want to resize and it's done.

it is perfect for wallpaper and stock photography websites.

Features of plugin include:

* support different images formats. (PNG, JPG, JPEG, GIF)
* Intelligent sizing - No image distortion!
* Resize by exact width/height. (exact)
* Auto determine - let the script determine how to handle it. (auto)
* Resize, then crop, with exact size and no distortion. (crop)
* Automatic download after resize.
* Powerful shortcode.

= Languages =

1. English
2. Persian (fasri)

= Notes =

Automatic download works with a wide range of devices and browsers.

You can expect it to work for the vast majority of your users, with some common-sense limits:

* Devices without file systems like iPhone, iPad, Wii, et al. have nowhere to save the file to, sorry.
* Android support starts at 4.2 for the built-in browser, though chrome 36+ and firefox 20+ on android 2.3+ work well.
*Devices without Blob support won't be able to download Blobs or TypedArrays
* Legacy devices a[download] support can only download a few hundred kilobytes of data, and can't give the file a custom name.
* Devices without window.URL support can only download a couple megabytes of data
* IE versions of 9 and before are NOT supported because the don't support a[download] or dataURL frame locations.

== Installation ==

Using the Plugin Manager

1. Click Plugins
2. Click Add New
3. Search for `picowall`
4. Click Install
5. Click Install Now
6. Click Activate Plugin

Manually

1. Upload `picowall` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress and enjoy :)

== Changelog ==

= 1.0 =
* Hello World.

== Function Reference ==

there is two way to use this plugin, function and shortcode.

= shortcode =


if you're not familiar with programming. then use picowall shortcode to setup the script without programming knowledge.

shortcode attributes:

* size (required) - you should at least define a width and height or you can define multiple size blocks.
* option (optional) (default:auto) - define the way that you want to resize (auto|exact|crop) if you don't define this attribute then script will automatically decide how to handle it keep in mind that this attribute is global and has same effect on multiple sizes.
* sep (optional) (default: non breaking space " ") - how do you want to separate the links ?

**examples**

resize to exact width/height: [picowall size="800,600" option="exact"]

resize to exact width/height (multiple size): [picowall size="800,600|1920,1080" option="exact"]

resize then crop the first one and then for other ones just resize to exact width/height and then separate the results with a dash (pretty cool huh ?!)

picowall[size="800,600,crop|1920,1080|150,150" option="exact" sep="-"]

you can see that i use a different syntax in the last example. but what is that ?

that i like to say is a "setting block". it means that you can define multiple sizes with different ways to resize. simply just define it like this

with,height,option|width,height,option| .... width(n),height(n),option(n).

 pipe symbol (|) will separate the setting blocks.

keep in mind that if you don't define option for a setting block then the value of option attribute will effect on that block. and if you don't define any option there, then the script will automatically decide


= functions =

**picowall($size,$option,$id)**

this function will return an array of links that resize script generated.

**parameters**

* $size (required) - just like the shortcode you can define setting blocks too
* $option  (optional) (default: 'auto')- same as option attribute in shortcode.
* $id (optional) (default: null) - if you use this function out side the loop then you have to define the id of post that you want to fetch photo from.

**picowall_generate_links($size,$option,$sep,$id)**

this function will return an html output of links that resize script generated.

**parameters**

* $size (required) - just like the shortcode you can define setting blocks too
* $option  (optional) (default: 'auto')- same as option attribute in shortcode.
* $sep (optional) (default: non breaking space " ") - same as sep attribute in shortcode.
* $id (optional) (default: null) - if you use this function out side the loop then you have to define the id of post that you want to fetch photo from.
