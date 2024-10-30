<?php

    Class CDES_Tracking_Metabox {

        public function tracking_metabox() {
            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                if ( version_compare( WC_VERSION, '5.5', '>' ) ) {
                    $post_type = 'woocommerce_page_wc-orders';
                } else {
                    $post_type = 'shop_order';
                }
            } else {
                $post_type = 'woocommerce_page_wc-orders';
            }

            add_meta_box(
                'SDES_tracking_metabox_id', 
                __('Tracking info', 'codigo-envio-woocommerce'), 
                array($this, 'html_tracking_metabox'),
                $post_type, 
                'side', 
                'high'
            );
        }

        public function html_tracking_metabox() {
            $couriers = new CDES_Couriers();
            $couriers_list = $couriers->get_couriers();
            $selected_courier = esc_html(get_post_meta(get_the_id(), '_order_tracking_courier', true));
            $tracking_code_sended = esc_html(get_post_meta(get_the_id(), '_order_tracking_code_sended', true));
            wp_nonce_field("meta-box-tracking-nonce_action", "meta-box-tracking-nonce");
            ?>
            <p>
                <?php 
                     esc_attr_e('Tracking code sended?', 'codigo-envio-woocommerce'); 
                    echo ($tracking_code_sended) ? '<span class="dashicons dashicons-yes" style="color: #00A153;right: 7px;position: absolute;"></span>' : '<span class="dashicons dashicons-no-alt" style="color: #a00;right: 7px;position: absolute;"></span>'; ?>
            </p>
            <p>
				<label for="add_order_tracking_code"><?php  esc_attr_e('Tracking code:', 'codigo-envio-woocommerce'); ?><?php echo wc_help_tip( __( 'Insert the tracking code that your courier sended to you for tracking the order','codigo-envio-woocommerce' )); ?></label>
				<input type="text" name="_order_tracking_code" id="_order_tracking_code" class="input-text" value="<?php echo esc_html(get_post_meta(get_the_id(), '_order_tracking_code', true)) ?>" style="width: 100%">
			</p>
            <label for="add_order_tracking_code"><?php  esc_attr_e('Select the courier', 'codigo-envio-woocommerce'); ?><?php echo wc_help_tip( __( 'Select your logistic partner','codigo-envio-woocommerce' )); ?></label>
            <select name="_order_tracking_courier" style="width: 100%">
					<option value=""><?php  esc_attr_e('Choose your courier partner', 'codigo-envio-woocommerce'); ?></option>
                    <?php
                        foreach ($couriers_list as $courier => $value) {
                            $is_selected = ($selected_courier == $courier) ? 'selected' : '';
                            echo "<option value='" . esc_html($courier) . "' " . esc_html($is_selected) . ">".esc_html($value)."</option>";
                        }
                    ?>
			</select>
            <p style="text-align: center; font-size: 12px; font-weight: bold"><?php  esc_attr_e('To send the tracking code you need to enter the tracking code and select the courier. Then, in order actions (above the update button), select "send tracking code to costumer". Then click on the ">".','codigo-envio-woocommerce' ); ?></p>
            <?php
        }
        
        public function adicionar_acao_encomenda( $actions ) {
            $actions['send_tracking_code'] = __( 'Send tracking code to customer', 'codigo-envio-woocommerce');
            return $actions;
        }
        
    }