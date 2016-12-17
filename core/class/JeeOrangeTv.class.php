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
			$JeeOrangeTv->toHtml('mobile');
			$JeeOrangeTv->toHtml('dashboard');
			$JeeOrangeTv->refreshWidget();
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
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		$_version = jeedom::versionAlias($_version);
		foreach ($this->getCmd('info') as $inf) {
			$etat_decodeur = $inf->getConfiguration('etat');
			$replace['#etat_decodeur#'] = $etat_decodeur;
		}
		
		foreach ($this->getCmd('action') as $cmd) {
			$replace['#cmd_' . $cmd->getName() . '_id#'] = $cmd->getId();
		}
		
		$html = template_replace($replace, getTemplate('core', $_version, 'current','JeeOrangeTv'));

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
		$this->ActionInfo($box_ip);		
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
			}
		}
		
		foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
			$JeeOrangeTv->toHtml('mobile');
			$JeeOrangeTv->toHtml('dashboard');
			$JeeOrangeTv->refreshWidget();
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
					$JeeOrangeTvCmd->setConfiguration('etat', 0);
					$JeeOrangeTvCmd->setType($cmd['type']);
					$JeeOrangeTvCmd->setSubType($cmd['subType']);
					$JeeOrangeTvCmd->setOrder($cmd['order']);
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
		$box_ip = $eqLogic->getConfiguration('box_ip');
		$code_touche = $this->getConfiguration('code_touche');
		$code_mode = 0;
		
		log::add('JeeOrangeTv', 'debug', 'Action executée Jee IP : ' . $box_ip . ' - touche : ' . $code_touche . ' - mode : ' . $code_mode);
		$eqLogic->ActionCommande($box_ip, $code_touche, $code_mode);	
		
		return;
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>