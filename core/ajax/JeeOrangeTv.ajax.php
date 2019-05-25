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

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new \Exception(__('401 - Accès non autorisé', __FILE__));
    }
    
    ajax::init();
    
    // liste des fichiers json de configuration des chaines
    if (init('action') == 'listeFichiersConf') {
        $result = "";
        if($dossier = opendir(realpath(dirname(__FILE__) . '/../../core/config')))
        {
            while(false !== ($fichier = readdir($dossier)))
            {
                if($fichier != '.' && $fichier != '..' && pathinfo($fichier, PATHINFO_EXTENSION) === 'json')
                {
                    $nom_fichier = explode(".", $fichier);
                    $result = $result . '<option value="' . $nom_fichier[0] . '">' . $nom_fichier[0] . '</option>';
                }
            }
            closedir($dossier);
        }
        ajax::success($result);
    }

    // liste des fichiers logo
    if (init('action') == 'listeLogo') {
        $result = "";
        if($dossier = opendir(realpath(dirname(__FILE__) . '/../../core/template/dashboard/images/Mosaique')))
        {
            while(false !== ($logo = readdir($dossier)))
            {
                if($logo != '.' && $logo != '..' && pathinfo($logo, PATHINFO_EXTENSION) === 'png')
                {
                    $nom_logo = explode(".", $logo);
                    $result = $result . '<option value="' . $nom_logo[0] . '">' . $nom_logo[0] . '</option>';
                }
            }
            closedir($dossier);
        }
        ajax::success($result);
    }

    // appliquer modèle des chaines
    if (init('action') === 'appliqueTemplate') {
        $template = init('template');
        $eqLogic = JeeOrangeTv::byId(init('id'));
        $eqLogic->appliqueTemplate($eqLogic, $template);
        ajax::success();
    }    
    throw new \Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (\Exception $e) {
    ajax::error(displayException($e), $e->getCode());
}
