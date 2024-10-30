<?php

    Class CDES_Couriers {

        private $couriers;

        public function __construct () {
            $this->couriers = array(
                'CTT' => 'CTT',
                'DPD' => 'DPD',
                'NACEX' => 'Nacex',
                'GLS' => 'GLS',
                'DHL' => 'DHL',
                'UPS' => 'UPS',
                'MRW' => 'MRW',
                'PAACK' => 'Paack',
            );
        }

        public function get_couriers() {
            return $this->couriers;
        }

        public static function get_tracking_link_by_order_id($id) {
            return get_post_meta($id, '_order_tracking_link', true);
        }

        public static function get_tracking_link_by_courier($courier, $tracking_code, $args) {
            switch ($courier) {
                case 'CTT':
                    $url = "https://appserver.ctt.pt/CustomerArea/PublicArea_Detail?ObjectCodeInput=$tracking_code&SearchInput=$tracking_code&IsFromPublicArea=true";
                    break;
                case 'DPD':
                    $url = "https://tracking.dpd.pt/track-and-trace?reference=$tacking_code";
                    break;
                case 'NACEX':
                    $url = "https://www.nacex.pt/seguimientoFormularioExterno.do?intcli=$tracking_code";
                    break;
                case 'GLS':
                    if ($args['country'] == 'PT' or $args['country'] == 'ES') {
                        $url = "https://mygls.gls-portugal.pt/e/$tracking_code/".$args['zip']."/pt";
                    } else {
                        $url = "https://www.gls-portugal.pt/pt/seguimiento-envio/?match=$tracking_code&international=1";
                    }
                    break;
                case 'DHL':
                    $url = "https://www.dhl.com/pt-pt/home/tracking.html?tracking-id=$tracking_code&submit=1";
                    break;
                case 'UPS':
                    $url = "https://www.ups.com/track?loc=pt_PT&requester=QUIC&tracknum=$tracking_code/";
                    break;
                case 'PAACK':
                    $url = "https://mydeliveries.paack.app/tracking?tracking_number=$tracking_code&postal_code=".$args['zip'];
                    break;
            }

            return $url;
        }
    }