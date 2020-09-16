=== WP Mail SMTP by Mail Bank ===
Contributors: contact-banker, Gallery-Bank, wordpress-empire
Donate link: https://tech-banker.com/wp-mail-bank/
Tags: smtp, wp mail smtp, wordpress smtp, gmail smtp, sendgrid smtp, mailgun smtp, mail, mailer, phpmailer, wp_mail, email, mailgun, sengrid, gmail, wp smtp
Requires at least: 3.8
Tested up to: 5.5
Stable Tag: trunk
Requires PHP: 5.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Mail Bank is a Wordpress SMTP Plugin that solves email deliverability issue. Configures Gmail Smtp Settings, OAuth, and any SMTP server. Reconfigures wp_mail().

== Description ==

### WP Mail Bank: The #1 WordPress Mail SMTP Plugin

[**WP Mail Bank — Tech Banker**](https://tech-banker.com/wp-mail-bank/)
* **[Detailed Features](https://tech-banker.com/wp-mail-bank/)**
* **[Back End Demos](https://tech-banker.com/wp-mail-bank/demos/)**
* **[Documentation](https://tech-banker.com/blog/)**
* **[Upgrade to Premium Editions](https://tech-banker.com/wp-mail-bank/pricing/)**

Are you **100% confident** all your WordPress emails reach their destination?

It's impossible to know what's happening to your emails unless you have a well-designed and well-rounded SMTP plugin installed. ***Explained why and how down below.***

Mail Bank is a **FREE** SMTP plugin that gives you every feature needed to **guarantee fast and 100% confident email deliverability**. This includes a list of features designed to test, log, and control your email deliverability, even over multiple WordPress installations and networks.

This plugin is developed by the in-house team of expert coders at [Tech Banker](https://tech-banker.com). These are the people that will keep bringing you new and improved versions of Mail Bank every day of the week. The plugin updates automatically by default.

Mail Bank is not another copy of WP Mail SMTP like Post SMTP or Easy SMTP Mailer. It provides unique functionality by sending emails with customized Zend Framework.

### An SMTP plugin will solve your email deliverability issues. But how?

We're confident that you'll love Mail Bank. The reason for this is that our plugin is one of the most reliable ways to fix email deliverability issues, as we understand what causes them. Let me explain.

There are many reasons why you might need an SMTP plugin. The most common reasons are poor authentication or your host blocking email delivery. The less common is bulk mail overload and being marked as a spammer due to it. This is why we have respective features for both situations. The email logger being the most important. Here are the reasons in detail:

* **Your host might have PHPmailer disabled.** In this situation, your WP emails are plain and simple not delivered, as WordPress uses the PHPmailer by default to send mail.

* **Poor authentication due to PHPmailer.** It's a very complicated process to set up PHPmailer properly on a small WordPress site. In most cases trying to set up PHPmailer will result in your emails being either undelivered or being sent to the Spam folders. The cause for this is that PHPmailer doesn't use any sort of authentication. The email service providers don't know whether the emails they're receiving are coming from a legitimate sender or not.

* **Bulk sending overload can happen even on SMTP.** If you send hundreds of emails per day via a free SMTP provider you might be a victim of a lesser known problem. Sending this many emails puts a lot of load on the undedicated SMTP provider's servers. Only a dedicated server such as Mailgun's or SendGrid's can handle large loads of outgoing emails daily. Install our plugin and see our email logger.

### Where does WP Mail Bank come into this?

It reconfigures the wp_mail() function so you can set up your own outgoing email settings. You can use almost any SMTP service provider with our plugin.

This prevents the core issues with **Sender Domain Policy** and **Spoofing**, which are the primary causes of undelivered mail.

As said before, Mail Bank also supports the Mailgun and SendGrid APIs. This means that if you're running a website with a larger userbase you'll be able to improve your email deliverability drastically.

Over 50,000+ website owners have chosen [**Mail Bank**](https://tech-banker.com/wp-mail-bank/) as their email deliverability solution. Mail Bank fixes email deliverability issues quickly and painlessly.

### Benefits

#### Confident SMTP Email Deliverability

* It gives you a large list of free email service providers to choose from. The most prominent and important being Gmail, Outlook, and Yahoo, which all support oAuth 2.0. But we know larger email senders require more serious solutions. So we've added support for the freemium **Mailgun** with 10,000 free emails per month and **SendGrid** APIs. Both of these APIs will drastically increase WP email deliverability.

* Our **email logger** will give you information on all of your emails. This includes undelivered mail and the information required to debug undelivered mail. You'll also be able to take action on each of the emails or use **bulk actions to delete or resend** them. You'll never have to leave a portion of your users in the dark again with this feature.

* Our customer support team will always help you with any arising issue. Note that **[Premium Edition](https://tech-banker.com/wp-mail-bank/pricing/) Customers** get priority support. If your emails become undelivered, and you can't find a solution in our [documentation](https://tech-banker.com/blog/), we ask you to please [contact us](https://tech-banker.com/contact-us/) at [support@tech-banker.com](mailto:support@tech-banker.com). You may also give us suggestions and feedback on how well we're doing for you. **We care about our customers.**

#### SMTP Security & Flexibility

* Depending on your email service provider, you will be able to choose between oAuth 2.0, Cram-MD5, Simple Login, or Plain Authentication. **oAuth 2.0 is the most secure** and works with Gmail, Outlook365, Outlook, and Yahoo! Using oAuth 2.0 means you won't have to store your username and password in a WordPress database. You'll feel much safer with this. In addition to that, with oAuth 2.0 you won't need to update your credentials if your email account's password changes, it's a set-and-forget feature.

* You will be able to choose between TLS (Transport Layer Security) and SSL (Secure Sockets Layer) encryption. Both encryption methods are valid for use, but we recommend using TLS as it's more secure.

#### Multisite & Teamwork Support

* You'll have support for **WordPress multisite**. You won't have to install Mail Bank on all of the WordPress sites on your network. You'll be able to take full control of all your networked sites from your main installation.

* You'll have the option to set **roles and restrictions** for other users. This is a perfect solution for working in teams. As if something goes wrong with your email service provider or settings you can be alerted by one of your users and no-one but you can touch the SMTP account's settings.

#### Fast & In-Depth Email Setup

* Our **"Email Setup"** tab will guide you and let you create a working connection in seconds. But you'll also have access to a large amount of more complicated settings as well. Just in case you need them.

1. Download, install, and activate Mail Bank on your WordPress hosted site.
2. Open the "Email Setup" tab.
3. Enter your chosen name in the "From Name" tab, and enter a valid email in the "From Email" tab. Or choose not to override. A valid email will be provided by your email service provider or hosted on your domain, e.g. JohnDoe@[your domain].com or your Gmail address. Then, press "Next Step", and you'll be taken to the SMTP account setup screen.
4. Your email address should already be entered, and some default SMTP settings should appear. You can use these settings or set a different mailer type. The default settings for a Gmail SMTP account are: **Mailer Type:** Send Email via SMTP, **Encryption:** TLS Encryption, **SMTP Host:** SMTP.gmail.com **SMTP Port:** 587, **Authentication:** Login. You need to enter your Gmail credentials in this case. If you want to use oAuth 2.0, you'll have to set it up with Google. Check whether you want to send a "Test Email", we recommend leaving this checked.
5. Press "Next Step", and you'll be taken to the "Test Email" screen. If anything's wrong, it will tell you **Email Status : Email Not Sent**. Then, you need to look at the debugging information and recheck your SMTP settings. **Note:** You can't use the "Login" option with Gmail SMTP accounts that have 2-factor authentication enabled, you have to use oAuth 2.0 with secured Gmail SMTP accounts.
6. If all is well you're **done**. If you've gotten stuck, there's a button to ask for help on the test page, and there's a "Help & Support" button on the tab list. Be sure to check your email logs frequently for any trouble.

#### Supports Multiple Languages

Mail Bank is translated by professionals and native speakers in these 16 languages:

* Brazilian
* Portuguese
* Japanese
* Farsi (Iran)
* Arabic
* Polish
* Vietnamese
* Deutsch
* French
* Italian
* Portuguese (Portugal)
* Dutch
* Spanish (Spain)
* Chinese (Mainland China)
* Turkish
* Russian

> Want to help translate the plugin to another language? Contact us at [support@tech-banker.com](mailto:support@tech-banker.com).

#### Easily Import Settings From The Postman SMTP Plugin

* Your Postman settings will be automatically imported to Mail Bank once you migrate.

### Full List of Features

* **Support & Updates for up to 5 Installations:** You'll be able to install on up to 5 seperate WordPress sites. Free users can install only to 1 site.
* **Support for WordPress Multisite:** Premium users will be able to enjoy WordPress multisite network support. Install Mail Bank on your main site, and you'll be able to manage all of your networked sites from a single installation.
* **Technical Support:** Free users will get support on WordPress.org. Premium users will have a seperate, priority support package available off-site.
* **Free & Automatic Updates:** You'll be able to choose whether your plugin is updated automatically or not. All updates come for free.
* **Compatibility With All Major Plugins**: It is compatible with almost all of the WordPress plugins available. We're constantly bringing out compatibility updates.
* **Email Setup Wizard:** The Email Setup tab is a quick and painless way to get you going in seconds. It includes fields such as: "From Name", "From Email", "Reply To", "CC", "BCC", and "Additional Headers".
* **SMTP Support:** You'll have support for almost every FREE SMTP provider, and that includes the Mailgun and SendGrid APIs.
* **Authentication Options:** You'll be able to login using your username and password, or the more secure **oAuth 2.0**. There are also options for no authentication and plain login.
* **Test Emails:** Test Emails will give you quick feedback on how your configuration is doing. Full debugging information will be provided, as well as a button to contact our support team.
* **Debug Mode & Email Logging Settings:** Debugging information and email logging can be turned on or off in the Plugin Settings tab.
* **SMTP Server Port Testing / Connectivity Test:** The "Connectivity Test" tab will reveal to you which ports your SMTP provider has opened for you.
* **Encryption:** You'll be able to choose between SSL, TSL, and no encryption.
* **Email Logs:** Will give you an overview of sent emails. It will let you take action on undelivered emails.
* **Roles & Capabilities:** Will let you set different kinds of restrictions to different kinds of users. This includes creating your own custom entries for users.

> Some of these features are only available in the **[Premium Edition](https://tech-banker.com/wp-mail-bank/pricing/)** of the plugin. You can purchase the plugin on [our site at: https://tech-banker.com/wp-mail-bank/](https://tech-banker.com/wp-mail-bank/)

### Error Messages

#### Communication Error [334] make sure the Envelope From Email is the same account used to create the Client ID.

* This is usually caused by being logged in to Google/Microsoft/Yahoo with a different user than the one Mail Bank is configured to send mail with. Log out and try again with the correct user.
* Login to your email provider and see if there is an "Unusual Activity" warning waiting for your attention.

#### Could not open socket

* Your host may have installed a firewall between you and the server. Ask them to open the ports.
* Your may have tried to (incorrectly) use SSL over port 587. Check your encryption and port settings.

#### Operation Timed out

* Your host may have poor connectivity to the mail server. Try doubling the Read Timeout.
* Your host may have installed a firewall (DROP packets) between you and the server. Ask them to open the ports.
* You may have tried to incorrectly use TLS over port 465. Check your encryption and port settings.

#### Connection refused

* Your host has likely installed a firewall (REJECT packets) between you and the server. Ask them to open the ports.

#### 503 Bad sequence of commands

* You configured TLS security when you should have selected no security.

#### XOAUTH2 authentication mechanism not supported

* You may be on a Virtual Private Server that is [playing havoc with your communications](https://wordpress.org/support/topic/oh-bother-xoauth2-authentication-mechanism-not-supported?replies=9). Jump ship.

### Mail ends up in the Spam folder

To avoid being flagged as spam, you need to prove your email isn't forged. On a custom domain, **it's up to you** to set that up.

* Ensure you're using the correct SMTP server with authentication - the correct SMTP server is the one defined by your email service's SPF record.
* If you use a custom domain name for email, add an [SPF record](http://www.openspf.org/Introduction) to your DNS zone file. The SPF is specific to your email provider, for example [Google](https://support.google.com/a/answer/33786).
* If you use a custom domain name, add a DKIM record to your DNS zone file and upload your Domain Key (a digital signature) to, for example [Google](https://support.google.com/a/answer/174124?hl=en).

### Welcome Screen

Mail Bank redirects you to a **Welcome Screen** on activation, and asks you to either **Skip** or **Opt-In** for sending us non-sensitive information about your website.

In case of a **Skip**, we send the following information to our server at http://stats.tech-banker-services.org

* Site URL, WordPress language used.
* Status of plugin, activation, deactivation, uninstall.

In case of an **Opt-In**, we send the following information to our server at http://stats.tech-banker-services.org

* Name & Email Address.
* Site URL, WP version, PHP info, plugins & themes info.
* Display updates & announcements.
* Status of plugin at activation, de-activation, uninstall

### Technical Support

If you you've found a bug in our plugin or have questions please contact us at [support@tech-banker.com](mailto:support@tech-banker.com).

Please use the support forum on WordPress.org only for the free **Standard Version** of the plugin.

For the **[Premium Edition](https://tech-banker.com/wp-mail-bank/pricing/) Customers** there is a seperate, priority support package available. Please, don't use the WordPress.org support forum for questions about the [Premium Edition](https://tech-banker.com/wp-mail-bank/pricing/) of Mail Bank.

### Contact Us

* [https://tech-banker.com/contact-us/](https://tech-banker.com/contact-us/)

== Installation ==

### Minimum requirements
*   WordPress 3.6+
*   PHP 5.3.9+
*   MySQL 5.x

### Performing a new installation

After downloading the ZIP file,

1. Log in to the administrator panel.
2. Go to Plugins Add > New > Upload.
3. Click "Choose file" ("Browse") and select the downloaded zip file.

* **For Mac Users**
Go to your **Downloads folder** and locate the folder with the plugin. Right-click on the folder and select **Compress**. Now you have a newly created .zip file which can be installed as described here.

1. Click "Install Now" button.
2. Click "Activate Plugin" button for activating the plugin.

If any problem occurs, please contact us at [support@tech-banker.com](mailto:support@tech-banker.com).

== Frequently Asked Questions ==

= What are Email Logs Entries? =

You can view detailed records of logged emails such as Date/Time, Debugging Output, Email To, Subject and Status.

= What is a Debug Mode? =

You can enable or disable the debug mode to get the debugging output of logged emails.

== Screenshots ==

1. Setup Wizard - Basic Info
2. Setup Wizard - Account Setup - This is the PHPMailer setup screen.
3. Setup Wizard - Account Setup - This is the SMTP account setup screen.
4. Setup Wizard - Account Setup - This is the Mailgun API account setup screen (Pro Edition).
5. Setup Wizard - Account Setup - This is the Sendgrid API account setup screen (Pro Edition).
6. Setup Wizard - Confirm - This is the confirmation screen to test the settings.
6. Setup Wizard - Confirm - This is the output of the email sent with debug mode.
7. Setup Wizard - Confirm - This is the output of the email sent with debug mode.
8. Connectivity Test
9. Email Reports with Charts
10. Notifications - Email Notification Setup
11. Notifications - Push Over Setup
12. Notifications - Slack Setup
13. General Settings
14. Roles & Capabilities
15. System Information

== Changelog ==

= 4.0.11 =

* FIX: Minor Bugs

= 4.0.10 =

* TWEAK: CSS Confliction Fixed

= 4.0.9 =

* Encoding Error Fixed

= 4.0.8 =

* FIX: Date Bug Fixed
* TWEAK: Wizard Icon Removed

= 4.0.7 =

* FIX: Phpcs Bug Fixed

= 4.0.6 =

* FIX: Bug Fixed

= 4.0.5 =

* FIX: Banners Removed

= 4.0.4 =

* FIX: Minor Bugs Fixed
* FIX: Banner Modified

= 4.0.3 =

* FIX: Minor Bugs Fixed

= 4.0.2 =

* TWEAK: Banner Added

= 4.0.1 =

* FIX: Google OAuth Confliction
* FIX: Minor Bugs
* TWEAK: Links Added to Setup Guides
* TWEAK: Complete New Layouts
* FEATURE: Charts for Email Stats
* FEATURE: Dashboard Widget for Email Stats

= 3.0.67 =

* FIX: Minor Bugs

= 3.0.66 =

* FIX: Google OAuth Confliction

= 3.0.65 =

* FIX: Google SMTP

= 3.0.64 =

* FIX: System Information

= 3.0.63 =

* FIX: Multisite Bug

= 3.0.62 =

* TWEAK: GDPR Message Changed
* TWEAK: Multisite Network Settings Added

= 3.0.61 =

* TWEAK: Readme updated

= 3.0.60 =

* TWEAK: GDPR Compliance

= 3.0.59 =

* TWEAK: Links Added to Google oAuth API for help

= 3.0.58 =

* TWEAK: Message Notification about Possible Conflictions with Other SMTP Plugins.

= 3.0.57 =

* TWEAK: Email Log recorded when emails are sent using PhpMailer.

[See changelog for all versions](https://plugins.svn.wordpress.org/wp-mail-bank/trunk/changelog.txt)

== Upgrade Notice ==

* WP Mail Bank is now 100% Compatible with PHP Versions >= 5.4
