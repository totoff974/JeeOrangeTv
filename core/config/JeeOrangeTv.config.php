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
            'etat_decodeur'=> 0,
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
            'chaine_actuelle'=> 'aucune',
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
        'logicalId' => 'on_off',
        'type' => 'action',
        'subType' => 'other',
        'order' => 5,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '116',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => '1',
        'logicalId' => '1',
        'type' => 'action',
        'subType' => 'other',
        'order' => 6,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '513',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '2',
        'logicalId' => '2',
        'type' => 'action',
        'subType' => 'other',
        'order' => 7,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '514',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '3',
        'logicalId' => '3',
        'type' => 'action',
        'subType' => 'other',
        'order' => 8,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '515',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '4',
        'logicalId' => '4',
        'type' => 'action',
        'subType' => 'other',
        'order' => 9,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '516',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '5',
        'logicalId' => '5',
        'type' => 'action',
        'subType' => 'other',
        'order' => 10,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '517',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => '6',
        'logicalId' => '6',
        'type' => 'action',
        'subType' => 'other',
        'order' => 11,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '518',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '7',
        'logicalId' => '7',
        'type' => 'action',
        'subType' => 'other',
        'order' => 12,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '519',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '8',
        'logicalId' => '8',
        'type' => 'action',
        'subType' => 'other',
        'order' => 13,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '520',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '9',
        'logicalId' => '9',
        'type' => 'action',
        'subType' => 'other',
        'order' => 14,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '521',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => '0',
        'logicalId' => '0',
        'type' => 'action',
        'subType' => 'other',
        'order' => 15,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '512',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'CH+',
        'logicalId' => 'chaine+',
        'type' => 'action',
        'subType' => 'other',
        'order' => 16,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '402',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'CH-',
        'logicalId' => 'chaine-',
        'type' => 'action',
        'subType' => 'other',
        'order' => 17,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '403',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'VOL+',
        'logicalId' => 'volume+',
        'type' => 'action',
        'subType' => 'other',
        'order' => 18,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '115',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'VOL-',
        'logicalId' => 'volume-',
        'type' => 'action',
        'subType' => 'other',
        'order' => 19,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '114',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'MUTE',
        'logicalId' => 'mute',
        'type' => 'action',
        'subType' => 'other',
        'order' => 20,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '113',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'UP',
        'logicalId' => 'up',
        'type' => 'action',
        'subType' => 'other',
        'order' => 21,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '103',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'DOWN',
        'logicalId' => 'down',
        'type' => 'action',
        'subType' => 'other',
        'order' => 22,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '108',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'LEFT',
        'logicalId' => 'left',
        'type' => 'action',
        'subType' => 'other',
        'order' => 23,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '105',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'RIGHT',
        'logicalId' => 'right',
        'type' => 'action',
        'subType' => 'other',
        'order' => 24,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '106',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'OK',
        'logicalId' => 'ok',
        'type' => 'action',
        'subType' => 'other',
        'order' => 25,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '352',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'BACK',
        'logicalId' => 'back',
        'type' => 'action',
        'subType' => 'other',
        'order' => 26,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '158',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'MENU',
        'logicalId' => 'menu',
        'type' => 'action',
        'subType' => 'other',
        'order' => 27,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '139',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'PLAY-PAUSE',
        'logicalId' => 'play_pause',
        'type' => 'action',
        'subType' => 'other',
        'order' => 28,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '164',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'FBWD',
        'logicalId' => 'fbwd',
        'type' => 'action',
        'subType' => 'other',
        'order' => 29,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '168',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'FFWD',
        'logicalId' => 'ffwd',
        'type' => 'action',
        'subType' => 'other',
        'order' => 30,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '159',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'STOP',
        'logicalId' => 'stop',
        'type' => 'action',
        'subType' => 'other',
        'order' => 31,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '166',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'REC',
        'logicalId' => 'rec',
        'type' => 'action',
        'subType' => 'other',
        'order' => 32,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '167',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'VOD',
        'logicalId' => 'vod',
        'type' => 'action',
        'subType' => 'other',
        'order' => 33,
        'isVisible' => true,
        'configuration' => array(
            'code_touche'=> '393',
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 1',
        'logicalId' => 'mosaique_1',
        'type' => 'action',
        'subType' => 'other',
        'order' => 34,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),
    array(
        'name' => 'Mosaique 2',
        'logicalId' => 'mosaique_2',
        'type' => 'action',
        'subType' => 'other',
        'order' => 35,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 3',
        'logicalId' => 'mosaique_3',
        'type' => 'action',
        'subType' => 'other',
        'order' => 36,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 4',
        'logicalId' => 'mosaique_4',
        'type' => 'action',
        'subType' => 'other',
        'order' => 37,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 5',
        'logicalId' => 'mosaique_5',
        'type' => 'action',
        'subType' => 'other',
        'order' => 38,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 6',
        'logicalId' => 'mosaique_6',
        'type' => 'action',
        'subType' => 'other',
        'order' => 39,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 7',
        'logicalId' => 'mosaique_7',
        'type' => 'action',
        'subType' => 'other',
        'order' => 40,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 8',
        'logicalId' => 'mosaique_8',
        'type' => 'action',
        'subType' => 'other',
        'order' => 41,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 9',
        'logicalId' => 'mosaique_9',
        'type' => 'action',
        'subType' => 'other',
        'order' => 42,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 10',
        'logicalId' => 'mosaique_10',
        'type' => 'action',
        'subType' => 'other',
        'order' => 43,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 11',
        'logicalId' => 'mosaique_11',
        'type' => 'action',
        'subType' => 'other',
        'order' => 44,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),
    array(
        'name' => 'Mosaique 12',
        'logicalId' => 'mosaique_12',
        'type' => 'action',
        'subType' => 'other',
        'order' => 45,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 13',
        'logicalId' => 'mosaique_13',
        'type' => 'action',
        'subType' => 'other',
        'order' => 46,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 14',
        'logicalId' => 'mosaique_14',
        'type' => 'action',
        'subType' => 'other',
        'order' => 47,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 15',
        'logicalId' => 'mosaique_15',
        'type' => 'action',
        'subType' => 'other',
        'order' => 48,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 16',
        'logicalId' => 'mosaique_16',
        'type' => 'action',
        'subType' => 'other',
        'order' => 49,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 17',
        'logicalId' => 'mosaique_17',
        'type' => 'action',
        'subType' => 'other',
        'order' => 50,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 18',
        'logicalId' => 'mosaique_18',
        'type' => 'action',
        'subType' => 'other',
        'order' => 51,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 19',
        'logicalId' => 'mosaique_19',
        'type' => 'action',
        'subType' => 'other',
        'order' => 52,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 20',
        'logicalId' => 'mosaique_20',
        'type' => 'action',
        'subType' => 'other',
        'order' => 53,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 21',
        'logicalId' => 'mosaique_21',
        'type' => 'action',
        'subType' => 'other',
        'order' => 54,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Mosaique 22',
        'logicalId' => 'mosaique_22',
        'type' => 'action',
        'subType' => 'other',
        'order' => 55,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 23',
        'logicalId' => 'mosaique_23',
        'type' => 'action',
        'subType' => 'other',
        'order' => 56,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),

    array(
        'name' => 'Mosaique 24',
        'logicalId' => 'mosaique_24',
        'type' => 'action',
        'subType' => 'other',
        'order' => 57,
        'isVisible' => false,
        'configuration' => array(
            'mosaique_chaine'=> 'blank',
            'mosaique_numero'=> null,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '1',
    ),

    array(
        'name' => 'Telecommande',
        'logicalId' => 'telecommande',
        'type' => 'action',
        'subType' => 'other',
        'order' => 58,
        'isVisible' => false,
        'configuration' => array(
            'telecommande'=> 1,
        ),
        'generic_type' => 'GENERIC_ACTION',
        'forceReturnLineAfter' => '0',
    ),
);
?>