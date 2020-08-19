<?php
    /**
     * Class ESXi
     *
     * Mahan | Core connect to ESXi server
     *
     * @package    App\Core
     * @author     Milad Abooali <m.abooali@hotmail.com>
     * @copyright  2012 - 2020 Codebox
     * @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
     * @version    1.0.0
     */

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');
    ini_set("soap.wsdl_cache_enabled", 0);

    use soapclient;



    class ESXi
    {

        public $returnval, $lasserror;
        private $soap, $soapLoad = false;

        /**
         * ESXi constructor.
         * @param $host
         */
        function __construct($host)
        {
            $this->loadSoap($host);
        }

        /**
         * Load SOAP
         * @param $host
         * @return bool
         */
        function loadSoap($host)
        {
            if ($this->soapLoad == true) return false;
            $wsdl  = 'https://' . $host . '/sdk/vimService.wsdl';
            $sdk   = 'https://' . $host . '/sdk';
            $noSSL = stream_context_create(array(
              'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
              )
            ));
            $options = array(
              'location' => $sdk,
              'trace' => 1,
              'stream_context' => $noSSL,
              'exceptions' => true
            );
            try {
                $this->soap = new soapclient($wsdl, $options);
                $this->soapLoad = true;
                M::aLog('core', "Soap loaded for <b style='color:blueviolet'>$host</b>", 0, 'EXSi');
                return true;
            } catch (Throwable $e) {
                M::aLog('core', $e->getMessage(), 1, 'EXSi');
                return false;
            }
        }

    }