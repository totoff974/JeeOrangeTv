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
    public static function cron5() {
		foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			$JeeOrangeTv->ActionInfo($JeeOrangeTv->getConfiguration('box_ip'));
		}	
	}
	public static function dependancy_info() {

	}
	public static function dependancy_install() {

	}
	
	public static function deamon_info() {

	}

	public static function deamon_start() {

	}

	public static function deamon_stop() {

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
	    foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			if (config::byKey('widget', 'JeeOrangeTv') == 1) {
				$JeeOrangeTv->toHtml('mobile');
				$JeeOrangeTv->toHtml('dashboard');
				$JeeOrangeTv->refreshWidget();
			}
		}
    }

    public function preUpdate() {
		if ($this->getConfiguration('box_ip') == '') {
            throw new Exception(__('Merci de renseigner IP du décodeur.',__FILE__));	
        }
		$this->autoAjoutCommande();
    }

    public function postUpdate() {
		
    }

    public function preRemove() {
		 
    }

    public function postRemove() {
        
    }

 	public function toHtml($_version = 'dashboard')	{

		foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			if (config::byKey('widget', 'JeeOrangeTv') == 0) {
				return parent::toHtml($_version);
			}
		}
		
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		
		$_version = jeedom::versionAlias($_version);
		foreach ($this->getCmd('info') as $inf) {
			$etat_decodeur = $inf->getConfiguration('etat');
			$replace['#etat_decodeur#'] = $etat_decodeur;
			$replace['#cmd_chaine_act#'] = $inf->getConfiguration('chaine_actuelle');
		}
		
		foreach ($this->getCmd('action') as $cmd) {
			$replace['#cmd_' . $cmd->getName() . '_id#'] = $cmd->getId();
			$replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'#'] = $cmd->getConfiguration('mosaique_chaine');
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
	
	
	public function ActionCommande($box_ip, $code_touche, $code_mode) {

		// construction de la commande
		$cmd_html = 'curl -s "http://'.$box_ip.':8080/remoteControl/cmd?operation=01&key='.$code_touche.'&mode='.$code_mode.'" > /dev/null 2>&1';
		
		// execution de la commande
		$retour_action = shell_exec($cmd_html);
		return;
	}
	
	public function ActionInfo($box_ip) {
	
		// etat du decodeur
		$cmd_retour = 'curl -s "http://'.$box_ip.':8080/remoteControl/cmd?operation=10"';
		// execution de la commande
		$retour_action = shell_exec($cmd_retour);	
		
		// lecture du json depuis le décodeur
		$retour = json_decode($retour_action, true);
			
		foreach (eqLogic::getCmd() as $info) {
			if ($info->getName() == 'etat') {
				$retour_etat = intval($retour['result']['data']['activeStandbyState']);
				
				if ( $retour_etat == 0 ) {
					$etat_decodeur = 1;					
				} else {
					$etat_decodeur = 0;
				}
				
				$info->setConfiguration('etat', $etat_decodeur);
				$info->save();
				$info->event($etat_decodeur);

				
				if($retour['result']['data']['osdContext'] == 'HOMEPAGE' and $etat_decodeur == 1){
					$chaine_actu = 'home';
				}
				elseif ($retour['result']['data']['osdContext'] == 'LIVE'){
					$chaine_actu = strval($retour['result']['data']['playedMediaId']);
					if ($chaine_actu != '-1' and $etat_decodeur == 1) {
						$chaine_actu = $retour['result']['data']['playedMediaId'];
					} else {
						$chaine_actu = 'blank';
					}
				}
				else {
					$chaine_actu = 'blank';
				}
				
				
				$info->setConfiguration('chaine_actuelle', $chaine_actu);
				$info->save();
				$info->event($chaine_actu);
			}
		}
		
		if (config::byKey('widget', 'JeeOrangeTv') == 1) {		
			foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
				$JeeOrangeTv->toHtml('mobile');
				$JeeOrangeTv->toHtml('dashboard');
				$JeeOrangeTv->refreshWidget();
			}
		}
		return;
	}
	
	public function Telecommande_Mosaique() {
		if (config::byKey('widget', 'JeeOrangeTv') == 1) {		
			foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
				$JeeOrangeTv->toHtml('mobile');
				$JeeOrangeTv->toHtml('dashboard');
				$JeeOrangeTv->refreshWidget();
			}
		}
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
				$code_touche = $this->getConfiguration('code_touche');
				log::add('JeeOrangeTv', 'debug', 'Action executée Jee IP : ' . $box_ip . ' - touche : ' . $code_touche . ' - mode : ' . $code_mode);
				$eqLogic->ActionCommande($box_ip, $code_touche, $code_mode);
			}

		
			if ($action_mosaique == 1) {
				$mos_chaine = $this->getConfiguration('mosaique_chaine');
				$mos_num = $this->getConfiguration('mosaique_numero');
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