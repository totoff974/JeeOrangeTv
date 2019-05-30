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

$('#div_pageContainer').on( 'click', '.cmd .cmdAction[data-action=btn_test]',function () {
  var _logo = false
  if ( $('div[data-l2key="logo"] > i').length ) {
    _logo = $('div[data-l2key="logo"] > i').attr('class')
    _logo = '.' + _logo.replace(' ', '.')
  }
  chooseLogo(function (_logo) {
    $('.objectAttr[data-l1key=display][data-l2key=logo]').empty().append(_logo);
  },{logo:_logo});
});

function chooseLogo(_callback, _params) {
  if ($("#mod_selectLogo").length == 0) {
    $('#div_pageContainer').append('<div id="mod_selectLogo"></div>');
    $("#mod_selectLogo").dialog({
      title: '{{Choisissez une logo}}',
      closeText: '',
      autoOpen: false,
      modal: true,
      height: (jQuery(window).height() - 150),
      width: 1500,
      open: function () {
        if ((jQuery(window).width() - 50) < 1500) {
          $('#mod_selectLogo').dialog({width: jQuery(window).width() - 50});
        }
        $("body").css({overflow: 'hidden'});
        setTimeout(function(){initTooltips($("#mod_selectLogo"))},500);
      },
      beforeClose: function (event, ui) {
        $("body").css({overflow: 'inherit'});
      }
    });
  }
  var url = 'index.php?v=d&plugin=JeeOrangeTv&modal=logo.JeeOrangeTv';
  if(_params && _params.img && _params.img === true) {
    url += '&showimg=1';
  }
  if(_params && _params.logo) {
    logo = _params.logo
    replaceAr = ['logo_blue', 'logo_green', 'logo_orange', 'logo_red', 'logo_yellow']
    replaceAr.forEach(function(element) {
      logo = logo.replace(element, '')
    })
    logo = logo.trim().replace(new RegExp('  ', 'g'), ' ')
    logo = logo.trim().replace(new RegExp(' ', 'g'), '.')
    url += '&selectLogo=' + logo;
  }
  $('#mod_selectLogo').empty().load(url,function(){
    $("#mod_selectLogo").dialog('option', 'buttons', {
      "Annuler": function () {
        $(this).dialog("close");
      },
      "Valider": function () {
        var logo = $('.logoSelected .logoSel').html();
        if (logo == undefined) {
          logo = '';
        }
        logo = logo.replace(/"/g, "'");
        _callback(logo);
        $(this).dialog('close');
      }
    });
    $('#mod_selectLogo').dialog('open');
  });
}

$('#btn_mosaique').on('click', function () {
    var logicalId = $('.eqLogicAttr[data-l1key=id]').value();
    $('#md_modal').dialog({title: "{{Configuration de la Mosaïque}}"});
    $('#md_modal').load('index.php?v=d&plugin=JeeOrangeTv&modal=mosaique.JeeOrangeTv&id='+logicalId).dialog('open');
});

$("#bt_addChaine").on('click', function (event) {
    var _cmd = {type: 'action'};
    addCmdToTableChaine(_cmd);
});

$('#bt_autoChaine').on('click', function () {
    var dialog_title = '{{Configuration automatique}}';
    var dialog_message = "";
    $.ajax({
        type: "POST",
        url: "plugins/JeeOrangeTv/core/ajax/JeeOrangeTv.ajax.php",
        data: {
            action: "listeFichiersConf",
        },
        dataType: 'json',
        global: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function (data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: 'Erreur sur le listing des fichiers de configuration'  + data.result, level: 'danger'});
                return;
            }
            else {
                var dialog_message = '<form class="form-horizontal onsubmit="return true;"> ';
                dialog_title = '{{Configuration automatique}}';
                dialog_message += '{{Choix du modèle à appliquer : }}';
                dialog_message += '<select id="templateChaine">' + data.result +'</select>';
                dialog_message +='<br>';
                dialog_message +='<label class="lbl lbl-warning" for="name">{{Attention, cette action va supprimer les chaînes existantes.}}</label> ';
                dialog_message += '</form>';
                bootbox.dialog({
                    title: dialog_title,
                    message: dialog_message,
                    buttons: {
                    "{{Annuler}}": {
                        className: "btn-danger",
                        callback: function () {
                        }
                    },
                    success: {
                        label: "{{Démarrer}}",
                        className: "btn-success",
                        callback: function () {
                            var valueTemplateChaine = $('#templateChaine').val();
                            bootbox.confirm('{{Etes-vous sûr de vouloir récréer toutes les commandes ? Cela va supprimer les commandes existantes}}', function (result) {
                                if (result) {
                                    $('#div_alert').showAlert({message: '{{Opération en cours... Merci de patienter...}}', level: 'success'});
                                    $.showLoading();
                                    $.ajax({
                                        type: "POST",
                                        url: "plugins/JeeOrangeTv/core/ajax/JeeOrangeTv.ajax.php",
                                        data: {
                                            action: "appliqueTemplate",
                                            id: $('.eqLogicAttr[data-l1key=id]').value(),
                                            template: valueTemplateChaine,
                                        },
                                        dataType: 'json',
                                        global: false,
                                        error: function (request, status, error) {
                                            handleAjaxError(request, status, error);
                                        },
                                        success: function (data) {
                                            if (data.state != 'ok') {
                                                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                                                return;
                                            }
                                            window.location.reload();
                                        }
                                    });
                                }
                            });
                        }
                    },
                }
            });
            }
        }
    });
});

$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#table_liste_touches").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
$("#table_liste_chaines").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

// fonction pour remplir la tab touches
function addCmdToTableTouches(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }
    
    if (init(_cmd.type) === 'info') {
         var disabled = (init(_cmd.configuration.virtualAction) == '1') ? 'disabled' : '';
         var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '" virtualAction="' + init(_cmd.configuration.virtualAction) + '">';
         tr += '<td>';
         tr += '<span class="cmdAttr" data-l1key="id"></span>';
         tr += '</td>';
         tr += '<td> ';
         tr += '<div class="col-sm-6">';
         tr += '<input disabled class="cmdAttr form-control input-sm" data-l1key="name">';
         tr += '</div>';
         tr += '</td>';

         tr += '<td>';
         if (init(_cmd.name) === 'Etat Decodeur') {
             tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="configuration" data-l2key="etat_decodeur" disabled style="margin-bottom : 5px;" />';
         }
         if (init(_cmd.name) === 'Fonction') {
             tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="configuration" data-l2key="fonction" disabled style="margin-bottom : 5px;" />';
         }
         if (init(_cmd.name) === 'Chaine Actuelle') {
             tr += '<input class="cmdAttr form-control type input-sm expertModeVisible" data-l1key="configuration" data-l2key="chaine_actuelle" disabled style="margin-bottom : 5px;" />';
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
        $('#table_liste_touches tbody').append(tr);
        $('#table_liste_touches tbody tr:last').setValues(_cmd, '.cmdAttr');
        if (isset(_cmd.type)) {
            $('#table_liste_touches tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
        }
        jeedom.cmd.changeType($('#table_liste_touches tbody tr:last'), init(_cmd.subType));
    }
    if (init(_cmd.type) === 'action') {
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
        if (init(_cmd.name) != 'Refresh') {
            tr += '<span>{{Code touche : }}<br/></span><input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="code_touche" style="margin-bottom : 5px;width : 50%; display : inline-block;" />';
        }
        tr += '</td>';
        tr += '<td>';
        tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
        tr += '</td>';
        tr += '<td>';
        if (is_numeric(_cmd.id)) {
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
        }
        tr += '</td>';
        tr += '</tr>';

        $('#table_liste_touches tbody').append(tr);
        $('#table_liste_touches tbody tr:last').setValues(_cmd, '.cmdAttr');
        var tr = $('#table_liste_touches tbody tr:last');
    }
}

function addCmdToTableChaines(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }

    if (init(_cmd.type) === 'action') {
        var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
        tr += '<td>';
        tr += '<span class="cmdAttr" data-l1key="id"></span>';
        tr += '<input style="display:none;" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="tab_name" value="tab_chaine">';
        tr += '</td>';
        tr += '<td> ';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom}}">';
        tr += '<span style="display:none;" class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
        tr += '<span style="display:none;" class="subType" subType="' + init(_cmd.subType) + '"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="ch_canal" type="number" min="0" placeholder="{{Canal}}">';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="ch_epg" type="number" min="-1" max="9999999999" placeholder="{{EPG}}">';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm col-md-10" data-l1key="configuration" data-l2key="ch_logo" placeholder="{{Logo}}">';
        tr += '<div class="objectAttr" data-l1key="display" data-l2key="logo" style="font-size : 1.5em;"></div>';
        tr += '<a class="btn btn-default btn-sm cmdAction col-md-2" data-action="btn_test"><i class="fa fa-link"></i></a>';
        tr += '</td>';
        tr += '<td>';
        tr += '<select class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="ch_categorie">';
        tr += '<option value="1">{{Généraliste}}</option>';
        tr += '<option value="2">{{Information}}</option>';
        tr += '<option value="3">{{Découverte et Art de vivre}}</option>';
        tr += '<option value="4">{{Sports}}</option>';
        tr += '<option value="5">{{Jeunes adultes}}</option>';
        tr += '<option value="6">{{Jeunesse}}</option>';
        tr += '<option value="7">{{Divertissement}}</option>';
        tr += '<option value="8">{{Société et Culture}}</option>';
        tr += '<option value="9">{{Musique}}</option>';
        tr += '</select>';
        tr += '</td>';
        tr += '<td>';
        if (is_numeric(_cmd.id)) {
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
        }
        tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
        tr += '</td>';
        tr += '</tr>';
        $('#table_liste_chaines tbody').append(tr);
        $('#table_liste_chaines tbody tr:last').setValues(_cmd, '.cmdAttr');
        if (isset(_cmd.type)) {
            $('#table_liste_chaines tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
        }
        jeedom.cmd.changeType($('#table_liste_chaines tbody tr:last'), init(_cmd.subType));
    }
}

function addCmdToTableMosaiques(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }

    if (init(_cmd.type) === 'action') {
        var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
        tr += '<td>';
        tr += '<span class="cmdAttr" data-l1key="id"></span>';
        tr += '<input style="display:none;" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="tab_name" value="tab_chaine">';
        tr += '</td>';
        tr += '<td> ';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom}}">';
        tr += '<span style="display:none;" class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
        tr += '<span style="display:none;" class="subType" subType="' + init(_cmd.subType) + '"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="ch_mosaique">';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="nom">';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="logo">';
        tr += '</td>';
        tr += '<td>';
        if (is_numeric(_cmd.id)) {
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
        }
        tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
        tr += '</td>';
        tr += '</tr>';
        $('#table_liste_mosaiques tbody').append(tr);
        $('#table_liste_mosaiques tbody tr:last').setValues(_cmd, '.cmdAttr');
        if (isset(_cmd.type)) {
            $('#table_liste_mosaiques tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
        }
        jeedom.cmd.changeType($('#table_liste_mosaiques tbody tr:last'), init(_cmd.subType));
    }
}

function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }

    if (_cmd.configuration['tab_name'] === "tab_chaine") {
        addCmdToTableChaines(_cmd);
    }

    if (_cmd.configuration['tab_name'] === "tab_touche") {
        addCmdToTableTouches(_cmd);
    }

    if (_cmd.configuration['tab_name'] === "tab_mosaique") {
        addCmdToTableMosaiques(_cmd);
    }
}