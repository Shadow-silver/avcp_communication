<?php
namespace avcpman\gare;
/**
* $action variabile che contiene il nome dell'area corrente
* @Skippable
*/
class Control extends \Control
{
    /**
     * Summary
     * @Access(roles="administrator,editors",redirect=true  )
     * @return object  Description
     */
    function d(){
            $ditte =get_ditte();
            if (!isset($this->_s["year"]))
            {
                $this->_s["year"]=date("Y");
            }
            //default action
            return ReturnSmarty('gare.tpl',array("year"=>$this->_s["year"],
                                                 "gare"=>array()));
    }
    
    /*function edit(){
        
        return ReturnArea($this->status->getSiteView(),"ditte/edit");
    }
    */
    function new_gara(){
        
        return ReturnArea($this->status->getSiteView(),"gare/new_gara");
    }
}
?>
