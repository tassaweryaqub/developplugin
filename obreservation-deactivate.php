<?php
/**
 * @package obreservation
 */

 class reservationdeactive {

    public static function deactivate(){
        flush_rewrite_rules(); 
    }
 }