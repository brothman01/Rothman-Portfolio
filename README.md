# Rothman-Portfolio
[![WPCS check](https://github.com/brothman01/Rothman-Portfolio/actions/workflows/wpcs.yml/badge.svg?branch=main)](https://github.com/brothman01/Rothman-Portfolio/actions/workflows/wpcs.yml)[![CSS Lint](https://github.com/brothman01/Rothman-Portfolio/actions/workflows/css-lint.yml/badge.svg)](https://github.com/brothman01/Rothman-Portfolio/actions/workflows/css-lint.yml)[![License](https://img.shields.io/badge/license-GPL--2.0-brightgreen.svg)](https://github.com/brothman01/wp-monitor/blob/master/license.txt) [![PHP >= 8.2](https://img.shields.io/badge/php-%3E=%208.2-8892bf.svg)](https://secure.php.net/supported-versions.php) [![WordPress >= 6.3](https://img.shields.io/badge/wordpress-%3E=%206.3-blue.svg)](https://wordpress.org/download/release-archive/)  

A plugin I created for my personal site to display my portfolio in an intuitive way for users to enjoy.<br />
<br />
## How To Use:
1. The site administrator creates items of the "Portfolio Item" custom post type on the WordPress dashboard for each item they want to display.  Custom fields have been added to any posts of type "Portfolio Item" so that creating them and filling out their information is intuitive.
2. The administrator adds the portfolio page using a block written with react or shortcodes written in PHP depending on their preference.  The block queries the database for all posts of type "Portfolio Item" and diplays that data in a visually-pleasing grid on the page where the block or shortcode was added.
3. (only if installing from github) Execute the command `git submodule update --init ` from the project root folder to update to the latest version of CMB2.

## FAQ
### How many images can be displayed for a specific portfolio item?
Items have the main image displayed in the grid (the featured image) and up to 5 thumbnail images that users can view while looking at the specific item.

### Which image shows on the portfolio item grid for a given portfolio item?
Whichever image is set to the featured image is the one that shows on the grid.

## Can users view a single portfolio item with all of it's thumbnails and description?
Yes, the permalink for a single portfolio item leads to a page that has been designed to beautifully display the portfolio item including its name, all its thumbnails, an enlarged thumnail that can be selected by the user and other information.
