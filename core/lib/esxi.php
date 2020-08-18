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

    ini_set("soap.wsdl_cache_enabled", 0);


    class ESXi
    {

        public $returnval, $lasserror;
        private $soap, $load=false;

        /**
         * Creat SOAP
         * @param $host
         * @return bool
         */
        public function loadSoap($host) {
            if($this->load==true) return false;
            try {
                $NoSSL = stream_context_create(array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                  )
                ));
                $this->soap = new soapclient('https://'.$host.'/sdk/vimService.wsdl', array ('location' => 'https://'.$host.'/sdk', 'trace' => 1,'stream_context' => $NoSSL));
                $this->load=true;
                return true;
            } catch(Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }

        /**
         * @param $host
         * @return bool
         */
        public function init($host) {
            if(!$this->load) $ret=$this->loadSoap($host);
            if(!$ret) return false;
            try {
                $response = $this->soap->RetrieveServiceContent(array('_this'=>'ServiceInstance'));
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            $this->returnval=$response->returnval;
            return true;
        }

        /**
         * @param $host
         * @param $user
         * @param $pass
         * @return bool|int
         */
        function login($host, $user, $pass) {
            $ret=$this->init($host);
            if($ret==false) return false;
            try	 {
                $session=$this->returnval->sessionManager;
                $response = $this->soap->Login(array('_this'=>$session,'userName'=>$user,'password'=>$pass));
                return 1;
            } catch (Exception $e) {
                if($e->getMessage()=='Cannot complete login due to an incorrect user name or password.')
                    return 2;
                echo $e->getMessage();
                return false;
            }
        }

        /**
         * @param $uuid
         * @return bool
         */
        function poweroff($uuid) {
            $info=$this->get_vm_info($uuid);
            try {
                $ret=$this->soap->PowerOffVM_Task(array('_this'=>$info['obj']));
                return $ret;
            } catch(Exception $e) {
                $this->lasserror=$e->getMessage();
                return false;
            }
        }

        function suspend($uuid) {
            $info=$this->get_vm_info($uuid);
            try	{
                $ret=$this->soap->SuspendVM_Task(array('_this'=>$info['obj']));
                return $ret;
            } catch(Exception $e) {
                $this->lasserror=$e->getMessage();
                return false;
            }
        }

        function unsuspend($uuid) {
            return $this->poweron($uuid);
        }

        function poweron($uuid) {
            $info=$this->get_vm_info($uuid);
            try {
                $ret=$this->soap->PowerOnVM_Task(array('_this'=>$info['obj']));
                return $ret;
            } catch(Exception $e) {
                $this->lasserror=$e->getMessage();
                return false;
            }
        }

        function reset($uuid) {
            $info=$this->get_vm_info($uuid);
            try {
                $ret=$this->soap->ResetVM_Task(array('_this'=>$info['obj']));
                return $ret;
            } catch(Exception $e) {
                $this->lasserror=$e->getMessage();
                return false;
            }
        }

        function qout($uuid,$serviceId) {
            $info=$this->get_vm_info($uuid);
            try {
                $ret=$this->soap->Rename_Task(array('newName' =>'Old_'.$serviceId	,'_this'=>$info['obj']));
                sleep (1);
                $ret=$this->soap->PowerOffVM_Task(array('_this'=>$info['obj']));
                sleep (2);
                return $ret;
            } catch(Exception $e) {
                $this->lasserror=$e->getMessage();
                return false;
            }
        }


        function get_vm_info($uuid) {
            $ss1 = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $ss2 = new soapvar(array ('name' => 'DataCenterVMTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $a = array ('name' => 'FolderTraversalSpec', 'type' => 'Folder', 'path' => 'childEntity', 'skip' => false, $ss1, $ss2);
            $ss = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
            $b = array ('name' => 'DataCenterVMTraversalSpec', 'type' => 'Datacenter', 'path' => 'vmFolder', 'skip' => false, $ss);
            $res = null;
            try {
                $res = $this->soap->RetrieveProperties(array(
                  '_this'=>$this->returnval->propertyCollector,
                  'specSet'=>array(
                    'propSet'=>array (
                      'type' => 'VirtualMachine',
                      'all' => false,
                      'pathSet' => array (
                        'name',
                        'config.version',
                        'config.uuid',
                        'config.tools.toolsVersion',
                        'summary.quickStats.uptimeSeconds',
                        'guest.ipAddress',
                        'guest.guestState',
                        'runtime.powerState',
                        'config.hardware.numCPU',
                        'config.hardware.memoryMB',
                        'guest.disk',
                        'summary.quickStats.guestMemoryUsage',
                        'summary.quickStats.overallCpuUsage',
                        'summary.quickStats.overallCpuDemand',
                        'summary.quickStats.distributedCpuEntitlement',
                        'summary.quickStats.ftLogBandwidth',
                      )
                    ),
                    'objectSet'=>array(
                      'obj'=>$this->returnval->rootFolder,
                      'skip'=>false,
                      'selectSet'=>array(
                        new soapvar($a, SOAP_ENC_OBJECT, 'TraversalSpec'),
                        new soapvar($b, SOAP_ENC_OBJECT, 'TraversalSpec')
                      )
                    )
                  )
                ));
            } catch (Exception $e) 	{
                echo $e->getMessage();
                return false;
            }
            foreach($res->returnval as $v) {
                $obj=$v->obj;
                $v=$v->propSet;
                foreach($v as $n) {
                    if($n->name=='config.uuid' && $n->val==$uuid) {
                        $i=array();
                        $i['IP']='';
                        foreach($v as $n) {
                            $i[$n->name]=$n->val;
                            if($n->name=='config.hardware.memoryMB')
                                $i['totalRAM']=$n->val;
                            elseif($n->name=='config.hardware.numCPU')
                                $i['CpuCore']=$n->val;
                            elseif($n->name=='summary.quickStats.overallCpuUsage')
                                $i['CpuUsage']=$n->val;
                            elseif($n->name=='summary.quickStats.guestMemoryUsage')
                                $i['RAMUsage']=$n->val;
                            elseif($n->name=='summary.quickStats.uptimeSeconds')
                                $i['uptime']=$n->val;
                            elseif($n->name=='guest.disk' && gettype($n->val)=='object' && isset($n->val->GuestDiskInfo)) {
                                $i['DiskTotal']=$n->val->GuestDiskInfo->capacity;
                                $i['DiskUsage']=$i['DiskTotal']-$n->val->GuestDiskInfo->freeSpace;
                            }
                            elseif ($n->name=='guest.ipAddress') {
                                $i['IP']=$n->val;
                            }
                        }
                        $i['obj']=$obj;
                        return $i;
                    }
                }
            }
            return false;
        }

        function get_vm_list()
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
            foreach($res->returnval as $v) {
                $v=$v->propSet;
                $name='';
                $uuid='';
                foreach($v as $v2) {
                    if($v2->name=='name')
                        $name=$v2->val;
                    if($v2->name=='runtime.powerState')
                        //$name = (($v2->val=='poweredOn') ? 'ON ••• ' : (($v2->val=='poweredOff') ? 'OF °°° ' : 'SU °°° '))."  ".strstr($name, '_', true)." → → → ".strstr($name, '_', false);
                        $name = (($v2->val=='poweredOn') ? 'ON ••• ' : (($v2->val=='poweredOff') ? 'OF °°° ' : 'SU °°° '))."  ".str_replace('_', " → ", $name);
                    if($v2->name=='config.uuid')
                        $uuid=$v2->val;
                }
                $vmlist[$name]=$uuid;
            }
            return $vmlist;
        }

    }