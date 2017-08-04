<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

if (init('object_id') == '') {
	$object = object::byId($_SESSION['user']->getOptions('defaultDashboardObject'));
} else {
	$object = object::byId(init('object_id'));
}
if (!is_object($object)) {
	$object = object::rootObject();
}
if (!is_object($object)) {
	throw new Exception('{{Aucun objet racine trouvé. Pour en créer un, allez dans Générale -> Objet.<br/> Si vous ne savez pas quoi faire ou que c\'est la premiere fois que vous utilisez Jeedom n\'hésitez pas a consulter cette <a href="http://jeedom.fr/premier_pas.php" target="_blank">page</a>}}');
}
$child_object = object::buildTree($object);
$parentNumber = array();
?>

<div class="row row-overflow">
    <?php
if ($_SESSION['user']->getOptions('displayObjetByDefault') == 1 && init('report') != 1) {
	echo '<div class="col-lg-2 col-md-3 col-sm-4" id="div_displayObjectList">';
} else {
	echo '<div class="col-lg-2 col-md-3 col-sm-4" style="display:none;" id="div_displayObjectList">';
}
?>

    <div class="bs-sidebar">
        <ul id="ul_object" class="nav nav-list bs-sidenav">
            <li class="nav-header">{{Liste objets}} </li>
            <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
            <?php
$allObject = object::buildTree(null, true);
foreach ($allObject as $object_li) {
	$parentNumber[$object_li->getId()] = $object_li->parentNumber();
	$margin = 15 * $parentNumber[$object_li->getId()];
	if ($object_li->getId() == $object->getId()) {
		echo '<li class="cursor li_object active" ><a href="index.php?v=d&p=panel&m=JeeOrangeTv&object_id=' . $object_li->getId() . '" style="position:relative;left:' . $margin . 'px;">' . $object_li->getHumanName(true) . '</a></li>';
	} else {
		echo '<li class="cursor li_object" ><a href="index.php?v=d&p=panel&m=JeeOrangeTv&object_id=' . $object_li->getId() . '" style="position:relative;left:' . $margin . 'px;">' . $object_li->getHumanName(true) . '</a></li>';
	}
}
?>
        </ul>
    </div>
</div>
<?php
if ($_SESSION['user']->getOptions('displayObjetByDefault') == 1 && init('report') != 1) {
	echo '<div class="col-lg-10 col-md-9 col-sm-8" id="div_displayObject">';
} else {
	echo '<div class="col-lg-12 col-md-12 col-sm-12" id="div_displayObject">';
}
?>
<i class='fa fa-picture-o cursor pull-left reportModeHidden' id='bt_displayObject' data-display='<?php echo $_SESSION['user']->getOptions('displayObjetByDefault') ?>' title="Afficher/Masquer les objets"></i>
<i class="fa fa-pencil pull-right cursor reportModeHidden" id="bt_editDashboardWidgetOrder" data-mode="0" style="margin-right : 10px;"></i>
<br/>
<?php
echo '<div class="div_displayEquipement" style="width: 100%;">';
if (init('object_id') == '') {
	foreach ($allObject as $object) {
		foreach ($object->getEqLogic(true, false, 'JeeOrangeTv') as $JeeOrangeTv) {
			echo $JeeOrangeTv->toHtml('dview');
		}
	}
} else {
	foreach ($object->getEqLogic(true, false, 'JeeOrangeTv') as $JeeOrangeTv) {
		echo $JeeOrangeTv->toHtml('dview');
	}
	foreach ($child_object as $child) {
		$JeeOrangeTvs = $child->getEqLogic(true, false, 'JeeOrangeTv');
		if (count($JeeOrangeTvs) > 0) {
			foreach ($JeeOrangeTvs as $JeeOrangeTv) {
				echo $JeeOrangeTv->toHtml('dview');
			}
		}
	}
}
echo '</div>';
?>
</div>
</div>
<?php include_file('desktop', 'panel', 'js', 'JeeOrangeTv');?>