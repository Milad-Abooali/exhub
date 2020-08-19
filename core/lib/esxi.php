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


    class ESXi
    {

        public $returnval, $lasserror;
        private $soap, $soapLoad=false;

        /**
         * ESXi constructor.
         * @param $lang
         */
        function __construct($host) {

            M::aLog('core',"Class <b style='color:red'>$class_path</b> is not exists!",1,'EXSi');

//            $this->loadSoap($host);
        }


    }