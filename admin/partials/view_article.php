<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $order['name']; ?></h1>
    <?php
        if($order['jobs'] && $order["status"] == "Completed") {

            if($order["product"]["id"] == 8){
	            foreach($order['jobs'] as $j) {
		            ?>
                    <div class="order_box">
                        <div class="order_description">
                            <div class="order_language">
                                <p>
                                <span class="flag">
                                    <img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/flags_iso/16/<?php echo $j['sourceable']['languages']['language']['iso_code']; ?>.png">
                                </span>
						            <?php echo $j['sourceable']['languages']['language']['name']; ?>
                                </p>
                                <a class="order_status completed"><?php echo $j["status_tag"]; ?></a>
                            </div>
                            <div class="order_price">
                                <p>
                                    Price: $<?php echo number_format ($j['price'], 2, '.', ''); ?>
                                </p>
                            </div>

                            <div class="order_completed">
                                <div class="order_main_content" id="<?php echo $j['id']; ?>">
                                    <div class="box">
                                        <h5>
								            <?php echo $j['sourceable']['generated_title']; ?>
                                        </h5>
							            <?php echo $j['sourceable']['generated_text']; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


		            <?php
	            }
            }

	        if($order["product"]["id"] == 3){
		        foreach($order['jobs'] as $j) {
			        ?>
                    <div class="order_box">
                        <div class="order_description">
                            <div class="order_language">
                                <p>
                                <span class="flag">
                                    <img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/flags_iso/16/<?php echo $j['sourceable']['languages']['language']['iso_code']; ?>.png">
                                </span>
							        <?php echo $j['sourceable']['languages']['language']['name']; ?>
                                </p>
                                <a class="order_status completed"><?php echo $j["status_tag"]; ?></a>
                            </div>
                            <div class="order_price">
                                <p>
                                    Price: $<?php echo number_format ($j['price'], 2, '.', ''); ?>
                                </p>
                            </div>

                            <div class="order_completed">
                                <div class="order_main_content" id="<?php echo $j['id']; ?>">
                                    <?php

                                        if($j['sourceable']['title_needed']) {
	                                        ?>
                                            <div class="box">
                                                <h5>
                                                    Title
                                                </h5>
		                                        <?php echo $j['sourceable']['generated_title'][0]; ?>
                                            </div>
	                                        <?php
                                        }
                                            ?>
	                                <?php

		                                if($j['sourceable']['description_needed']) {
			                                ?>
                                            <div class="box">
                                                <h5>
                                                    Description
                                                </h5>
				                                <?php echo $j['sourceable']['generated_description'][0]; ?>
                                            </div>
			                                <?php
		                                }
	                                ?>
                                </div>
                            </div>
                        </div>
                    </div>


			        <?php
		        }
	        }



        }else {
            echo '<h1>Order still in progress</h1>';
        }
    ?>
    <!-- Items -->
	<p class="total">TOTAL PRICE $<?php echo number_format ($order['price'], 2, '.', ''); ?></p>
    <!-- End items -->
</div>

