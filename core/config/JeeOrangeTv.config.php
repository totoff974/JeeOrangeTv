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

global $listCmdJeeOrangeTv;

$listCmdJeeOrangeTv = array(
    array(
        'name' => 'Etat Decodeur',
        'logicalId' => 'etat_decodeur',
        'type' => 'info',
        'subType' => 'binary',
        'order' => 1,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'etat_decodeur' => 0,
        ),
        'generic_type' => 'GENERIC_STATE',
    ),

    array(
        'name' => 'Chaine Actuelle',
        'logicalId' => 'chaine_actuelle',
        'type' => 'info',
        'subType' => 'string',
        'order' => 2,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'chaine_actuelle'=> 'blank',
            'id_chaine_actuelle'=> -1,
        ),
        'generic_type' => 'GENERIC_STATE',
    ),

    array(
        'name' => 'Fonction',
        'logicalId' => 'fonction',
        'type' => 'info',
        'subType' => 'string',
        'order' => 3,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'fonction'=> 'aucune',
        ),
        'generic_type' => 'GENERIC_STATE',
    ),

    array(
        'name' => 'Refresh',
        'logicalId' => 'refresh',
        'type' => 'action',
        'subType' => 'other',
        'order' => 4,
        'isVisible' => true,
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'ON-OFF',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 5,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '116',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => '1',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 6,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '513',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '2',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 7,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '514',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '3',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 8,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '515',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '4',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 9,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '516',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '5',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 10,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '517',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => '6',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 11,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '518',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '7',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 12,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '519',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '8',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 13,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '520',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '9',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 14,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '521',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '0',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 15,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '512',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'CH+',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 16,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '402',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'CH-',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 17,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '403',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'VOL+',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 18,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '115',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'VOL-',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 19,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '114',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'MUTE',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 20,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '113',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'UP',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 21,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '103',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'DOWN',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 22,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '108',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'LEFT',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 23,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '105',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'RIGHT',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 24,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '106',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'OK',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 25,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '352',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'BACK',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 26,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '158',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'MENU',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 27,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '139',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'PLAY-PAUSE',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 28,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '164',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'FBWD',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 29,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '168',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'FFWD',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 30,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '159',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'STOP',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 31,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '166',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'REC',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 32,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '167',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'VOD',
        'logicalId' => 'touche',
        'type' => 'action',
        'subType' => 'other',
        'order' => 33,
        'isVisible' => true,
        'configuration' => array(
            'tab_name' => 'tab_touche',
            'code_touche'=> '393',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),
);
?>
