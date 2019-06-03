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

    // A VERIFIER
    public function MaJ_JSON() {
        foreach (eqLogic::byType('JeeOrangeTv') as $JeeOrangeTv) {
            log::add('JeeOrangeTv', 'debug', '|---> Décodeur : ' . $JeeOrangeTv->getName());
            log::add('JeeOrangeTv', 'debug', '    |---> mise à jour du JSON');
            $JeeOrangeTv->ActionInfo($JeeOrangeTv->getConfiguration('box_ip'));
        }
    }

    // A VERIFIER
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

    // permet de requeter le fichier json en fonction du template
    public function lecture_json($param_sortie, $param_entree, $localisation, $comp_entree) {
        // param -> id / nom / canal / logo / categorie
        $json_chaines = json_decode(file_get_contents(dirname(__FILE__) . '/../config/' . $localisation . '.json'), true);
        foreach ($json_chaines['liste'] as $key => $val) {
            if ($comp_entree === $val[$param_entree]) {
                $retour = $val[$param_sortie];
            }
        }
        if ($retour === '') {
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
        log::add('JeeOrangeTv', 'debug', '        |---> IP : '. $box_ip);
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
        log::add('JeeOrangeTv', 'debug', '        |---> IP : '. $box_ip);
        log::add('JeeOrangeTv', 'debug', '        |---> cmd operation=09');
        log::add('JeeOrangeTv', 'debug', '            |---> EPG ID : ' . $epg_id . ' envoyé');
        return;
    }

    // recupere les infos du decodeur selon frequence
    public function ActionInfo($box_ip) {
        $localisation = JeeOrangeTv::getConfiguration('template');

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
        if ($retour['result']['responseCode'] === '0') {
            foreach ($this->getCmd() as $cmd) {
                switch ($cmd->getLogicalId()) {
                    case 'etat_decodeur' :
                        $retour_etat = $retour['result']['data']['activeStandbyState'];
                        switch ($retour_etat) {
                            case '0':
                                $etat_decodeur = 1;
                                break;
                            case '1':
                                $etat_decodeur = 0;
                                break;
                            default:
                                $etat_decodeur = $cmd->getConfiguration('etat_decodeur');
                        }
                        if ($cmd->getConfiguration('etat_decodeur') != $etat_decodeur) {
                            $cmd->setConfiguration('etat_decodeur', $etat_decodeur);
                            $cmd->save();
                            $cmd->event($etat_decodeur);
                            JeeOrangeTv::refreshWidget();
                        }
                        break;
                    case 'fonction':
                        if (isset($retour['result']['data']['playedMediaState'])){
                            $retour_fonction = $retour['result']['data']['playedMediaState'];
                        } else {
                            $retour_fonction = "null";
                        }
                        if ($cmd->getConfiguration('fonction') != $retour_fonction) {
                            $cmd->setConfiguration('fonction', $retour_fonction);
                            $cmd->save();
                            $cmd->event($retour_fonction);
                            JeeOrangeTv::refreshWidget();
                        }
                        break;
                    case 'chaine_actuelle':
                        $osdContext = $retour['result']['data']['osdContext'];
                        switch ($osdContext) {
                            case 'HOMEPAGE':
                                $chaine_actu = 'home';
                                break;
                            case 'VOD':
                                $chaine_actu = 'vod';
                                break;
                            case 'LIVE':
                                $playId = intval($retour['result']['data']['playedMediaId']);
                                $id_actu = $this->getId();
                                $recherche = (array) cmd::searchConfiguration($playId);
                                foreach ($recherche as $equip => $result) {
                                    $id_trouv = $result->geteqLogic_id();
                                    if (($id_trouv === $id_actu)) {
                                        $id_chaine_actu = $result->getId();
                                        $chaine_actu = $result->getName();
                                        break;
                                    }
                                    else {
                                        $id_chaine_actu = null;
                                        $chaine_actu = 'blank';
                                    }
                                }
                                break;
                            default:
                                $id_chaine_actu = null;
                                $chaine_actu = 'blank';
                        }
                        if ($cmd->getConfiguration('chaine_actuelle') != $chaine_actu) {
                            $cmd->setConfiguration('id_chaine_actuelle', $id_chaine_actu);
                            $cmd->save();
                            $cmd->event($id_chaine_actu);
                            $cmd->setConfiguration('chaine_actuelle', $chaine_actu);
                            $cmd->save();
                            $cmd->event($chaine_actu);
                            JeeOrangeTv::refreshWidget();
                        }
                        break;
                }
            }
        }
        else
        {
            log::add('JeeOrangeTv', 'debug', '            |---> Décodeur ERREUR - ResponseCode : ' . $retour['result']['responseCode']);
            log::add('JeeOrangeTv', 'debug', '                |---> Le décodeur ne donne pas de réponse');
        }
        return;
    }

    public function Telecommande_Mosaique() {
        JeeOrangeTv::refreshWidget();
        return;
    }

    // commande par défaut
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
                    $JeeOrangeTvCmd->setConfiguration('tab_name', $cmd['configuration']['tab_name']);
                    $JeeOrangeTvCmd->setConfiguration('code_touche', $cmd['configuration']['code_touche']);
                    $JeeOrangeTvCmd->setConfiguration('mosaique_chaine', $cmd['configuration']['mosaique_chaine']);
                    $JeeOrangeTvCmd->setConfiguration('telecommande', $cmd['configuration']['telecommande']);
                    $JeeOrangeTvCmd->setConfiguration('etat_decodeur', 0);
                    $JeeOrangeTvCmd->setConfiguration('chaine_actuelle', $cmd['configuration']['chaine_actuelle']);
                    $JeeOrangeTvCmd->setConfiguration('id_chaine_actuelle', $cmd['configuration']['id_chaine_actuelle']);
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

    // Fonction pour appliquer un template chaine
    public function appliqueTemplate($eqLogic, $template) {
        $this->setConfiguration('template', $template);
        $this->save();
        $template_conf = json_decode(file_get_contents(dirname(__FILE__) . '/../config/' . $template . '.json'), true);
        foreach ($eqLogic->getCmd('action') as $cmd) {
            // selectionne uniquement la tab chaines
            if ($cmd->getConfiguration('tab_name') === 'tab_chaine' ){
                // supprime les existants
                $cmd->remove();
                $eqLogic->toHtml();
            }
        }

        $ValFrCat = array("Généraliste" => 1,
                           "Information" => 2,
                           "Découverte et Art de vivre" => 3,
                           "Sports" => 4,
                           "Jeunes adultes" => 5,
                           "Jeunesse" => 6,
                           "Divertissement" => 7,
                           "Société et Culture" => 8,
                           "Musique" => 9,
                           );

        // Création des nouvelles chaines
        foreach ($template_conf['liste'] as $chaine) {
            $JeeOrangeTvCmd = new JeeOrangeTvCmd();
            $JeeOrangeTvCmd->setName(__($chaine['nom'], __FILE__));
            $JeeOrangeTvCmd->setEqLogic_id($this->id);
            $JeeOrangeTvCmd->setLogicalId('chaine');
            $JeeOrangeTvCmd->setConfiguration('tab_name', 'tab_chaine');
            $JeeOrangeTvCmd->setConfiguration('ch_canal', $chaine['canal']);
            $JeeOrangeTvCmd->setConfiguration('ch_epg', $chaine['id']);
            $JeeOrangeTvCmd->setConfiguration('ch_logo', $chaine['logo']);
            $JeeOrangeTvCmd->setConfiguration('ch_categorie', $ValFrCat[$chaine['categorie']]);
            $JeeOrangeTvCmd->setType('action');
            $JeeOrangeTvCmd->setSubType('other');
            $JeeOrangeTvCmd->save();
        }
        return;
    }

    // Fonction pour appliquer le choix des mosaiques
    public function appliqueMosaique($eqLogic, $mosaique) {
        foreach ($eqLogic->getCmd('action') as $cmd) {
            // selectionne uniquement la tab mosaique
            if ($cmd->getConfiguration('tab_name') === 'tab_mosaique' ){
                // supprime les existants
                $cmd->remove();
                $eqLogic->toHtml();
            }
        }

        // // Création des nouvelles chaines
        foreach ($mosaique as $mos => $val) {
            if ($val != 'null') {
                // recupere les infos de la chaine puis applique sur la commande mosaique
                // recupere le nom de la chaine depuis son id
                $nom_chaine = cmd::byId($val)->getName();
                $logo_chaine = cmd::byId($val)->getConfiguration('ch_logo');
                $JeeOrangeTvCmd = new JeeOrangeTvCmd();
                $JeeOrangeTvCmd->setName(__($mos, __FILE__));
                $JeeOrangeTvCmd->setEqLogic_id($this->id);
                $JeeOrangeTvCmd->setLogicalId('mosaique');
                $JeeOrangeTvCmd->setConfiguration('tab_name', 'tab_mosaique');
                $JeeOrangeTvCmd->setConfiguration('ch_mosaique', $val);
                $JeeOrangeTvCmd->setConfiguration('nom', $nom_chaine);
                $JeeOrangeTvCmd->setConfiguration('logo', $logo_chaine);
                $JeeOrangeTvCmd->setType('action');
                $JeeOrangeTvCmd->setSubType('other');
                $JeeOrangeTvCmd->save();
            }
        }
        return;
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
        if ($this->getConfiguration('box_ip') === '') {
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
        $theme = $this->getConfiguration('theme');
        if ($theme === 'aucun') {
            return parent::toHtml($_version);
        }
        $replace = $this->preToHtml($_version);
        if (!is_array($replace)) {
            return $replace;
        }
        $_version = jeedom::versionAlias($_version);
        $replace['#theme#'] = $theme;
        foreach ($this->getCmd('info') as $info) {
            switch ($info->getLogicalId()) {
                case 'etat_decodeur' :
                    switch ($info->getConfiguration('etat_decodeur')) {
                        case 0:
                            $replace['#etat_decodeur#'] = '';
                            break;
                        case 1:
                            $replace['#etat_decodeur#'] = '<img class="onoff_' . $this->getId() . '" title="ON/OFF" src="plugins/JeeOrangeTv/core/template/' . $_version . '/images/Widget/on_' . $theme . '.png" style="position:absolute;top:0px;left:0px;z-index: 99;">';
                            break;
                        default:
                            $replace['#etat_decodeur#'] = '';
                    }
                    break;
                case 'chaine_actuelle' :
                    $id_chaine_actuel = $info->getConfiguration('id_chaine_actuelle');
                    if (!empty($id_chaine_actuel)) {
                        $logo_chaine_actuel = cmd::byId($id_chaine_actuel)->getConfiguration('ch_logo');
                    }
                    else {
                        $logo_chaine_actuel = $info->getConfiguration('chaine_actuelle');
                    }
                    $replace['#cmd_chaine_act#'] = '<img id="actuelle" src="plugins/JeeOrangeTv/core/template/' . $_version . '/images/Mosaique/' . $logo_chaine_actuel . '.png" style="position:absolute;top:63px;left:116px;">';
                    break;
            }
        }
        // Affichage de la Mosaique
        for ($i = 1; $i < 25; $i++)
        {
            $replace['#mos_Mosaïque_' . $i . '_visib#'] = 'hidden';
            $replace['#mos_Mosaïque_' . $i . '#'] = 'blank';
            $replace['#mos_Mosaïque_' . $i . '_logo#'] = 'blank';
            $replace['#mos_Mosaïque_' . $i . '_nom#'] = 'blank';
            $replace['#mos_Mosaïque_' . $i . '_id#'] = 'blank';
        }
        foreach ($this->getCmd('action') as $cmd) {
            $id_cmd = $cmd->getId();
            switch ($cmd->getLogicalId()) {
                case 'touche':
                    $replace['#cmd_' . $cmd->getName() . '_id#'] = $id_cmd;
                    break;
                case 'telecommande':
                    $replace['#mos_Telecommande_id#'] = $id_cmd;
                    $tel_mos = $cmd->getConfiguration('telecommande');
                    break;
                case 'mosaique':
                    $id_chaine = cmd::byId($id_cmd)->getConfiguration('ch_mosaique');
                    $nom_chaine = cmd::byId($id_chaine)->getName();
                    $logo_chaine = cmd::byId($id_chaine)->getConfiguration('ch_logo');
                    $replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_visib#'] = 'visible';
                    $replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'#'] = $logo_chaine;
                    $replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_logo#'] = $logo_chaine;
                    $replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_nom#'] = $nom_chaine;
                    $replace['#mos_'.str_replace(' ', '_', $cmd->getName()).'_id#'] = $id_cmd;
                    break;
            }
        }

        // Choix du widget a afficher
        switch ($tel_mos) {
            case 1:
                $widget = 'current';
                break;
            case 0:
                $widget = 'mosaique';
                break;
            default:
                $widget = 'current';
                break;
        }
        $html = template_replace($replace, getTemplate('core', $_version, $widget, 'JeeOrangeTv'));
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

    public function mosaique($TouchMosa) {
        $eqLogic = $this->getEqLogic();
        $box_ip = $eqLogic->getConfiguration('box_ip');
        switch ($TouchMosa) {
            case 'mosaique':
                $mos_idca = $this->getConfiguration('ch_mosaique');
                $prefix = cmd::byId($mos_idca);
                break;
            case 'chaine':
                $prefix = $this;
                break;
        }
        $mos_chaine = $prefix->getName();
        $mos_epg = $prefix->getConfiguration('ch_epg');
        $mos_canal = $prefix->getConfiguration('ch_canal');
        log::add('JeeOrangeTv', 'info', '|---> Mosaique Chaine : ' . $mos_chaine . ' - Numéro de la chaine : '. $mos_canal . ' - EPG de la chaine : '. $mos_epg);
        if (!empty($mos_epg) && $mos_epg > 0) {
            $eqLogic->ActionZapChaine($box_ip, $mos_epg);
        }
        else {
            $mos_touche = str_split($mos_canal);
            $nb_touches = count($mos_touche);
            $i = 1;
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
                            log::add('JeeOrangeTv', 'debug', '    |---> Action non executée pour "' . $eqLogic->getName() . '" car code touche vide vérifier paramètres des touches');
                        }
                    }
                }
            }
        }
    }

    public function execute($_options = array()) {
        $eqLogic = $this->getEqLogic();
        $box_ip = $eqLogic->getConfiguration('box_ip');
        $code_mode = 0;
        $LogicalId = $this->getLogicalId();
        switch ($LogicalId) {
            case "telecommande":
                $act_mos = $this->getConfiguration('telecommande');
                if ($act_mos === 1) {
                    $this->setConfiguration('telecommande', 0);
                    $this->save();
                }
                if ($act_mos === 0) {
                    $this->setConfiguration('telecommande', 1);
                    $this->save();
                }
                $eqLogic->refreshWidget();
                break;
            case "touche":
                $code_touche = $this->getConfiguration('code_touche');
                if (!empty($code_touche)) {
                    log::add('JeeOrangeTv', 'info', '|---> Action executée - IP : ' . $box_ip . ' - touche : ' . $this->getName() . ' - code touche : ' . $code_touche . ' - mode : ' . $code_mode);
                    $eqLogic->ActionTouche($box_ip, $code_touche, $code_mode);
                }
                else {
                    log::add('JeeOrangeTv', 'debug', '    |---> Action non executée pour "' . $eqLogic->getName() . '" car code touche vide vérifier paramètres des touches');
                }
                break;
            case "mosaique":
                JeeOrangeTvCmd::mosaique('mosaique');
                break;
            case "chaine":
                JeeOrangeTvCmd::mosaique('chaine');
                break;
        }
        return;
    }

    /*     * **********************Getteur Setteur*************************** */
}

