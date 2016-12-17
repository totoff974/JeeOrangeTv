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
        'name' => 'etat',
        'type' => 'info',
        'subType' => 'binary',
		'order' => 0,
		'configuration' => array(
			'etat'=> '',
        ),
		'generic_type' => 'GENERIC_STATE',
    ),
	
    array(
        'name' => 'ON-OFF',
        'type' => 'action',
        'subType' => 'other',
		'order' => 0,
		'configuration' => array(
			'code_touche'=> '116',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '1',
    ),
	
    array(
        'name' => '1',
        'type' => 'action',
        'subType' => 'other',
		'order' => 1,
		'configuration' => array(
			'code_touche'=> '513',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '2',
        'type' => 'action',
        'subType' => 'other',
		'order' => 2,
		'configuration' => array(
			'code_touche'=> '514',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '3',
        'type' => 'action',
        'subType' => 'other',
		'order' => 3,
		'configuration' => array(
			'code_touche'=> '515',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '4',
        'type' => 'action',
        'subType' => 'other',
		'order' => 4,
		'configuration' => array(
			'code_touche'=> '516',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '5',
        'type' => 'action',
        'subType' => 'other',
		'order' => 5,
		'configuration' => array(
			'code_touche'=> '517',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '1',
    ),	
	
    array(
        'name' => '6',
        'type' => 'action',
        'subType' => 'other',
		'order' => 6,
		'configuration' => array(
			'code_touche'=> '518',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '7',
        'type' => 'action',
        'subType' => 'other',
		'order' => 7,
		'configuration' => array(
			'code_touche'=> '519',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '8',
        'type' => 'action',
        'subType' => 'other',
		'order' => 8,
		'configuration' => array(
			'code_touche'=> '520',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => '9',
        'type' => 'action',
        'subType' => 'other',
		'order' => 9,
		'configuration' => array(
			'code_touche'=> '521',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),
	
    array(
        'name' => '0',
        'type' => 'action',
        'subType' => 'other',
		'order' => 10,
		'configuration' => array(
			'code_touche'=> '512',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '1',
    ),	
	
    array(
        'name' => 'CH+',
        'type' => 'action',
        'subType' => 'other',
		'order' => 11,
		'configuration' => array(
			'code_touche'=> '402',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'CH-',
        'type' => 'action',
        'subType' => 'other',
		'order' => 12,
		'configuration' => array(
			'code_touche'=> '403',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'VOL+',
        'type' => 'action',
        'subType' => 'other',
		'order' => 13,
		'configuration' => array(
			'code_touche'=> '115',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'VOL-',
        'type' => 'action',
        'subType' => 'other',
		'order' => 14,
		'configuration' => array(
			'code_touche'=> '114',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'MUTE',
        'type' => 'action',
        'subType' => 'other',
		'order' => 15,
		'configuration' => array(
			'code_touche'=> '113',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '1',
    ),	
	
    array(
        'name' => 'UP',
        'type' => 'action',
        'subType' => 'other',
		'order' => 16,
		'configuration' => array(
			'code_touche'=> '103',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'DOWN',
        'type' => 'action',
        'subType' => 'other',
		'order' => 17,
		'configuration' => array(
			'code_touche'=> '108',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'LEFT',
        'type' => 'action',
        'subType' => 'other',
		'order' => 18,
		'configuration' => array(
			'code_touche'=> '105',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'RIGHT',
        'type' => 'action',
        'subType' => 'other',
		'order' => 19,
		'configuration' => array(
			'code_touche'=> '116',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'OK',
        'type' => 'action',
        'subType' => 'other',
		'order' => 20,
		'configuration' => array(
			'code_touche'=> '352',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '1',
    ),	
	
    array(
        'name' => 'BACK',
        'type' => 'action',
        'subType' => 'other',
		'order' => 21,
		'configuration' => array(
			'code_touche'=> '158',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'MENU',
        'type' => 'action',
        'subType' => 'other',
		'order' => 22,
		'configuration' => array(
			'code_touche'=> '139',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'PLAY-PAUSE',
        'type' => 'action',
        'subType' => 'other',
		'order' => 23,
		'configuration' => array(
			'code_touche'=> '164',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'FBWD',
        'type' => 'action',
        'subType' => 'other',
		'order' => 24,
		'configuration' => array(
			'code_touche'=> '168',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'FFWD',
        'type' => 'action',
        'subType' => 'other',
		'order' => 25,
		'configuration' => array(
			'code_touche'=> '159',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'REC',
        'type' => 'action',
        'subType' => 'other',
		'order' => 26,
		'configuration' => array(
			'code_touche'=> '167',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
	
    array(
        'name' => 'VOD',
        'type' => 'action',
        'subType' => 'other',
		'order' => 27,
		'configuration' => array(
			'code_touche'=> '393',
        ),
		'generic_type' => 'GENERIC_ACTION',
		'forceReturnLineAfter' => '0',
    ),	
);
?>
