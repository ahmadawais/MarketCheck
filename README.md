## MarketCheck
* Author:		Ionuț Staicu
* Author URI:	[ionutstaicu.com](http://ionutstaicu.com)

### Overview

MarketCheck is a simple WordPress plugin that modifies the default user registration page by adding a verification form using the [Envato Market API](http://themeforest.net/help/api).

Coupled with BBPress plugin, this will allow you to easily create your own Support Forum while still having all the default functionalities of the registration form that everyone is already familiar with.

### Server requirements
Because we make good use of PHP namespaces, your server should support at least PHP 5.3, but any newer version would work just fine.

### License

MarketCheck is released under GPLv3 - [http://www.gnu.org/copyleft/gpl.html](http://www.gnu.org/copyleft/gpl.html). You are free to redistribute & modify the plugin in either free or commercial products. Please kindly keep all links & credits intact.

### User Guide

1. Download, unzip, and rename folder to "aqua-verifier"
2. Go to **Settings > General** and make the checkbox for `Anyone can register` is checked
3. Go to **Settings > MarketCheck** and fill in all the required fields

### Extensibility guide
In order to add a new market, you need to follow three simple..ish steps:

1. Implement `QueryMarket` methods (for getting the URL and normalizing return values)
2. Implement `MarketSettings` methods (for registering new settings fields)
3. Register the new market (inside of `register-custom-markets.php` file):

```
add_action( 'marketcheck/register-market', function( $fields, $settings, $registerForm, $db ){
	new Envato\Settings();
	$registerForm->addMarket( new Envato\QueryMarket( $settings, $db ) );
}, 10, 4 );

```

(you can take a look inside of `includes/MarketCheck/Markets` folder in order to see how we added first market)

### Bugs, Issues, Feedbacks, Help?

Please report any bugs, issues, feedbacks or get help on the MarketCheck's Issues page on Github - [Issues page](https://github.com/sy4mil/Aqua-Verifier/issues).