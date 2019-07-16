<?php
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

class plgSystemCheckoutOverride extends JPlugin
{
  public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);

        $this->loadLanguage();
    }

    public function onAfterRoute()
    {
        $app = JFactory::getApplication();
        $input = $app->input;

        if ('com_checkout' == $input->get('option') && !$app->isAdmin()) {
        
            JLoader::register('CheckoutViewCheckout', dirname(__FILE__) . '/views/checkout/view.html.php');
            JLoader::register('CheckoutViewConfirm', dirname(__FILE__) . '/views/confirm/view.html.php');
            JLoader::register('CheckoutViewDelivery', dirname(__FILE__) . '/views/delivery/view.html.php');
            JLoader::register('CheckoutModelDelivery', dirname(__FILE__) . '/models/delivery.php');
            JLoader::register('CheckoutModelStock', dirname(__FILE__) . '/models/stock.php');
            JLoader::register('CheckoutModelCart', dirname(__FILE__) . '/models/cart.php');
             JLoader::register('CheckoutModelCheckout', dirname(__FILE__) . '/models/checkout.php');
        }
    }

}
