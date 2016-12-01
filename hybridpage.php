<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<style type="text/css">
	.dropabbleContentArea{min-height: 200px;box-sizing:border-box;}
	</style>
	<div class="dropabbleContentArea">

	</div>
	<script>
	jQuery(".dropabbleContentArea").droppable({
      accept: ".pageStructureInner.template div",
      activeClass: "ui-state-highlight",
      drop: function( event, ui ) {
        //deleteImage( ui.draggable );
        //jQuery(this).append(ui.draggable);
      }
    });
	</script>
	<?
}
