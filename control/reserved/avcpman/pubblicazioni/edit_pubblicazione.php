<?php
//namespace reserved\avcpman\pubblicazioni\edit_pubblicazione;
class Control extends \Control
{
    /**
     * @Access(roles="administrator,publisher"  )
     */    
    function d(){
        if (isset($this->_r["anno"]) && isset($this->_r["numero"]))
        {
            $anno  = (int) $this->_r["anno"];
			$numero =  (int) $this->_r["numero"];
			$p = (array)get_pubblicazione_detail($anno,$numero);

			$p['data_aggiornamento']= date("d/m/Y");
            return ReturnSmarty('avcp/pubblicazione.edit.tpl',$p);
        }
        else
            return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
    
 
    /**
     * @Access(roles="administrator,publisher"  )
     */        
    function save()
    {
        //TODO : add check if is already added
        if ($this->_r["submit"] != "undo")
        {
            $titolo = $this->_r["pubblicazione_edit_titolo"];
            $abstract = $this->_r["pubblicazione_edit_abstract"];
            $data_pubblicazione = $this->_r["pubblicazione_edit_pubblicazione"];
            $data_aggiornamento = $this->_r["pubblicazione_edit_aggiornamento"];
            $url = $this->_r["pubblicazione_edit_url"];
            $anno = $this->_r["pubblicazione_edit_anno"];
			$numero = $this->_r["pubblicazione_edit_numero"];
            $result = update_pubblicazione($titolo,$abstract,$data_pubblicazione,$data_aggiornamento,$url,$anno,$numero);
			if ($result !== false)
			{
				$true = set_gare_pubblicazione($anno,$numero);
				
				//Now we store the xml file in the database
				$settings = get_settings(array("cf_ente","ente","licenza"));
				$pubblicazione = get_pubblicazione_detail($anno,$numero);
				$lotti = get_gare($anno,$numero);
				foreach ($lotti as $lotto)
				{
					$lotto->partecipanti = get_partecipanti($lotto->gid);
				}
				
				$pubblicazione->licenza = $settings["licenza"];
				$pubblicazione->ente_pubblicatore = $settings["ente"];
				$pubblicazione->cf_ente_pubblicatore = $settings["cf_ente"];
                $name="avcp_" . $anno . "_" . $numero . ".xml";
                preg_match('@^(?:https?://)?(?:[^/]+/)+([^/]+)@i',$pubblicazione->url, $matches);
                if (count($matches) == 2)
                {
                    $name = $matches[1];
                }
                
                    
				$content = write_avcp_xml_to_string($pubblicazione, $lotti);
				insert_file($content,"P",$anno,$numero,$name);
				set_modified_bit_pubblicazione($anno,0);
			}            
        }
        return ReturnArea($this->status->getSiteView(),"avcpman/pubblicazioni");
    }
}
?>
