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
    use soapvar;
    use SoapFault;


    class ESXi
    {

        public $returnval, $lasserror;
        private $soap, $soapLoad = false;

        /**
         * ESXi constructor.
         * @param $host
         * @param $user
         * @param $password
         */
        function __construct($host, $user, $password)
        {
            $this->_loadSoap($host);
            $this->_login ($host, $user, $password);
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
        private function _init ($host) {
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
        private function _login ($host, $user, $password) {
            $retval = $this->_init($host);
            if($retval==false) return false;
            try	 {
                $session = $this->returnval->sessionManager;
                $response = $this->soap->Login(array('_this'=>$session,'userName'=>$user,'password'=>$password));
                M::aLog('core', 'Loged in as '.$user, 0, 'EXSi');
                return 1;
            } catch (Exception $e) {
                M::aLog('core', $e->getMessage(), 1, 'EXSi');
                if($e->getMessage()=='Cannot complete login due to an incorrect user name or password.') return 2;
                return false;
            }

        }


        /**
         * Get VM by Name
         * @return array|bool
         */
        public function getVMsByName($ip)
        {
            $ss1 = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $ss2 = new soapvar(array ('name' => 'DataCenterVMTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $a = array ('name' => 'FolderTraversalSpec', 'type' => 'Folder', 'path' => 'childEntity', 'skip' => false, $ss1, $ss2);
            $ss = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $b = array ('name' => 'DataCenterVMTraversalSpec', 'type' => 'Datacenter', 'path' => 'vmFolder', 'skip' => false, $ss);
            $res = null;
            try {
                $res = $this->soap->RetrieveProperties(array('_this'=>$this->returnval->propertyCollector, 'specSet'=>array('propSet'=>array ('type' => 'VirtualMachine', 'all' => false, 'pathSet' => array ('name','config.uuid','runtime.powerState')), 'objectSet'=>array('obj'=>$this->returnval->rootFolder, 'skip'=>false, 'selectSet'=>array(new soapvar($a, SOAP_ENC_OBJECT, 'TraversalSpec'), new soapvar($b, SOAP_ENC_OBJECT, 'TraversalSpec'))))));
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            $vmlist=array();
            foreach($res->returnval as $vm) {
                if (strpos($vm->propSet[1]->val, $ip) !== false) {
                    $vm_id = $vm->obj->_;
                    $name = $status=$uuid='';
                    foreach($vm->propSet as $prop) {
                        if($prop->name=='name')
                            $vmlist[$vm_id]['name']=$prop->val;
                        if($prop->name=='runtime.powerState')
                            $vmlist[$vm_id]['state']=$prop->val;
                        if($prop->name=='config.uuid')
                            $vmlist[$vm_id]['uuid']=$prop->val;
                    }
                }

            }
            return $vmlist;
        }

        /**
         * Get All VMs
         * @return array|bool
         */
        public function getVMs()
        {
            $ss1 = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $ss2 = new soapvar(array ('name' => 'DataCenterVMTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $a = array ('name' => 'FolderTraversalSpec', 'type' => 'Folder', 'path' => 'childEntity', 'skip' => false, $ss1, $ss2);
            $ss = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $b = array ('name' => 'DataCenterVMTraversalSpec', 'type' => 'Datacenter', 'path' => 'vmFolder', 'skip' => false, $ss);
            $res = null;
            try {
                $res = $this->soap->RetrieveProperties(array('_this'=>$this->returnval->propertyCollector, 'specSet'=>array('propSet'=>array ('type' => 'VirtualMachine', 'all' => false, 'pathSet' => array ('name','config.uuid','runtime.powerState')), 'objectSet'=>array('obj'=>$this->returnval->rootFolder, 'skip'=>false, 'selectSet'=>array(new soapvar($a, SOAP_ENC_OBJECT, 'TraversalSpec'), new soapvar($b, SOAP_ENC_OBJECT, 'TraversalSpec'))))));
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            $vmlist=array();
            foreach($res->returnval as $vm) {
                $vm_id = $vm->obj->_;
                $name = $status=$uuid='';
                foreach($vm->propSet as $prop) {
                    if($prop->name=='name')
                        $vmlist[$vm_id]['name']=$prop->val;
                    if($prop->name=='runtime.powerState')
                        $vmlist[$vm_id]['state']=$prop->val;
                    if($prop->name=='config.uuid')
                        $vmlist[$vm_id]['uuid']=$prop->val;
                }
            }
            return $vmlist;
        }


    }