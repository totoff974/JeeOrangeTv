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

		<li role="presentation" ><a href="#img" aria-controls="home" role="tab" data-toggle="tab">{{Image}}</a></li>

</ul>

<div class="tab-content" style="height:calc(100% - 20px);overflow-y:scroll;">
	<div id="mySearch" class="input-group" style="margin-left:6px;margin-top:6px">
		<input class="form-control" placeholder="{{Rechercher}}" id="in_logoSelectorSearch">
		<div class="input-group-btn">
			<a id="bt_resetSearch" class="btn roundedRight" style="width:30px"><i class="fas fa-times"></i> </a>
		</div>
	</div>

	<div role="tabpanel" class="tab-pane active" id="logo">
		<?php
        $dir = 'plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/';
        $images = glob($dir . "*.{png}", GLOB_BRACE);
		?>
		<div class="logoCategory">
			<legend>{{Général}}</legend>
			<div class="row">
                <?php foreach ($images as $i) { ?>
                <div class="col-lg-1 divLogoSel"><span class="logoSel"><img name='<?php echo basename($i, '.png');?>' src='/plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/<?php echo basename($i);?>'/></span><br/><span class="logoDesc"><?php echo basename($i);?></span></div>
                <?php
                }
                ?>
			</div>
		</div>
	</div>
		<div role="tabpanel" class="tab-pane" id="img">
			<span class="btn btn-default btn-file pull-right">
				<i class="fas fa-cloud-upload-alt"></i> {{Envoyer}}<input  id="bt_uploadImageLogo" type="file" name="file" style="display: inline-block;">
			</span>
			<div class="imgContainer">
				<div class="row">
					<?php
					foreach (ls('plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/','*') as $file) {
						echo '<div class="col-lg-1">';
						echo '<div class="divLogoSel">';
						echo '<span class="logoSel"><img src="plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/'.$file.'" /></span>';
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
					$('#mod_selectLogo').empty().load('index.php?v=d&modal=logo.JeeOrangeTv&tabimg=1&showimg=1');
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
</div>

<script>
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
