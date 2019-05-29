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

?>

<div style="display: none;width : 100%" id="div_modal"></div>
<?php
// READ FILES FROM GALLERY FOLDER
$dir = dirname(__FILE__) . '/../../core/template/dashboard/images/Mosaique/';
$images = glob($dir . "*.{png}", GLOB_BRACE);
// DRAW HTML ?>
    <link href="2-box.css" rel="stylesheet">
    <script src="2-box.js"></script>

    <!-- [LIGHTBOX] -->
    <div id="lfront"></div>
    <div id="lback"></div>

    <!-- [THE GALLERY] -->
    <div id="gallery"><?php
    foreach ($images as $i) {
      printf("<img name='". basename($i) . "' src='/plugins/JeeOrangeTv/core/template/dashboard/images/Mosaique/%s' onclick='gallery.show(this)'/>", basename($i));
    }
    ?>
    </div>

<script>
var gallery = {
  show : function(img){
  // show() : show selected image in light box

    var clone = img.cloneNode();
    var logo = img.name;
    clone.onclick = gallery.hide;
    var front = document.getElementById("lfront");
    front.innerHTML = "";
    front.appendChild(clone);
    front.append(logo);
    front.classList.add("show");
    document.getElementById("lback").classList.add("show");
  },

  hide : function(){
  // hide() : hide the lightbox

    document.getElementById("lfront").classList.remove("show");
    document.getElementById("lback").classList.remove("show");
  }
};
</script>