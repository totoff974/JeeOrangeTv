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

    // appliquer le choix des mosaiques
    if (init('action') === 'appliqueMosaique') {
        $mosaique = init('mosaique');
        $eqLogic = JeeOrangeTv::byId(init('id'));
        $eqLogic->appliqueMosaique($eqLogic, $mosaique);
        ajax::success();
    }

    // telecharge une nouvelle image pour les logos
    if (init('action') === 'uploadImageLogo') {
        if (!isConnect('admin')) {
            throw new Exception(__('401 - Accès non autorisé', __FILE__));
        }
        unautorizedInDemo();
        if (!isset($_FILES['file'])) {
            throw new Exception(__('Aucun fichier trouvé. Vérifiez le paramètre PHP (post size limit)', __FILE__));
        }
        $extension = strtolower(strrchr($_FILES['file']['name'], '.'));
        if (!in_array($extension, array('.png'))) {
            throw new Exception('Extension du fichier non valide (autorisé .png) : ' . $extension);
        }
        if (filesize($_FILES['file']['tmp_name']) > 1000000) {
            throw new Exception(__('Le fichier est trop gros (maximum 1Mo)', __FILE__));
        }
        
        $img_size = getimagesize($_FILES['file']['tmp_name']);
        
        if ($img_size[0] != 100 and $img_size[1] != 50) {
            throw new Exception(__('Le fichier doit avoir une hauteur de 50px et une largeur de 100px', __FILE__));
        }
        
        $filename = $_FILES['file']['name'];
        $filepath = __DIR__ . '/../template/dashboard/images/Mosaique/' . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $filepath);
        if(!file_exists($filepath)){
            throw new \Exception(__('Impossible de sauvegarder l\'image' . $filepath,__FILE__));
        }
        ajax::success();
    }

    if (init('action') === 'removeImageLogo') {
        if (!isConnect('admin')) {
            throw new Exception(__('401 - Accès non autorisé', __FILE__));
        }
        unautorizedInDemo();
        $filename = init('filename');
        @rrmdir(__DIR__ . '/../template/dashboard/images/Mosaique/' . $filename);
        ajax::success();
    }

    throw new \Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (\Exception $e) {
    ajax::error(displayException($e), $e->getCode());
}
