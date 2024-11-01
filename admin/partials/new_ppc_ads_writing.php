<script>
    var plugin_dir_url = '<?php echo plugin_dir_url( __DIR__ ); ?>'
</script>
<div class="wrap">
    <h1 class="wp-heading-inline">New PPC Ads Order</h1>

    <div class="clwp_loading">
        <div class="overlay"></div>
        <div class="loading">
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
        </div>
    </div>

    <form name="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="post">
        <input type="hidden" name="action" value="clwp_create_ppc_ads_order">

        <div id="postdiv">

            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content" style="position: relative;">

                    <div id="titlediv">
                        <div id="titlewrap">
                            <label class="">Project name<span class="clwp_required">*</span> </label>
                            <input type="text" class="clwp_ppc_price_update" name="project_name" size="30" value="" id="title" spellcheck="true">
                        </div>
                        <br/>
                        <div id="titlewrap">
                            <label class="" style="float: left">Instructions to writer</label>

                        </div>


                        <textarea rows="5" cols="40" name="excerpt" style="width: 100%;"></textarea>
                        <br>
                        <br>
                        <div id="titlewrap">
                            <label class="">Domain<span class="clwp_required">*</span></label>
                            <input type="text" name="domain" value=""  class="clwp_ppc_price_update input_field" id="domain" spellcheck="true">
                        </div>
                        <br>
                        <label for="">Domain language<span class="clwp_required">*</span></label>
                        <select name="lng_code" id="source" data-placeholder="Select language" class="js-example-basic-single clwp_ppc_source_lng">
							<?php
								if ( $source_lng ) {
									foreach ( $source_lng as $l ) {
										if ( $l['iso_code'] == 'us' ) {
											echo '<option value="' . $l["iso_code"] . '" data-id="'.$l["id"].'" data-iso="'.$l["iso_code"].'" selected>' . $l["name"] . '</option>';
										} else {
											echo '<option data-id="'.$l["id"].'" data-iso="'.$l["iso_code"].'" value="' . $l["iso_code"] . '">' . $l["name"] . '</option>';
										}
									}
								}
							?>
                        </select>
                        <br>
                        <br>
                        <div id="titlewrap">
                            <label class="">Keywords(Comma-separated list)</label>
                            <input type="text" name="keywords" value="" id="keywords" class="input_field" spellcheck="true">
                        </div>
                        <br>
                        <div id="s">
                            <label class="">Title (30 - 50 Characters) </label>
                            <input type="checkbox" class="clwp_ppc_price_update" id="title_needed" name="title_needed" checked value="1">
                        </div>
                        <br>
                        <div id="s">
                            <label class="">Description (150 - 165 Characters)</label>
                            <input type="checkbox" class="clwp_ppc_price_update" id="description_needed" name="description_needed" checked value="1">
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>

<!-- <div id="postdiv" style="float:right;width:20%">
	<div id="submitdiv" class="postbox" style="padding: 10px; margin-top: 30px">
		<h2 style="margin-top: 0px;"><span>Publish</span></h2>
	</div>

</div>-->
<div id="overview">
    <div id="delivery_time">
        <h3>Order overview</h3>
        <hr/>
        <br/>
        <label for="">Deliver within</label>
        <select name="delivery" id="delivery" class="clwp_ppc_price_update">
			<?php
				if ( $devilery ) {
					foreach ( $devilery as $d ) {
						echo '<option value="' . $d["id"] . '">' . $d["option"] . '</option>';
					}
				}

			?>
        </select>
    </div>
    <div id="major-publishing-actions">
        <div id="clwp_lng_breakdown">

            <div id="clwp_lng_breakdown_wrapper_result">

            </div>
        </div>
        <br>
        <hr>
        <div id="delete-action">
            <b>Total Cost: <span>$</span><span id="clwp_total">0</span></b>
        </div>

        <div id="publishing-action">
            <span class="spinner"></span>
            <input name="original_publish" type="hidden" id="original_publish" value="Publish">
            <input type="submit" name="publish" id="clwp_place_order" class="button button-primary button-large" disabled="" value="Place Order"></div>
        <div class="clear"></div>
    </div>
</div>
</form>
<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . "partials/balance.php"; ?>

</div>

