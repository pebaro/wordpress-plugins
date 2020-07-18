# wordpress-plugins
# Demonstration of some of the plugins I built for WordPress on behalf of Imagination Technologies


# List of Projects:

# 1 - elementor-imgtec
#     This plugin extends the Elementor page builder. At the time we had no widgets offering modals which we needed for a couple of pieces of work. I had also been building animations with AnimateCC that were being used at the time and we wanted a way to more easily integrate the final outputs into Elementor.
#     Modal Widget
#     Animate CC integration Widget

# 2 - _imgtec-required
#     This plugin consolidates all of the custom data produced for the imgtec theme
#     Included are all of the custom post types and custom taxonomies, custom widgets and custom admin to manage everything from one place
#     I also included a custom menu system which reduces the number of listings in the left-hand column making everything neat and concise
#     Also included is an extra feature that was added later enabling the user to request our press kit
#     Requests for the press kit would be sent via email to the admin who could then approve or deny the request
#     All press kit request are handled in their own custom admin panel

# 3 - _imgtec-live-search
#     This plugin uses the WP Rest API to search through all of the website data across all custom post types and standard posts and pages
#     I also included a unique feature that allows the user to save their searches as a serious of tabs for quick use when they next enter the site search
#     I used the browser's LocalStorage feature as a way to handle the storage of search terms and deletion of terms when desired
#     This plugin needs to run in conjunction with the _imgtec-required plugin and the data associated with the custom post types

# 4 - _imgtec-university-programme
#     This plugin does pretty much the same thing as the _imgtec-required plugin. This plugin was used when the Imagination University Programme was housed in it's own seperate website.
#     Again this plugin handles all the custom post types, custom taxonomies, custom menu systems and custom admin

# 5 - _imgtec-cron-manager
#     This plugin was built to handle CRON events associated with the custom download manager plugin

# 6 - _imgtec-download-manager
#     This plugin was built for use as a download manager
#     Features include the ability to gate content, making the user request certain downloads via the entry of data into a form that changes depending on which request route they select. The request routes where built in conjunction with ACF Pro plugin.
#     Once the user requests the download the admin receives an email with all of the form information provided by the user
#     Next the admin can either approve, deny, send to the team for discussion from a custom admin panel that displays and manages all download requests
#     The advanced custom fields pro plugin is required for use with this plugin as well as the associated setup of ACF Pro
