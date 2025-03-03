<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Cms/ProductReview');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Cms/ProductReview');
    // $this->mergeConfigFrom(
    //     __DIR__.'/config.php', 'key_define_for_plugin'
    // );

    // Only push view if plugin enable
    if (sc_config_global('ProductReview')) {
        sc_push_include_view('shop_product_detail', (new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin.'::render');
        sc_push_include_script('shop_product_detail', (new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin.'::script');
        /**
         * Function render point data
         */
        if (!function_exists('sc_product_rating')) {
            function sc_product_rating($pId = 0) {
                $pointData = sc_product_get_rating($pId);
                if ($pointData) {
                    $data = '<div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:'.(number_format($pointData['total'] /$pointData['ct'], 1)*20).'%"></div>
                        </div>
                        <span class="rating_num">('.$pointData['ct'].')</span>
                    </div>';
                    return $data;
                }
            }
        }

        /**
         * Function render point data
         */
        if (!function_exists('sc_product_get_rating')) {
            function sc_product_get_rating($pId = 0) {
                if (sc_config_global('ProductReview')) {
                    $pointData = \App\Plugins\Cms\ProductReview\Models\PluginModel::getPointData($pId);
                } else {
                    $pointData =  [];
                }
                return $pointData;
            }
        }
    }