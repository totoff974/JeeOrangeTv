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
include_file('core', 'JeeOrangeTv', 'config', 'JeeOrangeTv');

class JeeOrangeTv extends eqLogic {
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */

    public static function dependancy_info() {
        $return = array();
        $return['progress_file'] = jeedom::getTmpFolder('JeeOrangeTv') . '/dependance';
        if (exec(system::getCmdSudo() . system::get('cmd_check') . '-E "python\-serial|python\-request|python\-pyudev" | wc -l') >= 3) {
            $return['state'] = 'ok';
        } else {
            $return['state'] = 'nok';
        }
        return $return;
    }

    public static function dependancy_install() {
        log::remove(__CLASS__ . '_update');
        return array('script' => dirname(__FILE__) . '/../../resources/install_#stype#.sh ' . jeedom::getTmpFolder('JeeOrangeTv') . '/dependance', 'log' => log::getPathToLog(__CLASS__ . '_update'));
    }

    public static function deamon_info() {
        $return = array();
        $return['log'] = 'JeeOrangeTv';
        $return['state'] = 'nok';
        $pid_file = jeedom::getTmpFolder('JeeOrangeTv') . '/deamon.pid';
        if (file_exists($pid_file)) {
            $pid = trim(file_get_contents($pid_file));
            if (is_numeric($pid) && posix_getsid($pid)) {
                $return['state'] = 'ok';
            } else {
                shell_exec(system::getCmdSudo() . 'rm -rf ' . $pid_file . ' 2>&1 > /dev/null;rm -rf ' . $pid_file . ' 2>&1 > /dev/null;');
            }
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

        $JeeOrangeTv_path = realpath(dirname(__FILE__) . '/../../resources/JeeOrangeTvd');
        $cmd = '/usr/bin/python ' . $JeeOrangeTv_path . '/JeeOrangeTvd.py';
        // $cmd .= ' --ip ' . $port;
        // $cmd .= ' --freq ' . $port;
        $cmd .= ' --socketport ' . config::byKey('socketport', 'JeeOrangeTv');
        $cmd .= ' --cycle ' . config::byKey('cycle', 'JeeOrangeTv');
        $cmd .= ' --freq_actu ' . config::byKey('freq_actu', 'JeeOrangeTv');
        $cmd .= ' --loglevel ' . log::convertLogLevel(log::getLogLevel('JeeOrangeTv'));
        $cmd .= ' --apikey ' . jeedom::getApiKey('JeeOrangeTv');
        $cmd .= ' --pid ' . jeedom::getTmpFolder('JeeOrangeTv') . '/deamon.pid';
        $cmd .= ' --callback ' . network::getNetworkAccess('internal', 'proto:127.0.0.1:port:comp') . '/plugins/JeeOrangeTv/core/php/JeeOrangeTv.inc.php';

        log::add('JeeOrangeTv', 'info', 'Lancement démon JeeOrangeTvd : ' . $cmd)
;
        exec($cmd . ' >> ' . log::getPathToLog('JeeOrangeTv') . ' 2>&1 &');
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
            log::add('JeeOrangeTv', 'error', 'Impossible de lancer le démon JeeOrangeTv, vérifiez le log', 'unableStartDeamon');
            return false;
        }
        message::removeAll('JeeOrangeTv', 'unableStartDeamon');
        sleep(2);
        self::sendIdToDeamon();
        config::save('include_mode', 0, 'JeeOrangeTv');
        log::add('JeeOrangeTv', 'info', 'Démon JeeOrangeTv lancé');
        return true;
    }

    public static function deamon_stop() {
        $pid_file = jeedom::getTmpFolder('JeeOrangeTv') . '/deamon.pid';
        if (file_exists($pid_file)) {
            $pid = intval(trim(file_get_contents($pid_file)));
            system::kill($pid);
        }
        system::kill('JeeOrangeTvd.py');
        system::fuserk(config::byKey('socketport', 'JeeOrangeTv'));
        sleep(1);
    }

    public static function sendIdToDeamon() {
        foreach (self::byType('JeeOrangeTv') as $eqLogic) {
            $eqLogic->allowDevice();
            usleep(300);
        }
    }

    public function allowDevice() {
        $value = array('apikey' => jeedom::getApiKey('JeeOrangeTv'));
        $value = json_encode($value);
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);
        socket_connect($socket, '127.0.0.1', config::byKey('socketport', 'JeeOrangeTv'));
        socket_write($socket, $value, strlen($value));
        socket_close($socket);
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
    public function MaJ_JSON() {
        foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
            log::add('JeeOrangeTv', 'debug', '|---> Décodeur : ' . $JeeOrangeTv->getName());
            log::add('JeeOrangeTv', 'debug', '    |---> mise à jour du JSON');
            $JeeOrangeTv->ActionInfo($JeeOrangeTv->getConfiguration('box_ip'));
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

    // Appui sur une touche
    public function ActionTouche($box_ip, $code_touche, $code_mode) {
        // construction de la commande
        $cmd_html = 'curl -s "http://'.$box_ip.':8080/remoteControl/cmd?operation=01&key='. $code_touche . '&mode=' . $code_mode . '" > /dev/null 2>&1';
        // execution de la commande
        $retour_action = shell_exec($cmd_html);
        // log
        log::add('JeeOrangeTv', 'debug', '    |---> Décodeur : ' . JeeOrangeTv::getName());
        log::add('JeeOrangeTv', 'debug', '        |---> cmd operation=01');
        log::add('JeeOrangeTv', 'debug', '            |---> Code Touche : ' . $code_touche . ' envoyé');
        log::add('JeeOrangeTv', 'debug', '            |---> Mode Touche : ' . $code_mode . ' envoyé');
        return;
    }

        // Zapper sur une chaine directement
    public function ActionZapChaine($box_ip, $epg_id) {
        // mise en forme du code epg pour 10 digits
        $epg_id = str_pad($epg_id, 10, "*", STR_PAD_LEFT);
        // construction de la commande
        $cmd_html = 'curl -s "http://'.$box_ip.':8080/remoteControl/cmd?operation=09&epg_id='.$epg_id.'&uui=1" > /dev/null 2>&1';
        // execution de la commande
        $retour_action = shell_exec($cmd_html);
        // log
        log::add('JeeOrangeTv', 'debug', '    |---> Décodeur : ' . JeeOrangeTv::getName());
        log::add('JeeOrangeTv', 'debug', '        |---> cmd operation=09');
        log::add('JeeOrangeTv', 'debug', '            |---> EPG ID : ' . $epg_id . ' envoyé');
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
        log::add('JeeOrangeTv', 'debug', '        |---> cmd operation=10');
        log::add('JeeOrangeTv', 'debug', '            |---> Début analyse du JSON');

        if (isset($retour['result']['responseCode'])) {
            log::add('JeeOrangeTv', 'debug', '                |---> ResponseCode : ' . $retour['result']['responseCode']);
        }
        if (isset($retour['result']['data']['activeStandbyState'])) {
            log::add('JeeOrangeTv', 'debug', '                |---> activeStandbyState : ' . $retour['result']['data']['activeStandbyState']);
        }
        if (isset($retour['result']['data']['osdContext'])) {
            log::add('JeeOrangeTv', 'debug', '                |---> osdContext : ' . $retour['result']['data']['osdContext']);
        }
        if (isset($retour['result']['data']['playedMediaId'])) {
            log::add('JeeOrangeTv', 'debug', '                |---> playedMediaId : ' . $retour['result']['data']['playedMediaId']);
        }

        if ($retour['result']['responseCode'] == '0') {
            foreach (eqLogic::getCmd() as $info) {

                if ($info->getName() == 'Etat Decodeur') {

                    $retour_etat = $retour['result']['data']['activeStandbyState'];

                    if ( $retour_etat == '0' ) {
                        $etat_decodeur = 1;
                    } elseif ( $retour_etat == '1' ){
                        $etat_decodeur = 0;
                    } elseif ( $retour_etat == '' ){
                        $etat_decodeur = $info->getConfiguration('etat_decodeur');
                    } else {
                        $etat_decodeur = $info->getConfiguration('etat_decodeur');
                    }

                    if ($info->getConfiguration('etat_decodeur') != $etat_decodeur) {
                        $info->setConfiguration('etat_decodeur', $etat_decodeur);
                        //$info->setValue($etat_decodeur);
                        $info->save();
                        $info->event($etat_decodeur);
                        JeeOrangeTv::refreshWidget();
                    }
                }

                if ($info->getName() == 'Fonction') {

                    if (isset($retour['result']['data']['playedMediaState'])){
                        $retour_fonction = $retour['result']['data']['playedMediaState'];
                    } else {
                        $retour_fonction = "null";
                    }


                    if ($info->getConfiguration('fonction') != $retour_fonction) {
                        $info->setConfiguration('fonction', $retour_fonction);
                        //$info->setValue($retour_fonction);
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
                        //$info->setValue($chaine_actu);
                        $info->save();
                        $info->event($chaine_actu);
                        JeeOrangeTv::refreshWidget();
                    }
                    }
            }
        } else {
            log::add('JeeOrangeTv', 'debug', '            |---> Décodeur ERREUR - ResponseCode : ' . $retour['result']['responseCode']);
            log::add('JeeOrangeTv', 'debug', '                |---> Le décodeur ne donne pas de réponse');
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
                    $JeeOrangeTvCmd->setLogicalId($cmd['logicalId']);
                    $JeeOrangeTvCmd->setConfiguration('code_touche', $cmd['configuration']['code_touche']);
                    $JeeOrangeTvCmd->setConfiguration('mosaique_chaine', $cmd['configuration']['mosaique_chaine']);
                    $JeeOrangeTvCmd->setConfiguration('telecommande', $cmd['configuration']['telecommande']);
                    $JeeOrangeTvCmd->setConfiguration('etat_decodeur', 0);
                    $JeeOrangeTvCmd->setConfiguration('chaine_actuelle', $cmd['configuration']['chaine_actuelle']);
                    $JeeOrangeTvCmd->setConfiguration('fonction', $cmd['configuration']['fonction']);
                    $JeeOrangeTvCmd->setType($cmd['type']);
                    $JeeOrangeTvCmd->setSubType($cmd['subType']);
                    $JeeOrangeTvCmd->setOrder($cmd['order']);
                    $JeeOrangeTvCmd->setIsVisible($cmd['isVisible']);
                    $JeeOrangeTvCmd->setDisplay('generic_type', $cmd['generic_type']);
                    $JeeOrangeTvCmd->setDisplay('forceReturnLineAfter', $cmd['forceReturnLineAfter']);
                    $JeeOrangeTvCmd->setValue(0);
                    $JeeOrangeTvCmd->save();
               }

        }
    }

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

    // Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
    public function toHtml($_version = 'dashboard') {
        $localisation = JeeOrangeTv::getConfiguration('localisation');
        $theme = JeeOrangeTv::getConfiguration('theme');

        if ($theme == 'aucun') {
            return parent::toHtml($_version);
        }

        $replace = $this->preToHtml($_version);
        if (!is_array($replace)) {
            return $replace;
        }

        $_version = jeedom::versionAlias($_version);
        foreach ($this->getCmd('info') as $inf) {

            if ($inf->getName() == 'Etat Decodeur') {
            $etat_decodeur = $inf->getConfiguration('etat_decodeur');
                if ($etat_decodeur == 1){
                    $replace['#etat_decodeur#'] = '<img id="ON" src="plugins/JeeOrangeTv/core/template/dashboard/images/Widget/on_' . $theme . '.png" style="position:absolute;top:0;left:0px;">';
                } else {
                    $replace['#etat_decodeur#'] = '';
                }
            }

            if ($inf->getName() == 'Chaine Actuelle') {
            if ($inf->getConfiguration('chaine_actuelle')=='home' OR $inf->getConfiguration('chaine_actuelle')=='vod') {
                $nom_chaine_act = $inf->getConfiguration('chaine_actuelle');
                $replace['#cmd_chaine_act#'] = '<img id="ON" src="plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/' . $nom_chaine_act . '.png" style="position:absolute;top:63px;left:116px;">';
            }
            else {
                $nom_chaine_act = $this->lecture_json('logo', 'logo', $localisation, $inf->getConfiguration('chaine_actuelle'));
                $replace['#cmd_chaine_act#'] = '<img id="ON" src="plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/' . $nom_chaine_act . '.png" style="position:absolute;top:63px;left:116px;">';
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
            $html = template_replace($replace, getTemplate('core', $_version, $theme,'JeeOrangeTv'));
        }

        if ($tel_mos == 0) {
            $html = template_replace($replace, getTemplate('core', $_version, 'mosaique','JeeOrangeTv'));
        }

        return $html;
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

    public function execute($_options = array()) {

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
                    log::add('JeeOrangeTv', 'debug', '|---> Refresh : '. $this->getName());
                    //$eqLogic->ActionInfo($box_ip);
                }
                else {
                $code_touche = $this->getConfiguration('code_touche');
                    if ($code_touche != "") {
                        log::add('JeeOrangeTv', 'info', '|---> Action executée - IP : ' . $box_ip . ' - touche : ' . $this->getName() . ' - code touche : ' . $code_touche . ' - mode : ' . $code_mode);
                        $eqLogic->ActionTouche($box_ip, $code_touche, $code_mode);
                    }
                    else {
                        log::add('JeeOrangeTv', 'debug', '    |---> Action non executée - IP : ' . $box_ip . ' car code touche vide vérifier paramètres des touches');
                    }
                }
            }


            if ($action_mosaique == 1) {
                $mos_chaine = $this->getConfiguration('mosaique_chaine');
                $mos_id = $eqLogic->lecture_json('id', 'logo', $localisation, $mos_chaine);
                $mos_num = $eqLogic->lecture_json('canal', 'logo', $localisation, $mos_chaine);

                log::add('JeeOrangeTv', 'info', '|---> Mosaique Chaine : ' . $mos_chaine . ' - Numéro de la chaine : '. $mos_num . ' - Id de la chaine : '. $mos_id);

                if ($mos_id >= 0) {
                    $eqLogic->ActionZapChaine($box_ip, $mos_id);
                }
                else {
                    $mos_touche = str_split($mos_num);
                    $nb_touches = count($mos_touche);
                    $i = 0;
                    foreach ($mos_touche as $touche) {
                        // Prise en charge appui long
                        if ($i < $nb_touches) {
                            $code_mode = 1;
                        }
                        else {
                            $code_mode = 2;
                        }
                        $i += 1;
                        foreach ($eqLogic->getCmd() as $action) {
                            if ($touche == $action->getName()) {
                                $code_touche = $action->getConfiguration('code_touche');
                                if ($code_touche != "") {
                                    $eqLogic->ActionTouche($box_ip, $code_touche, $code_mode);
                                }
                                else {
                                    log::add('JeeOrangeTv', 'debug', '    |---> Action non executée - IP : ' . $box_ip . ' car code touche vide vérifier paramètres des touches');
                                }
                            }
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

