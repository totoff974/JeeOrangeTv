<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

global $listCmdJeeOrangeTv;

$plugin = plugin::byId('JeeOrangeTv');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un Décodeur}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity .'"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
            ?>
           </ul>
       </div>
   </div>

   <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
    <legend>{{Mes décodeurs Orange}}</legend>
  <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
  <div class="eqLogicThumbnailContainer">
      <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
        <i class="fa fa-plus-circle" style="font-size : 6em;color:#94ca02;"></i>
        <br>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
    </div>
      <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
      <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
    <br>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
  </div>
  </div>
  <legend><i class="fa fa-table"></i> {{Mes Décodeurs}}</legend>
<div class="eqLogicThumbnailContainer">
    <?php
foreach ($eqLogics as $eqLogic) {
    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
    echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
    echo "<br>";
    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
    echo '</div>';
}
?>
</div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
   <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
   <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>

   <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Décodeur}}</a></li>
    <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Touches}}</a></li>
    <li role="presentation"><a href="#commandListeChaines" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Chaînes}}</a></li>
    <li role="presentation"><a href="#commandMos" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Mosaïque}}</a></li>
</ul>

<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
        <form class="form-horizontal">
            <fieldset>
                <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Nom du Décodeur}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom du module}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" >{{Objet parent}}</label>
                    <div class="col-lg-3">
                        <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                            <option value="">{{Aucun}}</option>
                            <?php
                                foreach (object::all() as $object) {
                                    echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Catégorie}}</label>
                    <div class="col-lg-8">
                        <?php
                            foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                echo '<label class="checkbox-inline">';
                                echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                echo '</label>';
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" ></label>
                    <div class="col-sm-9">
                        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                    </div>
                </div>
                <div class="alert alert-info">
                    {{Obligatoire pour que cela fonctionne.}}
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{{Adresse IP du Décodeur}}</label>
                    <div class="col-sm-2">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="box_ip" placeholder="{{Adresse IP}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{{Localisation géographique}}</label>
                    <div class="col-sm-2">
                        <?php liste_localisation(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{{Choix du thème}}</label>
                    <div class="col-sm-2">
                        <select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="theme">
                            <option value="light">{{light}}</option>
                            <option value="grey">{{grey}}</option>
                            <option value="aucun">{{aucun}}</option>
                        </select>
                    </div>
                </div>
            </fieldset>
        </form>
</div>
<div role="tabpanel" class="tab-pane" id="commandtab">
    <legend>{{Configuration des Touches}}</legend>
            <table id="table_cmd" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>{{Nom}}</th>
                    <!-- <th>{{Sous-Type}}</th> -->
                    <th>{{Valeur}}</th>
                    <th>{{Paramètres}}</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
</div>
<div role="tabpanel" class="tab-pane" id="commandListeChaines">
    <div>
        <a id="bt_autoChaine" class="btn btn-danger btn-sm" style="margin-top:5px;"><i class="fa fa-search"></i>{{Configuration automatique}}</a>
        <a id="bt_addChaine" class="btn btn-default btn-sm pull-right" style="margin-top:5px;"><i class="fas fa-plus-circle"></i>{{Ajouter une Chaine}}</a>
    </div></br>
    <legend>{{Configuration de la liste des Chaines}}</legend>
            <table id="table_liste_chaine" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>{{Nom}}</th>
                    <th>{{n° du Canal}}</th>
                    <th>{{Id EPG}}</th>
                    <th>{{Logo de la Chaîne}}</th>
                    <th>{{Catégorie}}</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
</div>
<div role="tabpanel" class="tab-pane" id="commandMos">
    <legend>{{Configuration de la Mosaïque}}</legend>
            <table id="mosaique" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>{{Position}}</th>
                    <th>{{Nom de la Chaine}}</th>
                    <th>{{Visibilité}}</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
</div>
</div>
</div>

<?php include_file('desktop', 'JeeOrangeTv', 'js', 'JeeOrangeTv');?>
<?php include_file('core', 'plugin.template', 'js');?>

<?php   function liste_localisation() {
        $json_liste = file_get_contents(realpath(dirname(__FILE__) . '/../../core/config/chaines.json'));
        $json_localisation = json_decode($json_liste, true);

        echo '<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="localisation">';

        foreach ($json_localisation['localisation'] as $key => $val) {
            echo '<option value="'.$val['code'].'">{{'.$val['nom'].'}}</option>';
        }

        echo '</select>';
    }
?>
