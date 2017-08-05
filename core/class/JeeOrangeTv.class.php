<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../core/php/JeeOrangeTv.inc.php';
require_once dirname(__FILE__) . '/../../core/config/JeeOrangeTv.config.php';
include_file('core', 'JeeOrangeTv', 'config', 'JeeOrangeTv');

class JeeOrangeTv extends eqLogic {
    /*     * *************************Attributs****************************** */

	
    /*     * ***********************Methode static*************************** */
	
    // public static function cron() {
		// foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			// $JeeOrangeTv->ActionInfo($JeeOrangeTv->getConfiguration('box_ip'));
		// }
	// }
	
    // public static function cron5() {
		// foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			// $JeeOrangeTv->ActionInfo($JeeOrangeTv->getConfiguration('box_ip'));
		// }
	// }
	
	public static function dependancy_info() {
		$return = array();
		$return['log'] = 'JeeOrangeTv_dep';
		$request = realpath(dirname(__FILE__) . '/../../node/node_modules/request');
		$return['progress_file'] = '/tmp/JeeOrangeTv_dep';
		if (is_dir($request)) {
		  $return['state'] = 'ok';
		} else {
		  $return['state'] = 'nok';
		}
		return $return;
	}
	public static function dependancy_install() {
		log::add('JeeOrangeTv','info','Installation des dépendances nodejs');
		$resource_path = realpath(dirname(__FILE__) . '/../../resources');
		passthru('/bin/bash ' . $resource_path . '/nodejs.sh ' . $resource_path . ' > ' . log::getPathToLog('JeeOrangeTv_dep') . ' 2>&1 &');
	}
	
	public static function deamon_info() {
    $return = array();
    $return['log'] = 'JeeOrangeTv_node';
    $return['state'] = 'nok';
    $pid = trim( shell_exec ('ps ax | grep "JeeOrangeTv/node/jeeorangetv.js" | grep -v "grep" | wc -l') );
    if ($pid != '' && $pid != '0') {
      $return['state'] = 'ok';
    }
    $return['launchable'] = 'ok';
    return $return;
	}

	public static function deamon_start() {
    self::deamon_stop();
    $deamon_info = self::deamon_info();
    if ($deamon_info['launchable'] != 'ok') {
      throw new Exception(__('Veuillez vérifier la configuration', __FILE__));
    }
    $url = network::getNetworkAccess('internal') . '/plugins/JeeOrangeTv/core/api/jeeOrangeTv.php?apikey=' . jeedom::getApiKey('JeeOrangeTv');
    
	JeeOrangeTv::launch_svc($url);
	}

	public static function deamon_stop() {
    exec('kill $(ps aux | grep "JeeOrangeTv/node/jeeorangetv.js" | awk \'{print $2}\')');
    log::add('JeeOrangeTv', 'info', 'Arrêt du service JeeOrangeTv');
    $deamon_info = self::deamon_info();
    if ($deamon_info['state'] == 'ok') {
      sleep(1);
      exec('kill -9 $(ps aux | grep "JeeOrangeTv/node/jeeorangetv.js" | awk \'{print $2}\')');
    }
    $deamon_info = self::deamon_info();
    if ($deamon_info['state'] == 'ok') {
      sleep(1);
      exec('sudo kill -9 $(ps aux | grep "JeeOrangeTv/node/jeeorangetv.js" | awk \'{print $2}\')');
    }
	}

	public static function launch_svc($url) {
    $log = log::convertLogLevel(log::getLogLevel('JeeOrangeTv'));
    $sensor_path = realpath(dirname(__FILE__) . '/../../node');
	$freq = config::byKey('freq_actu', 'JeeOrangeTv');
	
	if ($freq == 0) {
		$freq == 1;
	}
	
    $cmd = 'nice -n 19 nodejs ' . $sensor_path . '/jeeorangetv.js ' . $url . ' ' . $log . ' ' . $freq;

    log::add('JeeOrangeTv', 'debug', 'Lancement démon JeeOrangeTv : ' . $cmd);

    $result = exec('nohup ' . $cmd . ' >> ' . log::getPathToLog('JeeOrangeTv_node') . ' 2>&1 &');
    if (strpos(strtolower($result), 'error') !== false || strpos(strtolower($result), 'traceback') !== false) {
      log::add('JeeOrangeTv', 'error', $result);
      return false;
    }

    $i = 0;
    while ($i < 30) {
      $deamon_info = self::deamon_info();
      if ($deamon_info['state'] == 'ok') {
        break;
      }
      sleep(1);
      $i++;
    }
    if ($i >= 30) {
      log::add('JeeOrangeTv', 'error', 'Impossible de lancer le démon JeeOrangeTv', 'unableStartDeamon');
      return false;
    }
    message::removeAll('JeeOrangeTv', 'unableStartDeamon');
    log::add('JeeOrangeTv', 'info', 'Démon JeeOrangeTv lancé');
    return true;
    }
  
	public function MaJ_JSON() {
		foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			$JeeOrangeTv->ActionInfo($JeeOrangeTv->getConfiguration('box_ip'));
		}
	}

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {

      }
     */


    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {

      }
     */

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDayly() {

      }
     */



    /*     * *********************Méthodes d'instance************************* */
	
    public function preInsert() {

    }

    public function postInsert() {

    }

    public function preSave() {
       
    }

    public function postSave() {
		if (!$this->getId())
          return;
		$this->Telecommande_Mosaique();
    }

    public function preUpdate() {
		if ($this->getConfiguration('box_ip') == '') {
            throw new Exception(__('Merci de renseigner IP du décodeur.',__FILE__));	
        }
		$this->autoAjoutCommande();
    }

    public function postUpdate() {
		$this->Telecommande_Mosaique();
    }

    public function preRemove() {
		 
    }

    public function postRemove() {
        
    }

 	public function toHtml($_version = 'dashboard')	{
				
		$localisation = JeeOrangeTv::getConfiguration('localisation');

		//foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			if (config::byKey('widget', 'JeeOrangeTv') == 0) {
				return parent::toHtml($_version);
			}
		//}
		
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		
		$_version = jeedom::versionAlias($_version);
		foreach ($this->getCmd('info') as $inf) {
			
			if ($inf->getName() == 'Etat') {
			$etat_decodeur = $inf->getConfiguration('etat');
			$replace['#etat_decodeur#'] = $etat_decodeur;
			}
			
			if ($inf->getName() == 'Chaine Actuelle') {
			if ($inf->getConfiguration('chaine_actuelle')=='home' OR $inf->getConfiguration('chaine_actuelle')=='vod') {
				$replace['#cmd_chaine_act#'] = $inf->getConfiguration('chaine_actuelle');
			}
			else {
				$replace['#cmd_chaine_act#'] = $this->lecture_json('logo', 'logo', $localisation, $inf->getConfiguration('chaine_actuelle'));
			}
			}
						
		}
		
		foreach ($this->getCmd('action') as $cmd) {
			$replace['#cmd_' . $cmd->getName() . '_id#'] = $cmd->getId();
			$replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'#'] = $cmd->getConfiguration('mosaique_chaine');
			$replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_logo#'] = $this->lecture_json('logo', 'logo', $localisation, $cmd->getConfiguration('mosaique_chaine'));
			$replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_nom#'] = $this->lecture_json('nom', 'logo', $localisation, $cmd->getConfiguration('mosaique_chaine'));
			$replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_id#'] = $cmd->getId();
			$replace['#mos_Telecommande_id#'] = $cmd->getId();
			$tel_mos = $cmd->getConfiguration('telecommande');
		}
		
		if ($tel_mos == 1) {
			$html = template_replace($replace, getTemplate('core', $_version, 'current','JeeOrangeTv'));
		}
		
		if ($tel_mos == 0) {
			$html = template_replace($replace, getTemplate('core', $_version, 'mosaique','JeeOrangeTv'));
		}		
		
		return $html;
	}
	
    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */
	
	public function lecture_json($param_sortie, $param_entree, $localisation, $comp_entree) {
		// param -> id / nom / canal / logo / categorie
		$json_liste = file_get_contents(realpath(dirname(__FILE__) . '/../../core/config/chaines.json'));
		$json_chaines = json_decode($json_liste, true);
		
		foreach ($json_chaines['localisation'] as $key => $val) {
			if ($localisation == $val['code']) {
				foreach ($val['liste'] as $key => $val) {
					if ($comp_entree == $val[$param_entree]) {
						$retour = $val[$param_sortie];
					}
				}
			}
		}
		if ($retour == '') {
			$retour = 'blank';
		}
		return $retour;
	}
	
	public function ActionCommande($box_ip, $code_touche, $code_mode) {
		// construction de la commande
		$cmd_html = 'curl -s "http://'.$box_ip.':8080/remoteControl/cmd?operation=01&key='.$code_touche.'&mode='.$code_mode.'" > /dev/null 2>&1';
		
		// execution de la commande
		$retour_action = shell_exec($cmd_html);
		return;
	}
	
	public function ActionInfo($box_ip) {
		$localisation = JeeOrangeTv::getConfiguration('localisation');

		// etat du decodeur
		$cmd_retour = 'curl -s "http://'.$box_ip.':8080/remoteControl/cmd?operation=10"';
		// execution de la commande
		$retour_action = shell_exec($cmd_retour);	
		
		// lecture du json depuis le décodeur
		$retour = json_decode($retour_action, true);
		log::add('JeeOrangeTv', 'debug', ' *** DEBUT RETOUR JSON POUR LE DECODEUR - ' . JeeOrangeTv::getName() . ' - ***');
		log::add('JeeOrangeTv', 'debug', 'DECODEUR INFO - ResponseCode : ' . $retour['result']['responseCode']);
		log::add('JeeOrangeTv', 'debug', 'DECODEUR INFO - activeStandbyState : ' . $retour['result']['data']['activeStandbyState']);
		log::add('JeeOrangeTv', 'debug', 'DECODEUR INFO - osdContext : ' . $retour['result']['data']['osdContext']);
		log::add('JeeOrangeTv', 'debug', 'DECODEUR INFO - playedMediaId : ' . $retour['result']['data']['playedMediaId']);
		log::add('JeeOrangeTv', 'debug', ' **** FIN RETOUR JSON POUR LE DECODEUR - ' . JeeOrangeTv::getName() . ' - ****');
		
		if ($retour['result']['responseCode'] == '0') {
			foreach (eqLogic::getCmd() as $info) {
				
				if ($info->getName() == 'Etat') {

					$retour_etat = $retour['result']['data']['activeStandbyState'];
					
					if ( $retour_etat == '0' ) {
						$etat_decodeur = 1;
					} elseif ( $retour_etat == '1' ){
						$etat_decodeur = 0;
					} else {
						$etat_decodeur = $info->getConfiguration('etat');
					}
					
					if ($info->getConfiguration('etat') != $etat_decodeur) {
						$info->setConfiguration('etat', $etat_decodeur);
						$info->setValue($etat_decodeur);
						$info->save();
						$info->event($etat_decodeur);
						JeeOrangeTv::refreshWidget();
					}
				}

				if ($info->getName() == 'Fonction') {

					$retour_fonction = $retour['result']['data']['playedMediaState'];
									
					if ($info->getConfiguration('fonction') != $retour_fonction) {
						$info->setConfiguration('fonction', $retour_fonction);
						$info->setValue($retour_fonction);
						$info->save();
						$info->event($retour_fonction);
						JeeOrangeTv::refreshWidget();
					}
				}
					
				if ($info->getName() == 'Chaine Actuelle') {
						
					if($retour['result']['data']['osdContext'] == 'HOMEPAGE'){
						$chaine_actu = 'home';
					}
					elseif ($retour['result']['data']['osdContext'] == 'VOD'){
						$chaine_actu = 'vod';
					}
					elseif ($retour['result']['data']['osdContext'] == 'LIVE'){
						$chaine_actu = strval($retour['result']['data']['playedMediaId']);
						if ($chaine_actu != '-1') {
							$chaine_actu = $retour['result']['data']['playedMediaId'];
							$chaine_actu = $this->lecture_json('logo', 'id', $localisation, $chaine_actu);

						}
					}
					else {
						$chaine_actu = 'blank';
					}
					if ($info->getConfiguration('chaine_actuelle') != $chaine_actu) {
						$info->setConfiguration('chaine_actuelle', $chaine_actu);
						$info->setValue($chaine_actu);
						$info->save();
						$info->event($chaine_actu);
						JeeOrangeTv::refreshWidget();
					}
					}
			}
		} else {
			log::add('JeeOrangeTv', 'debug', 'DECODEUR ERROR - ResponseCode : ' . $retour['result']['responseCode']);
			log::add('JeeOrangeTv', 'debug', 'Le décodeur ne donne pas de réponse');
		}
		return;
	}
	
	public function Telecommande_Mosaique() {
		JeeOrangeTv::refreshWidget();
		return;
	}
	
    public function autoAjoutCommande() {
		
		global $listCmdJeeOrangeTv;
		
        foreach ($listCmdJeeOrangeTv as $cmd) {
			   if (cmd::byEqLogicIdCmdName($this->getId(), $cmd['name']))
					return;
				
			   if ($cmd) {
					$JeeOrangeTvCmd = new JeeOrangeTvCmd();
					$JeeOrangeTvCmd->setName(__($cmd['name'], __FILE__));
					$JeeOrangeTvCmd->setEqLogic_id($this->id);
					$JeeOrangeTvCmd->setConfiguration('code_touche', $cmd['configuration']['code_touche']);
					$JeeOrangeTvCmd->setConfiguration('mosaique_chaine', $cmd['configuration']['mosaique_chaine']);
					$JeeOrangeTvCmd->setConfiguration('telecommande', $cmd['configuration']['telecommande']);
					$JeeOrangeTvCmd->setConfiguration('etat', 0);
					$JeeOrangeTvCmd->setConfiguration('chaine_actuelle', $cmd['configuration']['chaine_actuelle']);					
					$JeeOrangeTvCmd->setConfiguration('fonction', $cmd['configuration']['fonction']);
					$JeeOrangeTvCmd->setType($cmd['type']);
					$JeeOrangeTvCmd->setSubType($cmd['subType']);
					$JeeOrangeTvCmd->setOrder($cmd['order']);
					$JeeOrangeTvCmd->setIsVisible($cmd['isVisible']);
					$JeeOrangeTvCmd->setDisplay('generic_type', $cmd['generic_type']);
					$JeeOrangeTvCmd->setDisplay('forceReturnLineAfter', $cmd['forceReturnLineAfter']);
					$JeeOrangeTvCmd->save();
			   }

        }        
    }

	public function autoMaJCommande() {
		
		global $listCmdJeeOrangeTv;
		
		foreach ($this->getCmd() as $cmd) {
			foreach ($listCmdJeeOrangeTv as $cmd_config) {
				if (($cmd->getName()==$cmd_config['name']) AND ($cmd->getConfiguration('code_touche')!=$cmd_config['configuration']['code_touche'])){
					$cmd->setConfiguration('code_touche', $cmd_config['configuration']['code_touche']);
					$cmd->save();
				}
			}
		}

	log::add('JeeOrangeTv', 'debug', 'update des commandes OK');		
   
    }

    /*     * **********************Getteur Setteur*************************** */
	
}

class JeeOrangeTvCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */
	
    public function execute($_options = array()) 
	{
		$eqLogic = $this->getEqLogic();
		$action_mosaique = preg_match("#Mosaique #", $this->getName());
		$box_ip = $eqLogic->getConfiguration('box_ip');
		$localisation = $eqLogic->getConfiguration('localisation');
		$code_mode = 0;
		
		if ($this->getName() == "Telecommande") {
			
			$act_mos = $this->getConfiguration('telecommande');
			$eqLogic->Telecommande_Mosaique($act_mos);
			
			if ($act_mos == 1) {
				$this->setConfiguration('telecommande', 0);
				$this->save();
				$this->event(0);
			}
			if ($act_mos == 0) {
				$this->setConfiguration('telecommande', 1);
				$this->save();
				$this->event(1);
			}
		}
		
		else {
			
			if ($action_mosaique == 0) {
				if ($this->getName() == "Refresh") {
					log::add('JeeOrangeTv', 'debug', 'Refresh : '. $this->getName());
					//$eqLogic->ActionInfo($box_ip);
				}
				else {
				$code_touche = $this->getConfiguration('code_touche');
				log::add('JeeOrangeTv', 'debug', 'Action executée Jee IP : ' . $box_ip . ' - touche : ' . $code_touche . ' - mode : ' . $code_mode);
				$eqLogic->ActionCommande($box_ip, $code_touche, $code_mode);
				}
			}

		
			if ($action_mosaique == 1) {
				$mos_chaine = $this->getConfiguration('mosaique_chaine');
				$mos_num = $eqLogic->lecture_json('canal', 'logo', $localisation, $mos_chaine);
				$mos_touche = str_split($mos_num);
				
				log::add('JeeOrangeTv', 'debug', 'Mosaique Chaine : ' . $mos_chaine . ' Numéro de la chaine : '. $mos_num);
				foreach ($mos_touche as $touche) {
					foreach ($eqLogic->getCmd() as $action) {
						if ($touche == $action->getName()) {
							$code_touche = $action->getConfiguration('code_touche');
							$eqLogic->ActionCommande($box_ip, $code_touche, $code_mode);
						}
					}
				}
			}
			
			sleep(3);
			$eqLogic->ActionInfo($box_ip);
		}

		return;
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>