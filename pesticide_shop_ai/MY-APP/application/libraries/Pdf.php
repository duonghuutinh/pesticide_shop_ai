<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'TCPDF-main/tcpdf.php';

// Extend the TCPDF class to create custom Header and Footer
class Pdf extends TCPDF {
    public function __construct() {
        parent::__construct();
    }
}

?>
