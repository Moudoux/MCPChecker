# MCPChecker
MCPChecker is a simple tool to check if MCP mappings is out for a specific Minecraft version. Note: This tool is made to run on Unix based systems.

### Installing

First download the MCPChecker.php file then setup a cronjob to run the php script every X minutes. 

This tool requires PEAR mail to work, so let's install PHP7, Pear Mail and Curl:

```sh
$ sudo apt-get install php7.0
$ sudo apt-get install curl
$ sudo apt-get install php7.0-curl
$ sudo apt-get install php-pear
$ sudo pear install mail
$ sudo pear install Net_SMTP
$ sudo pear install Auth_SASL
$ sudo pear install mail_mime
```

Now let's install the MCPChecker

```sh
$ mkdir MCPChecker
$ cd MCPChecker
$ wget https://raw.githubusercontent.com/Moudoux/MCPChecker/master/MCPChecker.php
```

Now add the MCPChecker.php to your crontab using `$ sudo crontab -e`

### Setup

After you've installed the tool you need to set it up. Go into the MCPChecker.php and edit the email server settings:

```php
$from = '';
$host = '';
$port = 587;
$username = '';
$password = '';
```

You also need to change `$EMAIL_TO = '<Your email address>';` to your own email address.

Now we can choose what Minecraft version we want it to look for, we can do this by setting this variable: `$MCP_VERSION = '1.11.1';`
