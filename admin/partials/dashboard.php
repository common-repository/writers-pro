<div class="wrap" style="overflow: hidden">    
	<div class="main_header">
		<img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/contentlocalized_logo.png"/>
		<h1>
			Writing.Pro
			<span>
				by Content Localized
			</span>
		</h1>
	</div>
    <h2>Dashboard</h2>

	<?php
		$exampleListTable = new CLWP_WritersPro_Article_List();
		$exampleListTable->prepare_items();


	?>
</div>

<div class="wrap">
    <form method="get">
        <input type="hidden" name="page" value="clwp" />
	    <?php $exampleListTable->search_box("Search", "project_name"); ?>
    </form>
        <br />
        <br />
	<?php $exampleListTable->display(); ?>
	<?php require_once plugin_dir_path(dirname( __FILE__ ))."partials/balance.php"; ?>
</div>

