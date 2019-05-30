<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJs('tabimg',init('tabimg'));
sendVarToJs('selectLogo', init('selectLogo', 0));
?>
<div style="display: none;" id="div_logoSelectorAlert"></div>
<style>
	.divLogoSel{
		height: 80px;
		border: 1px solid #fff;
		box-sizing: border-box;
		cursor: pointer;
		text-align: center;
	}

	.logoSel{
		line-height: 1.4;
		font-size: 1.5em;
	}

	.logoSelected{
		background-color: #563d7c;
		color: white;
	}

	.logoDesc{
		font-size: 0.8em;
	}

	.imgContainer img{
		max-width: 120px;
		max-height: 70px;
		padding: 10px;
	}
</style>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#logo" aria-controls="home" role="tab" data-toggle="tab">{{Icône}}</a></li>
	<?php if(init('imgtab') == 1 || init('showimg') == 1){ ?>
		<li role="presentation" ><a href="#img" aria-controls="home" role="tab" data-toggle="tab">{{Image}}</a></li>
	<?php } ?>
</ul>

<div class="tab-content" style="height:calc(100% - 20px);overflow-y:scroll;">
	<div id="mySearch" class="input-group" style="margin-left:6px;margin-top:6px">
		<div class="input-group-btn">
			<select class="form-control roundedLeft" style="width : 200px;" id="sel_colorLogo">
				<option value="">{{default}}</option>
				<option value="logo_green">{{Vert}}</option>
				<option value="logo_blue">{{Bleu}}</option>
				<option value="logo_orange">{{Orange}}</option>
				<option value="logo_red">{{Rouge}}</option>
				<option value="logo_yellow">{{Jaune}}</option>
			</select>
		</div>
		<input class="form-control" placeholder="{{Rechercher}}" id="in_logoSelectorSearch">
		<div class="input-group-btn">
			<a id="bt_resetSearch" class="btn roundedRight" style="width:30px"><i class="fas fa-times"></i> </a>
		</div>
	</div>

	<div role="tabpanel" class="tab-pane active" id="logo">
		<?php
		$scanPaths = array('core/css/logo', 'data/fonts');
		foreach ($scanPaths as $root) {
			foreach (ls($root, '*') as $dir) {
				$root .= '/';
				if (!is_dir($root . $dir) || !file_exists($root . $dir . '/style.css')) {
					continue;
				}
				$fontfile = $root . $dir . 'fonts/' . substr($dir, 0, -1) . '.ttf';
				if (!file_exists($fontfile)) continue;

				$css = file_get_contents($root . $dir . '/style.css');
				$research = strtolower(str_replace('/', '', $dir));
				preg_match_all("/\." . $research . "-(.*?):/", $css, $matches, PREG_SET_ORDER);
				echo '<div class="logoCategory"><legend>{{' . str_replace('/', '', $dir) . '}}</legend>';

				$number = 1;
				foreach ($matches as $match) {
					if (isset($match[0])) {
						if ($number == 1) {
							echo '<div class="row">';
						}
						echo '<div class="col-lg-1 divLogoSel">';
						$logo = str_replace(array(':', '.'), '', $match[0]);
						echo '<span class="logoSel"><i class=\'logo ' . $logo . '\'></i></span><br/><span class="logoDesc">' . $logo . '</span>';
						echo '</div>';
						if ($number == 12) {
							echo '</div>';
							$number = 0;
						}
						$number++;
					}
				}
				if($number != 0){
					echo '</div>';
				}
				echo '</div>';
			}
		}
		?>
		<div class="logoCategory">
			<legend>{{Général}}</legend>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-glasses'></i></span><br/><span class="logoDesc">fa-glasses</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-music'></i></span><br/><span class="logoDesc">fa-music</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-search'></i></span><br/><span class="logoDesc">fa-search</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-envelope'></i></span><br/><span class="logoDesc">fa-envelope-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-heart'></i></span><br/><span class="logoDesc">fa-heart</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-star'></i></span><br/><span class="logoDesc">fa-star</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-user'></i></span><br/><span class="logoDesc">fa-user</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-film'></i></span><br/><span class="logoDesc">fa-film</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-th-large'></i></span><br/><span class="logoDesc">fa-th-large</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-check'></i></span><br/><span class="logoDesc">fa-check</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-times'></i></span><br/><span class="logoDesc">fa-times</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-power-off'></i></span><br/><span class="logoDesc">fa-power-off</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-list-alt'></i></span><br/><span class="logoDesc">fa-list-alt</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-signal'></i></span><br/><span class="logoDesc">fa-signal</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-cog'></i></span><br/><span class="logoDesc">fa-cog</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-trash-alt'></i></span><br/><span class="logoDesc">fa-trash-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-home'></i></span><br/><span class="logoDesc">fa-home</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-file'></i></span><br/><span class="logoDesc">fa-file</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-clock'></i></span><br/><span class="logoDesc">fa-clock</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-road'></i></span><br/><span class="logoDesc">fa-road</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-download'></i></span><br/><span class="logoDesc">fa-download</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-inbox'></i></span><br/><span class="logoDesc">fa-inbox</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-play-circle'></i></span><br/><span class="logoDesc">fa-play-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-sync'></i></span><br/><span class="logoDesc">fa-sync</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-lock'></i></span><br/><span class="logoDesc">fa-lock</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-flag'></i></span><br/><span class="logoDesc">fa-flag</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-headphones'></i></span><br/><span class="logoDesc">fa-headphones</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-volume-up'></i></span><br/><span class="logoDesc">fa-volume-up</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-volume-down'></i></span><br/><span class="logoDesc">fa-volume-down</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-volume-off'></i></span><br/><span class="logoDesc">fa-volume-off</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-qrcode'></i></span><br/><span class="logoDesc">fa-qrcode</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-barcode'></i></span><br/><span class="logoDesc">fa-barcode</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-tag'></i></span><br/><span class="logoDesc">fa-tag</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-book'></i></span><br/><span class="logoDesc">fa-book</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-print'></i></span><br/><span class="logoDesc">fa-print</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-camera'></i></span><br/><span class="logoDesc">fa-camera</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-image'></i></span><br/><span class="logoDesc">fa-image</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-pencil-alt'></i></span><br/><span class="logoDesc">fa-pencil</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-map-marker'></i></span><br/><span class="logoDesc">fa-map-marker</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-tint'></i></span><br/><span class="logoDesc">fa-tint</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-check-square'></i></span><br/><span class="logoDesc">fa-check-square-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-arrows-alt'></i></span><br/><span class="logoDesc">fa-arrows</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-step-backward'></i></span><br/><span class="logoDesc">fa-step-backward</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-fast-backward'></i></span><br/><span class="logoDesc">fa-fast-backward</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-backward'></i></span><br/><span class="logoDesc">fa-backward</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-play'></i></span><br/><span class="logoDesc">fa-play</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-pause'></i></span><br/><span class="logoDesc">fa-pause</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-video'></i></span><br/><span class="logoDesc">fa-video</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-stop'></i></span><br/><span class="logoDesc">fa-stop</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-forward'></i></span><br/><span class="logoDesc">fa-forward</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-fast-forward'></i></span><br/><span class="logoDesc">fa-fast-forward</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-step-forward'></i></span><br/><span class="logoDesc">fa-step-forward</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-eject'></i></span><br/><span class="logoDesc">fa-eject</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-chevron-left'></i></span><br/><span class="logoDesc">fa-chevron-left</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-chevron-right'></i></span><br/><span class="logoDesc">fa-chevron-right</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-plus-circle'></i></span><br/><span class="logoDesc">fa-plus-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-minus-circle'></i></span><br/><span class="logoDesc">fa-minus-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-times-circle'></i></span><br/><span class="logoDesc">fa-times-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-check-circle'></i></span><br/><span class="logoDesc">fa-check-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-question-circle'></i></span><br/><span class="logoDesc">fa-question-circle</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-info-circle'></i></span><br/><span class="logoDesc">fa-info-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-crosshairs'></i></span><br/><span class="logoDesc">fa-crosshairs</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-times-circle'></i></span><br/><span class="logoDesc">fa-times-circle-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-ban'></i></span><br/><span class="logoDesc">fa-ban</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-arrow-left'></i></span><br/><span class="logoDesc">fa-arrow-left</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-arrow-right'></i></span><br/><span class="logoDesc">fa-arrow-right</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-arrow-up'></i></span><br/><span class="logoDesc">fa-arrow-up</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-arrow-down'></i></span><br/><span class="logoDesc">fa-arrow-down</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-plus'></i></span><br/><span class="logoDesc">fa-plus</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-minus'></i></span><br/><span class="logoDesc">fa-minus</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-asterisk'></i></span><br/><span class="logoDesc">fa-asterisk</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-wheelchair'></i></span><br/><span class="logoDesc">fa-wheelchair</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-exclamation-circle'></i></span><br/><span class="logoDesc">fa-exclamation-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-gift'></i></span><br/><span class="logoDesc">fa-gift</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-leaf'></i></span><br/><span class="logoDesc">fa-leaf</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-fire'></i></span><br/><span class="logoDesc">fa-fire</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-eye'></i></span><br/><span class="logoDesc">fa-eye</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-eye-slash'></i></span><br/><span class="logoDesc">fa-slash</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-exclamation-triangle'></i></span><br/><span class="logoDesc">fa-exclamation-triangle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-plane'></i></span><br/><span class="logoDesc">fa-plane</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-calendar'></i></span><br/><span class="logoDesc">fa-calendar</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-random'></i></span><br/><span class="logoDesc">fa-random</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-comment'></i></span><br/><span class="logoDesc">fa-comment</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-magnet'></i></span><br/><span class="logoDesc">fa-magnet</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-chevron-up'></i></span><br/><span class="logoDesc">fa-chevron-up</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-chevron-down'></i></span><br/><span class="logoDesc">fa-chevron-down</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-shopping-cart'></i></span><br/><span class="logoDesc">fa-shopping-cart</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-folder'></i></span><br/><span class="logoDesc">fa-folder</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-folder-open'></i></span><br/><span class="logoDesc">fa-folder-open</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-chart-bar'></i></span><br/><span class="logoDesc">fa-chart-bar</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-key'></i></span><br/><span class="logoDesc">fa-key</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-heart'></i></span><br/><span class="logoDesc">fa-heart-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-sign-out-alt'></i></span><br/><span class="logoDesc">fa-sign-out</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-thumbtack'></i></span><br/><span class="logoDesc">fa-thumbtack</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-sign-in-alt'></i></span><br/><span class="logoDesc">fa-sign-in</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-phone'></i></span><br/><span class="logoDesc">fa-phone</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-unlock'></i></span><br/><span class="logoDesc">fa-unlock</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-credit-card'></i></span><br/><span class="logoDesc">fa-credit-card</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-rss'></i></span><br/><span class="logoDesc">fa-rss</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-hdd'></i></span><br/><span class="logoDesc">fa-hdd</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-bullhorn'></i></span><br/><span class="logoDesc">fa-bullhorn</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-bell'></i></span><br/><span class="logoDesc">fa-bell</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-globe'></i></span><br/><span class="logoDesc">fa-globe</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-wrench'></i></span><br/><span class="logoDesc">fa-wrench</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-filter'></i></span><br/><span class="logoDesc">fa-filter</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-briefcase'></i></span><br/><span class="logoDesc">fa-briefcase</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-cloud'></i></span><br/><span class="logoDesc">fa-cloud</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-flask'></i></span><br/><span class="logoDesc">fa-flask</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-cut'></i></span><br/><span class="logoDesc">fa-cut</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-paperclip'></i></span><br/><span class="logoDesc">fa-paperclip</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-save'></i></span><br/><span class="logoDesc">fa-save</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-table'></i></span><br/><span class="logoDesc">fa-table</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-magic'></i></span><br/><span class="logoDesc">fa-magic</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-truck'></i></span><br/><span class="logoDesc">fa-truck</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-money-bill-alt'></i></span><br/><span class="logoDesc">fa-money</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-columns'></i></span><br/><span class="logoDesc">fa-columns</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-envelope'></i></span><br/><span class="logoDesc">fa-envelope</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-gavel'></i></span><br/><span class="logoDesc">fa-gavel</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-tachometer-alt'></i></span><br/><span class="logoDesc">fa-tachometer-alt</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-bolt'></i></span><br/><span class="logoDesc">fa-bolt</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-sitemap'></i></span><br/><span class="logoDesc">fa-sitemap</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-umbrella'></i></span><br/><span class="logoDesc">fa-umbrella</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-lightbulb'></i></span><br/><span class="logoDesc">fa-lightbulb</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-stethoscope'></i></span><br/><span class="logoDesc">fa-stethoscope</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-suitcase'></i></span><br/><span class="logoDesc">fa-suitcase</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-coffee'></i></span><br/><span class="logoDesc">fa-coffee</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-utensils'></i></span><br/><span class="logoDesc">fa-cutlery</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-building'></i></span><br/><span class="logoDesc">fa-building-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-medkit'></i></span><br/><span class="logoDesc">fa-medkit</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-beer'></i></span><br/><span class="logoDesc">fa-beer</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-h-square'></i></span><br/><span class="logoDesc">fa-square</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-desktop'></i></span><br/><span class="logoDesc">fa-desktop</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-laptop'></i></span><br/><span class="logoDesc">fa-laptop</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-tablet'></i></span><br/><span class="logoDesc">fa-tablet</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-mobile'></i></span><br/><span class="logoDesc">fa-mobile</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-circle'></i></span><br/><span class="logoDesc">fa-circle-o</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-spinner'></i></span><br/><span class="logoDesc">fa-spinner</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-circle'></i></span><br/><span class="logoDesc">fa-circle</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-smile'></i></span><br/><span class="logoDesc">fa-smile</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-frown'></i></span><br/><span class="logoDesc">fa-frown</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-meh'></i></span><br/><span class="logoDesc">fa-meh</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-gamepad'></i></span><br/><span class="logoDesc">fa-gamepad</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-keyboard'></i></span><br/><span class="logoDesc">fa-keyboard</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-terminal'></i></span><br/><span class="logoDesc">fa-terminal</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-location-arrow'></i></span><br/><span class="logoDesc">fa-location-arrow</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-microphone'></i></span><br/><span class="logoDesc">fa-microphone</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-microphone-slash'></i></span><br/><span class="logoDesc">fa-microphone-slash</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-shield-alt'></i></span><br/><span class="logoDesc">fa-shield</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-calendar'></i></span><br/><span class="logoDesc">fa-calendar</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-fire-extinguisher'></i></span><br/><span class="logoDesc">fa-fire-extinguisher</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-rocket'></i></span><br/><span class="logoDesc">fa-rocket</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-anchor'></i></span><br/><span class="logoDesc">fa-anchor</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-unlock-alt'></i></span><br/><span class="logoDesc">fa-unlock-alt</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-compass'></i></span><br/><span class="logoDesc">fa-compass</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-apple'></i></span><br/><span class="logoDesc">fa-apple</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-windows'></i></span><br/><span class="logoDesc">fa-windows</span></div>
			</div>
			<div class="row">
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-android'></i></span><br/><span class="logoDesc">fa-android</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-linux'></i></span><br/><span class="logoDesc">fa-linux</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-dribbble'></i></span><br/><span class="logoDesc">fa-dribbble</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-trello'></i></span><br/><span class="logoDesc">fa-trello</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-female'></i></span><br/><span class="logoDesc">fa-female</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-male'></i></span><br/><span class="logoDesc">fa-male</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fab fa-gratipay'></i></span><br/><span class="logoDesc">fa-gratipay</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='far fa-sun'></i></span><br/><span class="logoDesc">fa-sun</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-moon'></i></span><br/><span class="logoDesc">fa-moon</span></div>
				<div class="col-lg-1 divLogoSel"><span class="logoSel"><i class='fas fa-archive'></i></span><br/><span class="logoDesc">fa-archive</span></div>
			</div>
		</div>
	</div>
	<?php if(init('imgtab') == 1 || init('showimg') == 1){ ?>
		<div role="tabpanel" class="tab-pane" id="img">
			<span class="btn btn-default btn-file pull-right">
				<i class="fas fa-cloud-upload-alt"></i> {{Envoyer}}<input  id="bt_uploadImageLogo" type="file" name="file" style="display: inline-block;">
			</span>
			<div class="imgContainer">
				<div class="row">
					<?php
					foreach (ls(__DIR__.'/../../data/img/','*') as $file) {
						echo '<div class="col-lg-1">';
						echo '<div class="divLogoSel">';
						echo '<span class="logoSel"><img src="data/img/'.$file.'" /></span>';
						echo '</div>';
						echo '<center>'.substr(basename($file),0,12).'</center>';
						echo '<center><a class="btn btn-danger btn-xs bt_removeImgLogo" data-filename="'.$file.'"><i class="fas fa-trash"></i> {{Supprimer}}</a></center>';
						echo '</div>';
					}
					?>
				</div>
			</div>
			<script>
			$('#bt_uploadImageLogo').fileupload({
				replaceFileInput: false,
				url: 'core/ajax/jeedom.ajax.php?action=uploadImageLogo&jeedom_token='+JEEDOM_AJAX_TOKEN,
				dataType: 'json',
				done: function (e, data) {
					if (data.result.state != 'ok') {
						$('#div_logoSelectorAlert').showAlert({message: data.result.result, level: 'danger'});
						return;
					}
					$('#mod_selectLogo').empty().load('index.php?v=d&modal=logo.selector&tabimg=1&showimg=1');
				}
			});

			$('.bt_removeImgLogo').on('click',function(){
				var filename = $(this).attr('data-filename');
				bootbox.confirm('{{Êtes-vous sûr de vouloir supprimer cette image}} <span style="font-weight: bold ;">' + filename + '</span> ?', function (result) {
					if (result) {
						jeedom.removeImageLogo({
							filename : filename,
							error: function (error) {
								$('#div_logoSelectorAlert').showAlert({message: error.message, level: 'danger'});
							},
							success: function (data) {
								$('#mod_selectLogo').empty().load('index.php?v=d&modal=_logoor&tabimg=1&showimg=1');
							}
						})
					}
				});
			});
			</script>
		</div>
	<?php } ?>
</div>

<script>
	$('#sel_colorLogo').off('change').on('change',function() {
		$('.logoSel i').removeClass('logo_green logo_blue logo_orange logo_red logo_yellow').addClass($(this).value());
	});

	$('#in_logoSelectorSearch').on('keyup',function(){
		$('.divLogoSel').show();
		$('.logoCategory').show();
		var search = $(this).value();
		if(search != ''){
			$('.logoDesc').each(function(){
				if($(this).text().indexOf(search) == -1){
					$(this).closest('.divLogoSel').hide();
				}
			})
		}
		$('.logoCategory').each(function(){
			var hide = true;
			if($(this).find('.divLogoSel:visible').length == 0){
				$(this).hide();
			}
		});
	});
	$('#bt_resetSearch').on('click', function () {
		$('#in_logoSelectorSearch').val('')
		$('#in_logoSelectorSearch').keyup();
	})

	$('.divLogoSel').on('click', function () {
		$('.divLogoSel').removeClass('logoSelected');
		$(this).closest('.divLogoSel').addClass('logoSelected');
	});
	$('.divLogoSel').on('dblclick', function () {
		$('.divLogoSel').removeClass('logoSelected');
		$(this).closest('.divLogoSel').addClass('logoSelected');
		$('#mod_selectLogo').dialog("option", "buttons")['Valider'].apply($('#mod_selectLogo'));
	});

	if(tabimg && tabimg == 1) {
		$('#mod_selectLogo ul li a[href="#img"]').click();
		$('#mySearch').hide()
	}
	$('#mod_selectLogo ul li a[href="#img"]').click(function(e) {
		$('#mySearch').hide()
	})
	$('#mod_selectLogo ul li a[href="#logo"]').click(function(e) {
		$('#mySearch').show()
	})

	$('#mod_selectLogo').css('overflow', 'hidden')
	$(function() {
		//move select/search in modal bottom:
	    var buttonSet = $('.ui-dialog[aria-describedby="mod_selectLogo"]').find('.ui-dialog-buttonpane')
	    buttonSet.find('#mySearch').remove()
	    var mySearch = $('.ui-dialog[aria-describedby="mod_selectLogo"]').find('#mySearch')
		buttonSet.append(mySearch)

		//auto select actual logo:
		if (selectLogo != "0") {
			$(selectLogo).closest('.divLogoSel').addClass('logoSelected')

			setTimeout(function() {
				elem = $('div.divLogoSel.logoSelected')
				container = $('#mod_selectLogo > .tab-content')
				pos = elem.position().top + container.scrollTop() - container.position().top
				container.animate({scrollTop: pos})
			}, 250);
		}
	})

</script>