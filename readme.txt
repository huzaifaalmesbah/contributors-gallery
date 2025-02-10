=== Contributors Gallery ===
Contributors: huzaifaalmesbah
Tags: contributors, credits, core-contributors, wordpress-contributors, contributor-search
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tested up to: 6.7

Display WordPress version contributors beautifully with avatars, profile links, and powerful search functionality.

== Description ==

WordPress Contributors Gallery is a powerful yet simple plugin that showcases the contributors who have made WordPress what it is today. The plugin fetches contributor data directly from WordPress.org and displays it in an elegant, responsive layout with comprehensive search capabilities.

= Key Features =

* **Comprehensive Display**: Show contributors from any WordPress version (3.2 onwards)
* **Advanced Search**: Find specific contributor and view their contribution history
* **Interactive Version Selector**: Switch between WordPress versions seamlessly
* **Contributor Categories**:
  * Noteworthy Contributors (Core & Contributing Developers)
  * Core Contributors (Props)
* **Rich Visual Elements**:
  * Beautiful avatar display for noteworthy contributors
  * WordPress.org profile links
  * Responsive, modern design
* **Performance Optimized**:
  * Built-in 24-hour caching
  * AJAX-powered version switching
  * Lightweight implementation

= Available Shortcodes =

1. Display Contributors List:
`[wpcg_contributors]`

2. Search Contributors:
`[wpcg_contributor_search]`

= Shortcode Parameters =

The `[wpcg_contributors]` shortcode accepts the following parameters:

* `version`: Specify WordPress version (e.g., "6.4")
* `switcher`: Control version selector visibility ("true"/"false")

Examples:
```
[wpcg_contributors version="6.4"]
[wpcg_contributors switcher="false"]
[wpcg_contributors version="6.4" switcher="true"]
```

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/contributors-gallery` directory, or install through WordPress plugins screen
2. Activate the plugin through the 'Plugins' menu
3. Use shortcodes to display contributors:
   * `[wpcg_contributors]` - Display contributors list
   * `[wpcg_contributor_search]` - Add search functionality

== Frequently Asked Questions ==

= How does the contributor search work? =

The search functionality allows users to find specific contributors across all WordPress versions. It displays:
* Their display name and role (if available)
* Noteworthy contributions (Core & Contributing Developer roles)
* Core contributions (Props)
* Total contribution count by category

= How do I display contributors for a specific version? =

Use the version parameter: `[wpcg_contributors version="6.4"]`

= Can I control the version selector visibility? =

Yes, use the switcher parameter:
* Show selector: `[wpcg_contributors switcher="true"]`
* Hide selector: `[wpcg_contributors switcher="false"]`

= What WordPress versions are supported? =

The plugin supports WordPress version 3.2 onwards, providing comprehensive coverage of WordPress's development history.

= How often is the contributor data updated? =

The plugin caches data for 24 hours to ensure optimal performance while maintaining data freshness.

= Can I customize the display styles? =

Yes, you can override the default styles by adding custom CSS to your theme. The plugin uses clean, semantic HTML classes for easy styling.

== Changelog ==

= 1.1.0 =
* Added contributor search functionality with comprehensive history display
* Enhanced version selector with support from WordPress 3.2 onwards
* Improved version management using WordPress.org API
* Added natural version sorting for better organization
* Added contributor version history in search results
* Added WordPress.org profile links in search results
* Optimized version fetching performance
* Added comprehensive documentation

= 1.0.2 =
* Enhanced API service with improved caching
* Added WPVersionFetcher service for better version management
* Improved code documentation and inline comments

= 1.0.1 =
* Added version selector improvements
* Added version switcher attribute for shortcode

= 1.0.0 =
* Initial release
* Basic contributors display functionality
* Responsive design implementation