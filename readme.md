# Random Quotes WordPress Plugin
This plugin enables the usage of `[custom_quote]` shortcode, which will display random quote from Random Quotes API.

## Installation
Once downloaded just unzip it and move the folder into the `/wp-content/plugins` folder within your WordPress install.

## Usage
Put `[custom_quote]`anywhere in Post content area or in `custom_html` block of wigets.

### Attributes
Following attributes are supported to customize behaviour of `[custom_quote]` shortcode:
- *length* : Provide numeric value to limit display of number of characters in Quote. If trimmed, elipses *...* are added at the end.
- *class* : To add css class to enclosing Quote element. By default *blockquote* class is added.
- *no-api*: If present, API call will be omitted and any random quote from local static Quotes list will be shown.

###  To display shortcode in header or footer areas add following in your theme's template:
`<?php echo do_shortcode("[custom_quote]"); ?>`

## Resources
I've compiled a couple resources that were extremely helpful for me when building this plugin.

- [Quotable](https://github.com/lukePeavey/quotable#live-examples) : Quotable is a free, open source quotations API.
