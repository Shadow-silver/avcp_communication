<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {counter} function plugin
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  print out a counter value
 *
 * @author Shadow Silver<monte at ohrt dot com>
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_urlarea($params, $template)
{
    $link =INDEX . "?";
	$counter=0;
	$state = $template->tpl_vars['state']->value;
	$nonce =true;
	if (isset($params['area']))
	{
		$link .= "area=" . urlencode($params['area']);		
		$counter++;
		
	}
	if (isset($params['nonce']))
	{
		
		if ($params['nonce'] == "false")
			$nonce=false;
		else
			$nonce=true;
	}
	
 
	/*else
	{
		$link .= "area=" . urlencode($state->toString());
		$counter++;
	}*/
	
	if (isset($params['action']))
	{
		if ($counter > 0 )
			{ $link .="&amp;";}
		 
			if ($nonce)
			{
				$nonce=get_nonce_value($state->toString());
				$link .= "nonce=" . urlencode($nonce) . "&amp;";
			}
		
		$link .= "action=" . urlencode($params['action']);
		$counter++;
	}
	else
	{
		if ($nonce)
		{
				if ($counter > 0 )
				{ $link .="&amp;";}
				$nonce=get_nonce_value($state->toString());
				$link .= "nonce=" . urlencode($nonce) . "&amp;";
		}
	}
	
	if (isset($params['parameters']))
	{
		if (is_array($params['parameters']))
		{
			foreach($params['parameters'] as $key=>$value)
			{
				if ($counter > 0 ) { $link .="&amp;";};
					$link .= "$key=" . urlencode($value);
				$counter++;
			}
		}
		else
		{
			if ($counter > 0 ) { $link .="&amp;";};
					$link .= "parameter=" . urlencode($params['parameters']);
			$counter++;
		}
	}
	
    return $link;

}
