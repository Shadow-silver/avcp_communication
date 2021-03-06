<?php

class Crono
{
	private $start_time;
	private $delta_time;
	private $inter_time;
	
	function __construct()
	{
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$this->start_time  = $mtime;		
		$this->inter_time = array();
	}
	
	
	function max_execution_time()
	{
		return intval(ini_get("max_execution_time"));
	}
	
	public function elapsed_time()
	{
		$mtime = microtime(true);
		//$mtime = explode(" ",$mtime);
//		$mtime = $mtime[1] + $mtime[0];
				
		return   $mtime - $this->start_time ;
	}
	
	public function intertempo()
	{
		$mtime = microtime(true);
		//$mtime = explode(" ",$mtime);
		//$mtime = $mtime[1] + $mtime[0];
		
		if (count($this->inter_time)==0)		
			{
				$delta = $mtime - $this->start_time ;
				$this->inter_time[] = $mtime;
				$this->delta_time[] = $delta;			
			}
		else
			{
				$i = count($this->inter_time);
				$i--;
				$delta = $mtime - $this->inter_time[$i];
				$this->inter_time[] = $mtime;
				$this->delta_time[] = $delta;
				//echo "Tempo: " . $mtime . " - Delta: " . $delta  . "<br/>";
			}
		return $delta;
	}	
}

?>
