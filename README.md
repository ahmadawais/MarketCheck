## MarketCheck
* Author:		Ionuț Staicu
* Author URI:	[ionutstaicu.com](http://ionutstaicu.com)
* Inspired by Aqua Verifier by Syamil MJ

### Overview

MarketCheck is a simple WordPress plugin that modifies the default user registration page by adding a verification form using various markets. E.g. Envato, Mojo and so on (basically any market that provides an API to check a purchase).

Coupled with BBPress plugin, this will allow you to easily create your own Support Forum while still having all the default functionalities of the registration form that everyone is already familiar with.

### Server requirements
Because we make good use of PHP namespaces, your server should support at least PHP 5.3, but any newer version would work just fine.

### License

MarketCheck is released under GPLv3 - [http://www.gnu.org/copyleft/gpl.html](http://www.gnu.org/copyleft/gpl.html). You are free to redistribute & modify the plugin in either free or commercial products. Please kindly keep all links & credits intact.

#### A small note about Aqua Verifier
Although this was initially a fork of Aqua Verifier, I ended up by rewriting almost every piece of code in order to suit my needs.

Here are the main differences between Aqua Verifier and MarketCheck

- it's extensible; If you have products on multiple markets, you can add as many markets as you like;
- it requires PHP 5.3+ (although I tested only on 5.5 it should work with lower versions as well;
- it has some hooks that allows you to... well, hook on user registration success;
- it stores purchases info into a separate DB;
- it doesn't really integrate with anything (so no role sets, no nothing). But since you have hooks, you can extend it in no time to integrate with bbpress or whatever;
- it doesn't have an uninstall routine. Removing the plugin will NOT clear the DB or anything.

I'm also planning to add some extra stuff like:

key management (a registered user to be able to add and maybe delete more purchase keys)

- a badge system (some methods to show a badge on forums);
- an uninstall/reset routine to clear the db if needed;
- a granular permission (e.g. access only certain forums) etc

### User Guide

1. Download & unzip to `wp-content/plugins`
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

Please report any bugs, issues, feedbacks or get help on the MarketCheck's Issues page on Github - [Issues page](https://github.com/iamntz/MarketCheck/issues).