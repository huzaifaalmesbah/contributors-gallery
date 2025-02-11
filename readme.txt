=== Contributors Gallery – The Ultimate WordPress Contributors Showcase ===
Contributors: huzaifaalmesbah
Tags: contributors gallery, wordpress contributors, contributor showcase, wordpress credits
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tested up to: 6.7

Display WordPress contributors beautifully with live profiles, avatars, and powerful search. Showcase the people who make WordPress great.

== Description ==

= WordPress Contributors Gallery – The Ultimate Solution for Showcasing WordPress Contributors =

Contributors Gallery is the most comprehensive WordPress plugin for displaying and managing WordPress version contributors. Our plugin seamlessly integrates with WordPress.org to showcase contributors through elegant profiles, advanced search capabilities, and dynamic version filtering.

https://www.youtube.com/watch?v=somoJEeQcuE

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
```
[wpcg_contributors]
```

2. Search Contributors:
```
[wpcg_contributor_search]
```

= Shortcode Parameters =

The `[wpcg_contributors]` shortcode accepts the following parameters:

* `version`: Specify WordPress version (e.g., "6.4")
* `switcher`: Control version selector visibility ("true"/"false")

Examples:
```
[wpcg_contributors version="6.4"]
[wpcg_contributors switcher="false"]
[wpcg_contributors version="6.4" switcher="false"]
[wpcg_contributors version="6.4" switcher="true"]
```

== Installation ==

= Installation via WordPress Dashboard: =
1. Go to the WordPress dashboard
2. Navigate to **Plugins > Add New**
3. Search for "Contributors Gallery"
4. Click on the **Install** button
5. Activate the plugin after installation

= Installation via Zip File: =
1. Download the **Contributors Gallery** plugin zip file
2. Go to **Plugins > Add New > Upload Plugin**
3. Upload `contributors-gallery.zip` and install it
4. Activate the plugin

= Using the Plugin: =
1. Add contributors gallery using shortcodes:
   * `[wpcg_contributors]` – Display contributors list
   * `[wpcg_contributor_search]` – Add search functionality
2. Customize display using shortcode parameters:
   * Set specific version: `[wpcg_contributors version="6.4"]`
   * Control version switcher: `[wpcg_contributors switcher="false"]`


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

== Check out our other Plugins ==
– **[Smart Password Protect](https://wordpress.org/plugins/smart-password-protect/)** – Secure your WordPress site with password protection and IP whitelisting.
– **[Random Quote](https://wordpress.org/plugins/random-quote/)** – *Display a random quote on your site, inspiring visitors with fresh content every time they refresh the page.*
– **[Redirect After Logout](https://wordpress.org/plugins/redirect-after-logout/)** – *Seamlessly redirect users to a custom page after logging out, enhancing user experience on your WordPress site.*
– **[Product Spotlight Badge](https://wordpress.org/plugins/product-spotlight-badge/)** – Highlight special products with a customizable spotlight badge on your WooCommerce store.

== Changelog ==
= 1.2.0 =
* Added WordPress.org profile integration
* Enhanced contributor profiles with detailed metadata
* Added avatar hash extraction from WordPress.org profiles
* Added comprehensive profile service documentation
* Enhanced contributor search results with profile data

= 1.1.1 =
* Enhanced layout and visual presentation
* Improved spacing and alignment of contributor elements
* Added consistent padding and margins
* Optimized grid layout for better responsiveness
* Refined avatar display and text formatting
* Added subtle hover effects for better interactivity
* Fixed minor visual inconsistencies

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