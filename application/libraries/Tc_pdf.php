<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
createBy : test
date : 2020/02/03
*/


require_once APPPATH.'vendor/tcpdf_min/tcpdf.php';

class Tc_pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
   
}
