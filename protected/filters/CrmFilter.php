<?php

class CrmFilter extends CFilter
{
	var $action;
	var $actionID;
	var $interval;
	
    protected function preFilter($filterChain)
    {
//		echo "<p>preFilter $this->action, $this->interval</p>";
		
        // logic being applied before the action is executed
		
		//Look up when we last called the action
		$ready = Periodic::model()->find(
							'actionID = :actionID AND NOW() > DATE_ADD(last_called, INTERVAL :interval MINUTE) ',
							array(':actionID'=>$this->actionID, ':interval'=>$this->interval)
						);
 

		if ($ready) {
			// Update the last_called time and call our action
//DEBUG
			$ready->save();
//echo '<p>ready '.$ready->last_called.'</p>';			
//			echo '<p>CALL FUNCTION</p>'; 
			
			$model = new $this->action['model'];
			$func = $this->action['function'];
			$model::$func();
//			echo '<p>BACK FROM CALL FUNCTION</p>'; 
		}
		
		// Call the action
		
        return true;
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
		return true;
    }
}

?>