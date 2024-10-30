<?php

    Class CDES_Tracking_Email {

        public function __constructor() {}

        public function send_tracking_email($order) {
            if (!isset($_POST["meta-box-tracking-nonce"]) || !wp_verify_nonce( sanitize_text_field( wp_unslash($_POST["meta-box-tracking-nonce"])), 'meta-box-tracking-nonce_action'))
                return $post_id;

            if (isset($_POST['_order_tracking_code'])) {
                update_post_meta($order->get_id(), '_order_tracking_code', esc_html( sanitize_text_field( $_POST['_order_tracking_code'])));
            }
            if (isset($_POST['_order_tracking_courier'])) {
                update_post_meta($order->get_id(), '_order_tracking_courier', esc_html( sanitize_text_field($_POST['_order_tracking_courier'])));
            }

            $tracking_code = get_post_meta($order->get_id(), '_order_tracking_code', true);
            $courier = get_post_meta($order->get_id(), '_order_tracking_courier', true);

            if (!$tracking_code or !$courier) return;
            
            $mailer = WC()->mailer();
            $recipient = $order->get_billing_email();

            
            $subject = sprintf(
                /* translators: %s: website name */
                __( 'Follow your order - %s', 'codigo-envio-woocommerce' ),
                get_bloginfo()
            );
            $content = $this->get_template($order, $subject, $mailer);
            $headers = "Content-Type: text/html\r\n";
            $mailer->send( $recipient, $subject, $content, $headers );

            $tracking_args = array(
                'country' => ($order->get_shipping_country()) ? $order->get_shipping_country() : $order->get_billing_country(),
                'zip' => ($order->get_shipping_postcode()) ? $order->get_shipping_postcode() : $order->get_billing_postcode(),
            );
            $tracking_url = CDES_Couriers::get_tracking_link_by_courier($courier, $tracking_code, $tracking_args);
             
            $order_note =  sprintf(
                /* translators: %1$s: tracking code, %2$s: Courier name, %3$s: tracking url */
                __( 'Tracking Code "%1$s" by "%2$s" sent to customer. Track <a href="%3$s">here</a>', 'codigo-envio-woocommerce' ),
                $tracking_code,
                $courier,
                $tracking_url,
            );
            $order->add_order_note( $order_note ); 

            update_post_meta($order->get_id(), '_order_tracking_link', $tracking_url);
            update_post_meta($order->get_id(), '_order_tracking_code_sended', true);
        }

        public function get_template($order, $heading, $mailer) {
            $template = 'emails/tracking-code.php';

            return wc_get_template_html( $template, array(
                'order'         => $order,
                'email_heading' => $heading,
                'sent_to_admin' => false,
                'plain_text'    => false,
                'email'         => $mailer
            ) );
        }

        public function woo_adon_plugin_template( $template, $template_name, $template_path ) {
            global $woocommerce;

            $_template = $template;
            if ( ! $template_path ) 
               $template_path = $woocommerce->template_url;
        
            $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ )) . '/';

             $template = locate_template(
                array(
                    $template_path . $template_name,
                    $template_name
                )
            );
        
            if( ! $template && file_exists( $plugin_path . $template_name ) )
                $template = $plugin_path . $template_name;
        
            if ( ! $template )
                $template = $_template;
       
            return $template;
       }


    }