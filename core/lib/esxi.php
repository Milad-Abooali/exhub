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

    use Exception;
    use soapclient;
    use SoapFault;


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
            $this->_loadSoap($host);
        }

        /**
         * Load SOAP
         * @param $host
         * @return bool
         */
        private function _loadSoap($host)
        {
            if ($this->soapLoad == true) return false;
            $wsdl = 'https://' . $host . '/sdk/vimService.wsdl';
            $sdk = 'https://' . $host . '/sdk';
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
                M::aLog('core', "Soap loaded for <b style='color:blue'>$host</b>", 0, 'EXSi');
                return true;
            } catch (SoapFault $e) {
                M::aLog('core', $e->getMessage(), 1, 'EXSi');
                return false;
            }
        }

        /**
         * Initials SOAP
         * @param $host
         * @return bool
         */
        private function init ($host) {
            if (!$this->soapLoad == true) return false;
            try {
                $response = $this->soap->RetrieveServiceContent(array('_this'=>'ServiceInstance'));
            } catch (Exception $e) {
                M::aLog('core', $e->getMessage(), 1, 'EXSi');
                return false;
            }
            $this->returnval=$response->returnval;
            return true;
        }

        /**
         * Login to host
         * @param $host
         * @param $user
         * @param $password
         * @return bool|int
         */
        private function login ($host, $user, $password) {
            $retval = $this->init($host);
            if($retval==false) return false;
            try	 {
                $session = $this->returnval->sessionManager;
                $response = $this->soap->Login(array('_this'=>$session,'userName'=>$user,'password'=>$password));
                return 1;
            } catch (Exception $e) {
                if($e->getMessage()=='Cannot complete login due to an incorrect user name or password.')
                    return 2;
                M::aLog('core', $e->getMessage(), 1, 'EXSi');
                return false;
            }
        }

    }