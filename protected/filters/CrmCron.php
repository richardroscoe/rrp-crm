<?php

class CrmCron extends CFilter
{
    protected function preFilter($filterChain)
    {
		echo "<p>preFilter</p>";
		
        // logic being applied before the action is executed
        return true;
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
		return true;
    }
}

?>