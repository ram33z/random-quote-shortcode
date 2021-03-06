# Random Quotes WordPress Plugin

This plugin enables the usage of `[random_quote]` shortcode, which will display random quote from Random Quotes API.

## Installation

Once downloaded just unzip it and move the folder into the `/wp-content/plugins` folder within your WordPress install.

## Usage

Put `[random_quote]`anywhere in Post content area or in `custom_html` block of wigets.

### Attributes

Following attributes are supported to customize behaviour of `[random_quote]` shortcode:

-   _length_ : Provide numeric value to limit display of number of characters in Quote. If trimmed, elipses _..._ are added at the end.
-   _class_ : To replace css class in enclosing html element for Quote. By default _blockquote_ class is added.
-   _api_: If value `false` provided then an API call will be omitted and random quote from local static Quotes list will be shown.

#### Example with attribute

`[random_quote api='false' class='strong' length='20']`

### To display shortcode in header or footer areas add following in your theme's template:

`<?php echo do_shortcode("[random_quote]"); ?>`

## Resources

-   [Quotable](https://github.com/lukePeavey/quotable#live-examples) : Quotable is a free, open source quotations API.
