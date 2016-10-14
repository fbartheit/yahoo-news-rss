<?php

namespace app\components;

class ClientAffJet {

    public static $API_KEY = 'AFBCSBQDX1NPElBDQFVIBAZHBV9CS1YPUAJHV1pGFwxZVlsSVQ8TF1sLVQBNBVtSSQZQVFgdW1hJRlhRGFNFWA==';
    public static $API_KEY_LATEST = 'AFBCSBQDX1NPElBDQFVIBAZHBV9CS1YPUAJHV1pGFwxZVlsSVQ8TF1sLVQBNBVtSSQZQVFgdW1hJRlhRGFNFWA==';
    public static $DEFAULT_HEADER = 'HTTP_X_WL_SIG_CA';
    public static $API_SIG = 'x-wl-sig-ca';
    public static $SITE_ID = '52';

}

/**
 * Class AffJetApi
 * Affiliate Jet Application Programming Interface
 * @version 1.2.2
 */
class AffJetApi extends ClientAffJet {

    const API_VERSION = '1.2.3';
    const API_SERVICE_URL = 'http://d1.arcadesauce.com/sauce/instapi';
    const API_BANNER_URL = 'http://b1.arcadesoda.com/soda/banner';
    const API_TRACKING_PIXEL_URL = 'http://d1.arcadesauce.com/sauce/gtp?r=';
    const API_PARAM_URL = 'http://pages.affiliatejet.com/getCustomParam.php';
    const API_DEFAULT_TICKET = 'm80DN4MDVADgfhrt2ABC';
    const STATUS_OK = 1;
    const STATUS_ERROR = 2;
    const STATUS_REQUIREMENTS_FAILED = 0;
    const RESPONSE_STATUS_PARAM_STATUS = 'STATUS';
    const RESPONSE_STATUS_PARAM_STATUS_MSG = 'STATUS_MSG';
    const RESPONSE_STATUS_PARAM_TRACKING_PIXEL = 'TRACKING_PIXEL';
    const RESPONSE_STATUS_PARAM_INSTALLER_URL = 'INSTALLER_URL';
    const LIMIT_AFFILIATE_URL_ID = 8;
    const LIMIT_LANDING_PAGE_ID = 16;
    const LIMIT_REQUEST_ID = 64;
    const LIMIT_URI = 256;
    const LIMIT_REF = 256;

    //client detection
    public static $cookieName = 'asaucehead';
    protected static $_clientHeaders = array('HTTP_ASAUCEHEAD' => 'asaucehead');

    public static function getRegistrationPixel($codedParam) {
        $url = self::API_ACTION_URL . '?' .
                'p=' . (urldecode($codedParam)) .
                '&a=REGISTRATION' .
                '&remoteIp=' . urlencode($_SERVER['REMOTE_ADDR']);
        //	'&UA='.urlencode(urldecode($_SERVER['HTTP_USER_AGENT']));
        $res = @unserialize(@gzuncompress(@file_get_contents($url)));
        if ($res['status'] == 'OK')
            return array(true, array($res['track_header'], $res['track_body']));
        else
            return array(false);
    }

    public static function getParamFromTicket($codedParam) {
        $url = self::API_PARAM_URL . '?' .
                'p=' . (urldecode($codedParam));

        $res = @file_get_contents($url);

        return $res;
    }

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * AffJetApi::getInstallerCode()
     * clr_download_installer
     * @example
     * 		....
     * 		$res = AffJetApi::getInstallerCode();	// AffJetApi::getInstallerCode($_GET['a'], $_GET['lp']);
     * 		if ($res[AffJetApi::RESPONSE_STATUS_PARAM_STATUS] == AffJetApi::STATUS_OK)
     * 			print($res[AffJetApi::RESPONSE_STATUS_PARAM_TRACKING_PIXEL]);
     * 		else
     * 			// redirect visitor to another page because hardware/software/country requirements failed
     * 			header('Location: http://example.com');
     *    ....
     *
     * @param <string> $affiliateUrlId (required; WhiteLabel Partner's Affiliate ID)
     * @param <string> $requestId (Unique user ID)
     * @param <int>    $landingPageId (WhiteLabel Partner's Landing Page ID)
     * @return <array> $res (Response from service, array(AffJetApi::RESPONSE_STATUS_PARAM_STATUS  => bool,
     * 													 AffJetApi::RESPONSE_STATUS_PARAM_STATUS_MSG	 => string,
     * 													 AffJetApi::RESPONSE_STATUS_PARAM_TRACKING_PIXEL => string,
     * 													 AffJetApi::RESPONSE_STATUS_PARAM_INSTALLER_URL	 => string)
     */
    public static function getInstallerCode($affiliateUrlId, $requestId = null, $landingPageId = null, $setDefaultTicket = false) {
        if (!$affiliateUrlId) {
            error_log("AffJetApi::getInstallerCode(): Required parameter not set {\$affiliateUrlId}");
            return (self::STATUS_ERROR);
        }


        $params = array('visitor_ip' => $_SERVER['REMOTE_ADDR'],
            'referrer' => (isset($_SERVER['HTTP_REFERER']) ? substr($_SERVER['HTTP_REFERER'], 0, self::LIMIT_REF) : ''),
            'user_agent' => (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''),
            'sig' => (isset($_SERVER[self::$DEFAULT_HEADER]) ? $_SERVER[self::$DEFAULT_HEADER] : ''),
            'sid' => substr($affiliateUrlId, 0, self::LIMIT_AFFILIATE_URL_ID),
            'request_id' => substr($requestId, 0, self::LIMIT_REQUEST_ID),
            'uri' => substr("{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", 0, self::LIMIT_URI),
            'page' => substr($landingPageId, 0, self::LIMIT_LANDING_PAGE_ID));

        if ($setDefaultTicket)
            $_GET['ticket'] = AffJetApi::API_DEFAULT_TICKET;
        if (isset($_GET['ticket']) && $_GET['ticket'] != '')
            $params['ticket'] = $_GET['ticket'];
        else
            $params['api_key'] = (($_COOKIE['affJetAPI'] == 'new') ? self::$API_KEY_LATEST : self::$API_KEY);

        if (isset($_GET['debug'])) {
            echo '<h2>PARAMS</h2><pre>';
            var_dump($params);
        }

        $params = gzcompress(serialize($params), 9);


        $reponse = self::serviceRequest(self::API_SERVICE_URL, $params);
        if (isset($_GET['debug'])) {
            echo '<h2>RESPONSE RAW</h2><pre>';
            var_dump($reponse);
            echo '<h2>RESPONSE </h2><pre>';
            var_dump(unserialize(@gzuncompress($reponse)));
            echo '</pre>';
        }


        if ($reponse === '') {
            error_log("AffJetApi::getInstallerCode(): No response or connection timeout from {AffJetApi::API_SERVICE_URL}");
            return (self::STATUS_ERROR);
        }

        return ((($retVal = unserialize(@gzuncompress($reponse))) !== false) ? $retVal : AffJetApi::STATUS_ERROR);
    }

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    /*
     * AffJetApi::getPageHeader()
     *
     * Content from this method needs to be included on every page on
     * 	site in order to properly use AffJetApi::userHaveInsaller()
     *
     * @example
     * 		....
     * 		<head>
     * 			<title>Test</title>
     * 			<?= AffJetApi::getPageHeader() ?>
     * 		</head>
     */
    public static function getPageHeader() {
        self::userHasInstaller();
        return ('<script type="text/javascript">var getConfig = true;</script>');
    }

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * AffJetApi::userHasMainInstaller()
     * 	Checking does visitor have main installer installed
     *
     * @example
     * 		....
     * 		if (AffJetApi::userHasMainInstaller())
     * 			print 'Thank you for downloading Installer';
     *    ....
     *
     * @return <bool>
     *
     */
    public static function userHasMainInstaller() {
        return (self::userHasInstaller() && isset($_SERVER[self::$DEFAULT_HEADER]) && ($sig = $_SERVER[self::$DEFAULT_HEADER]) && strpos(substr($sig, 0, strpos($sig, ';')), self::$API_SIG) !== false);
    }

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * AffJetApi::userHasInstaller()
     * 	Checks does visitor have the installer installed
     *
     * @example
     * 		....
     * 		// landing page
     * 		if (AffJetApi::userHasInstaller())
     * 			// redirect him to another ad
     * 			header('Location: http://example.com');
     *    ....
     *
     * @return <bool>
     *
     */
    public static function userHasInstaller() {
        //return true;
        $retVal = false;
        foreach (self::$_clientHeaders as $headerKey => $headerVal) {
            if (!isset($_SERVER[$headerKey]) && isset($_COOKIE[self::$cookieName]))
                $_SERVER[$headerKey] = trim(self::$cookieName);

            if (isset($_SERVER[$headerKey]))
                $retVal = true;
        }
        return ($retVal);
    }

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * AffJetApi::checkServerRequirements()
     *
     * Checks if server configuration meets the requirements for running White Label API Class;
     * Curl and gzcompress are required
     */
    public static function checkServerRequirements() {
        if (!function_exists('curl_init') || !function_exists('gzcompress'))
            die('Sorry, your server configuration does not satisfy the requirements by AffJet API.' .
                    ' Please make sure that CURL and gzcompress php extension/function are present');
    }

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * AffJetApi::serviceRequest()
     * Communication with API servers
     */
    protected static function serviceRequest($url, $content) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AffiliateJet API');
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: binary',
            'Content-length: ' . strlen($content),
            'Connection: Keep-Alive',
            'WLPS-VERSION: ' . self::API_VERSION,
            'WLPS-TMS: ' . time()));
        $response = curl_exec($ch);
        curl_close($ch);

        return ($response);
    }

    public static function getClientHeaders() {
        return self::$_clientHeaders;
    }

    public static function getBrowserAddonType() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/') !== FALSE)
            return 'ff';
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/') !== FALSE)
            return 'gc';
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE/') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/') !== FALSE)
            return 'ie';
        return 'other';
    }

}
?>

