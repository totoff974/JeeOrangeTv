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
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$id = init('id');
$eqLogic = JeeOrangeTv::byId($id);

$liste_chaine = '';
foreach ($eqLogic->getCmd('action') as $cmd) {
    if ($cmd->getConfiguration('tab_name') === 'tab_chaine') {
        $liste_chaine = $liste_chaine . '<option value="' . $cmd->getId() . '">{{' . $cmd->getName() . '}}</option>';
    }
}
$mosaique_sauv = array();
foreach ($eqLogic->getCmd('action') as $cmd) {
    if ($cmd->getConfiguration('tab_name') === 'tab_mosaique') {
        $mosaique_sauv[$cmd->getName()] = $cmd->getConfiguration('ch_mosaique');
    }
}
?>

<div style="display: none;width : 100%" id="div_modal"></div>
<div>
  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 1</span>
    <select class="cmdAttr form-control input-sm" id="mos1">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 2</span>
    <select class="cmdAttr form-control input-sm" id="mos2">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 3</span>
    <select class="cmdAttr form-control input-sm" id="mos3">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 4</span>
    <select class="cmdAttr form-control input-sm" id="mos4">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 5</span>
    <select class="cmdAttr form-control input-sm" id="mos5">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 6</span>
    <select class="cmdAttr form-control input-sm" id="mos6">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 7</span>
    <select class="cmdAttr form-control input-sm" id="mos7">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 8</span>
    <select class="cmdAttr form-control input-sm" id="mos8">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 9</span>
    <select class="cmdAttr form-control input-sm" id="mos9">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 10</span>
    <select class="cmdAttr form-control input-sm" id="mos10">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 11</span>
    <select class="cmdAttr form-control input-sm" id="mos11">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 12</span>
    <select class="cmdAttr form-control input-sm" id="mos12">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 13</span>
    <select class="cmdAttr form-control input-sm" id="mos13">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 14</span>
    <select class="cmdAttr form-control input-sm" id="mos14">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 15</span>
    <select class="cmdAttr form-control input-sm" id="mos15">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 16</span>
    <select class="cmdAttr form-control input-sm" id="mos16">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 17</span>
    <select class="cmdAttr form-control input-sm" id="mos17">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 18</span>
    <select class="cmdAttr form-control input-sm" id="mos18">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 19</span>
    <select class="cmdAttr form-control input-sm" id="mos19">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 20</span>
    <select class="cmdAttr form-control input-sm" id="mos20">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 21</span>
    <select class="cmdAttr form-control input-sm" id="mos21">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 22</span>
    <select class="cmdAttr form-control input-sm" id="mos22">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 23</span>
    <select class="cmdAttr form-control input-sm" id="mos23">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
    <div class="col-md-4">
    <span class="label label-primary col-md-12" >Mosaïque 24</span>
    <select class="cmdAttr form-control input-sm" id="mos24">
        <option value="null">{{-- vide --}}</option>
        <?php echo $liste_chaine; ?>
    </select>
    </div>
  </div>

<div class="col-md-12">
    <a id="bt_sauvegarder" class="btn btn-success pull-right"><i class="fa fa-check-circle"></i>{{Sauvegarder}}</a>
</div>

<script>
$('#div_modal').ready(function() {
    <?php
    for ($i = 1; $i < 25; $i++)
    {
        echo "$('#mos$i').val(" . $mosaique_sauv['Mosaïque '. $i] . ");";
    }
    ?>
});

$('#bt_sauvegarder').on('click', function () {
    $.showLoading();
    var source = '<?php echo $eqLogic->getId(); ?>';
    var mosaique = {"Mosaïque 1": $('#mos1').val(),
                     "Mosaïque 2": $('#mos2').val(),
                     "Mosaïque 3": $('#mos3').val(),
                     "Mosaïque 4": $('#mos4').val(),
                     "Mosaïque 5": $('#mos5').val(),
                     "Mosaïque 6": $('#mos6').val(),
                     "Mosaïque 7": $('#mos7').val(),
                     "Mosaïque 8": $('#mos8').val(),
                     "Mosaïque 9": $('#mos9').val(),
                     "Mosaïque 10": $('#mos10').val(),
                     "Mosaïque 11": $('#mos11').val(),
                     "Mosaïque 12": $('#mos12').val(),
                     "Mosaïque 13": $('#mos13').val(),
                     "Mosaïque 14": $('#mos14').val(),
                     "Mosaïque 15": $('#mos15').val(),
                     "Mosaïque 16": $('#mos16').val(),
                     "Mosaïque 17": $('#mos17').val(),
                     "Mosaïque 18": $('#mos18').val(),
                     "Mosaïque 19": $('#mos19').val(),
                     "Mosaïque 20": $('#mos20').val(),
                     "Mosaïque 21": $('#mos21').val(),
                     "Mosaïque 22": $('#mos22').val(),
                     "Mosaïque 23": $('#mos23').val(),
                     "Mosaïque 24": $('#mos24').val()
    };
    $.ajax({
        type: "POST",
        url: "plugins/JeeOrangeTv/core/ajax/JeeOrangeTv.ajax.php",
        data: {
            action: "appliqueMosaique",
            id: source,
            mosaique: mosaique,
        },
        dataType: 'json',
        error: function (request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function (data) {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
            }
        $('#div_modal').showAlert({message: 'Table des Mosaïques sauvegardée', level: 'success'});
        }
    });
    window.location.reload();
});
</script>
</div>
<?php include_file('desktop', 'JeeOrangeTv', 'js', 'JeeOrangeTv');?>