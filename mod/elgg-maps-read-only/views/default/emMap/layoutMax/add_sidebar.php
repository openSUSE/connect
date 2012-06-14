<style type="text/css">
.layer {
margin:5px;padding:5px;
position:relative;
background-color:#FAFAFA;
-moz-border-radius:10px;
border:1px solid #CCC;
}
.layer h2 {
font-size:14px;
margin-bottom:5px;
}
.layer label{font-size:12px;margin-left:5px;}
.layer textarea {}
</style>
<div id="add_sidebarcontainer" style="display:none">
<div class="layer" rel="1">
<h2>Layer</h2>
<label for="title">Title</label>
<br />
<input type="text" id="title" value="Predeterminada" />
<br />
<label for="description">Description</label>
<br />
<textarea id="description">...</textarea>
<button id="layerEditToggle" rel="1" style="position:absolute;top:5px;right:40px">edit</button>
<button id="layerMinToggle" rel="1" style="position:absolute;top:5px;right:5px">-</button>
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	$('#layerEditToggle').button({text:false,icons:{primary:'ui-icon-pencil'}});
	$('#layerMinToggle').button({text:false,icons:{primary:'ui-icon-minus'}});
	$('#add_sidebarcontainer').show();
});
</script>