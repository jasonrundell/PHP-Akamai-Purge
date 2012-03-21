<?php
/*************************
 *
    PHP Akamai Purge
 *
    By: Jason Rundell <jason dot rundell (at) gmail dot com> http://jasonrundell.com @jasonrundell
    Started: December 20th 2011
    Fork me: https://github.com/jasonrundell/PHP-Akamai-Purge
    Cudos: https://github.com/hradtke http://hermanradtke.com @hermanradtke
        I came across https://bugs.php.net/bug.php?id=43910 while doing a Google search for
        other folks who have worked with Akamai's SOAP API and PHP. The original function
        pap_purge() function was started from the code hradtke@php.net provided publicly.
        Jan 9, 2012 - I did some digging and I believe we have https://github.com/hradtke
        to thank! How many hradtke could there be, right? :)
        Jan 9, 2012 - Emailed hradtke and it's confirmed. Thanks Herman Radtke!
		Jan 10, 2012 - Dustin Hood @dustinhood tweeted me with Akamai documentation
		and later in emails provided the method for getting email notifications.

    Server requirements:
        SOAP for PHP: http://php.net/manual/en/book.soap.php
        PHP: Version 5.X
 *
**************************/

// the following two named constants are developer preference. I enjoy them :)
// you can of course add in user and password properties to the pap_purge() function.
define("AKAMAI_USER","your_akamai_account_email");
define("AKAMAI_PASSWORD","your_akamai_account_password");
// end of suggested constants

function pap_akamai_purge($url){ // 'pap' stands for Php Akamai Purge

    $client = new SoapClient('https://ccuapi.akamai.com/ccuapi-axis.wsdl'); // xml schema Akamai uses for purging
	
	$options = array('action=invalidate','email-notification='.$email,'domain=production','type=arl'); // email notification is optional. Thanks @dustinhood for the array options.

    try {

        $purgeResult = $client->purgeRequest(AKAMAI_USER, AKAMAI_PASSWORD, '', array(), array($url));
        // once you have $purgeResult, you can handle the results any way you'd prefer.

        // the following lines are just a suggestion
        if ($purgeResult->resultCode==100) { // 100 = success

            return "Purge Success for: $url</br>";

        } else {

            return "Something went wrong. Akamai purge request failed: $purgeResult->resultCode</br>";

        }
        // end of suggestion

    } catch(SoapFault $e) {

        return "Something went wrong. Akamai purge request failed: $e</br>";

    }

}