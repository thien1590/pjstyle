<?php
/**
 * Created by PhpStorm.
 * User: NTK
 * Date: 16-Jan-16
 * Time: 2:19 PM
 */
$step2=$step3='';
if(is_wc_endpoint_url( 'order-received' )){
    $step2=$step3='active';
}
if(is_checkout()){
    $step2='active';
}
?>
<div class="wrapper-status-order">
    <ul class="status-order row">
        <li class="col-xs-4  active">
            <span class="step">
              <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>"> 01</a>
            </span>
            <h4>
                <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>"><?php echo esc_html__('Shopping cart','ri-everest') ?></a>
            </h4>
        </li>
        <li class="col-xs-4 <?php echo esc_attr($step2)?> ">
            <span class="step">
              <a href="<?php echo WC()->cart->get_checkout_url(); ?>"> 02</a>
            </span>
            <h4>
                <a href="<?php echo WC()->cart->get_checkout_url(); ?>">
                <?php echo esc_html__('Check Out','ri-everest') ?>
                </a>
            </h4>
            <i class="fa fa-angle-right"></i>
        </li>
        <li class="col-xs-4 <?php echo esc_attr($step3)?>">
            <span class="step">
               03
            </span>
            <h4>
                <?php echo esc_html__('Order Complete','ri-everest') ?>
            </h4>
            <i class="fa fa-angle-right"></i>
        </li>
    </ul>
</div>
