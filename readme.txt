=== Contributors Gallery ===
Contributors: huzaifaalmesbah
Tags: contributors, credits, core-contributors, wordpress-contributors
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tested up to: 6.7

Display WordPress version contributors beautifully with avatars and profile links.

== Description ==

WordPress Contributors Gallery is a powerful yet simple plugin that showcases the contributors who have made WordPress what it is today. The plugin fetches contributor data directly from WordPress.org and displays it in an elegant, responsive layout.

Features:

* Display contributors for any WordPress version (from 3.2 onwards)
* Interactive version selector with comprehensive version support
* Separate sections for noteworthy and core contributors
* Beautiful avatar display for noteworthy contributors
* Links to WordPress.org profiles
* Responsive design that works on all devices
* Easy to use shortcode system with customizable options
* Clean and modern design with smooth transitions
* Lightweight and fast with built-in caching
* AJAX-powered version switching without page reload
* Search functionality to find specific contributors

= Usage =

To display contributors from the latest WordPress version, use the shortcode:
`[wpcg_contributors]`

To display contributors for a specific version:
`[wpcg_contributors version="6.4"]`

To control the version selector visibility (enabled by default):
`[wpcg_contributors switcher="true"]` or `[wpcg_contributors switcher="false"]`

Combine attributes:
`[wpcg_contributors version="6.4" switcher="true"]`

To display the contributor search form:
`[wpcg_contributor_search]`

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpcg` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the shortcode [wpcg_contributors] in your posts or pages
4. To enable search functionality, use the shortcode [wpcg_contributor_search] on any page or post

== Frequently Asked Questions ==

= How do I display contributors for a specific WordPress version? =

Use the version parameter in the shortcode: [wpcg_contributors version="6.4"]

= How do I control the version selector visibility? =

The version selector is enabled by default. You can control its visibility using the switcher attribute:
- To show the selector: [wpcg_contributors switcher="true"]
- To hide the selector: [wpcg_contributors switcher="false"]

This feature was added in version 1.0.1.

= What WordPress versions are supported? =

The plugin supports displaying contributors from WordPress version 3.2 onwards, providing comprehensive coverage of WordPress's development history.

= How often is the contributor data updated? =

The plugin caches the data for 24 hours to ensure optimal performance.

= Can I style the output differently? =

Yes, you can override the default styles by adding custom CSS to your theme.

== Changelog ==

= 1.1.0 =
* Enhanced version selector with support for WordPress versions from 3.2 onwards
* Improved version management using WordPress.org API integration
* Added comprehensive version support documentation
* Optimized version fetching performance

= 1.0.2 =
* Enhanced API service with improved caching
* Added WPVersionFetcher service for better version management
* Improved code documentation and inline comments

= 1.0.1 =
* Added version selector improvements
* Added version switcher attribute for shortcode

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.1.0 =
This update adds comprehensive support for WordPress versions from 3.2 onwards and improves the version selector functionality.

= 1.0.0 =
Initial release

== Privacy Policy ==

This plugin fetches data from WordPress.org's public API. It does not collect, store, or share any personal data from your website's users.