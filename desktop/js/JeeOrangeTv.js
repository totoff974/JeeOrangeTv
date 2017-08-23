
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

 $("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});	

 function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }

	if (init(_cmd.name).indexOf("Mosaique ") == '-1' && init(_cmd.name) != "Telecommande") {
		if (init(_cmd.type) == 'info') {
			 var disabled = (init(_cmd.configuration.virtualAction) == '1') ? 'disabled' : '';
			 var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '" virtualAction="' + init(_cmd.configuration.virtualAction) + '">';
			 tr += '<td>';
			 tr += '<span class="cmdAttr" data-l1key="id"></span>';
			 tr += '</td>';
			 tr += '<td> ';
			 tr += '<div class="col-sm-6">';
			 tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
			 tr += '</div>';
			 tr += '</td>';
			 // tr += '<td>';
			 // tr += '<input class="cmdAttrcmdAttr form-control type input-sm expertModeVisible" data-l1key="type" value="info" disabled style="margin-bottom : 5px;" />';
			 // tr += '</td>';
			 tr += '<td>';
			 if (init(_cmd.name) == 'Etat') {
				 tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="configuration" data-l2key="etat" style="margin-bottom : 5px;" />';
			 }
			 if (init(_cmd.name) == 'Fonction') {
				 tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="configuration" data-l2key="fonction" style="margin-bottom : 5px;" />';
			 }			 
			 if (init(_cmd.name) == 'Chaine Actuelle') {
				 tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="configuration" data-l2key="chaine_actuelle" style="margin-bottom : 5px;" />';
			 }
			 tr += '</td>';
			 tr += '<td>';
			 tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
			 tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked/>{{Historiser}}</label></span> ';
			 tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr expertModeVisible" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label></span><br/>';
			 tr += '</td>';
			 tr += '<td>';
			 if (is_numeric(_cmd.id)) {
				tr += '<a class="btn btn-default btn-xs cmdAction " data-action="configure"><i class="fa fa-cogs"></i></a> ';
				tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
			}
			tr += '</td>';
			tr += '</tr>';
			$('#table_cmd tbody').append(tr);
			$('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
			if (isset(_cmd.type)) {
				$('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
			}
			jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
		}	
		if (init(_cmd.type) == 'action') {
			var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
			tr += '<td>';
			tr += '<span class="cmdAttr" data-l1key="id"></span>';
			tr += '</td>';
			tr += '<td>';
			tr += '<div class="col-sm-6">';
			tr += '<input disabled class="cmdAttr form-control input-sm" data-l1key="name">';
			tr += '</div>';
			tr += '</td>';
			// tr += '<td>';
			// tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="type" value="action" disabled style="margin-bottom : 5px;" />';
			// tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
			// tr += '<input class="cmdAttr" data-l1key="configuration" data-l2key="virtualAction" value="1" style="display:none;" >';
			// tr += '</td>';
			tr += '<td>';
			if (init(_cmd.name) != 'Refresh') {
			tr += '<span>{{Code touche : }}<br/></span><input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="code_touche" style="margin-bottom : 5px;width : 50%; display : inline-block;" />';
			}
			tr += '</td>';
			tr += '<td>';
			tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
			tr += '</td>';
			tr += '<td>';
			if (is_numeric(_cmd.id)) {
				tr += '<a class="btn btn-default btn-xs cmdAction " data-action="configure"><i class="fa fa-cogs"></i></a> ';
				tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
			}
			tr += '</td>';
			tr += '</tr>';

			$('#table_cmd tbody').append(tr);
			$('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
			var tr = $('#table_cmd tbody tr:last');
		}
	}
	
	if (init(_cmd.name).indexOf("Mosaique ") != '-1') {
		if (init(_cmd.type) == 'action') {

				var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
				tr += '<td>';
				tr += '<span class="cmdAttr" data-l1key="id"></span>';
				tr += '</td>';
				
				tr += '<td>';
				tr += '<div class="col-sm-6">';
				tr += '<input disabled class="cmdAttr form-control input-sm" data-l1key="name">';
				tr += '</div>';
				tr += '</td>';
				
				tr += '<td>';
				tr += '<select class="cmdAttr form-control" data-l1key="configuration" data-l2key="mosaique_chaine">';
				tr += '</select>';				
				tr += '</td>';
								
				tr += '<td>';
				tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
				tr += '</td>';
				
				tr += '<td>';
				if (is_numeric(_cmd.id)) {
					tr += '<a class="btn btn-default btn-xs cmdAction " data-action="configure"><i class="fa fa-cogs"></i></a> ';
					tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
				}
				tr += '</td>';
				tr += '</tr>';
			}
			
		$('#mosaique tbody').append(tr);
		$('#mosaique tbody tr:last').setValues(_cmd, '.cmdAttr');
		var tr = $('#mosaique tbody tr:last');

		code_loc = $('.eqLogicAttr[data-l1key=configuration][data-l2key=localisation]').val();
		$.getJSON('plugins/JeeOrangeTv/core/config/chaines.json', function(chaine) {
			tr.find('.cmdAttr[data-l1key=configuration][data-l2key=mosaique_chaine]').append('<option value="blank">{{ }}</option>');			
			$.each(chaine.localisation,function(index_loc,liste_loc){
				if (code_loc == liste_loc.code) {
					$.each(liste_loc.liste,function(index_chaine,nom_chaine){						
						tr.find('.cmdAttr[data-l1key=configuration][data-l2key=mosaique_chaine]').append('<option value="'+ nom_chaine.logo +'">{{'+ nom_chaine.nom +'}}</option>');
					});
				}
            });
		tr.setValues(_cmd, '.cmdAttr');
		});
}
	if (init(_cmd.name) == "Telecommande") {
		if (init(_cmd.type) == 'action') {

				var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
				tr += '<td>';
				tr += '<span class="cmdAttr" data-l1key="id"></span>';
				tr += '</td>';
				
				tr += '<td>';
				tr += '<div class="col-sm-6">';
				tr += '<input disabled class="cmdAttr form-control input-sm" data-l1key="name">';
				tr += '</div>';
				tr += '</td>';
				
				tr += '<td>';
			
				tr += '</td>';
				
				tr += '<td>';
				tr += '<div class="col-sm-3" style="visibility: hidden">';
				tr += '<input type="number" class="cmdAttr form-control" data-l1key="configuration" data-l2key="telecommande" disabled/>';
				tr += '</div>';
				tr += '</td>';
				
				tr += '<td>';
				tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
				tr += '</td>';
				
				tr += '<td>';
				if (is_numeric(_cmd.id)) {
					tr += '<a class="btn btn-default btn-xs cmdAction " data-action="configure"><i class="fa fa-cogs"></i></a> ';
					tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
				}
				tr += '</td>';
				tr += '</tr>';
			}
		$('#mosaique tbody').append(tr);
		$('#mosaique tbody tr:last').setValues(_cmd, '.cmdAttr');
		var tr = $('#mosaique tbody tr:last');
	}
}
