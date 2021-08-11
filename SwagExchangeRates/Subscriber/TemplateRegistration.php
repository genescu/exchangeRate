<?php declare(strict_types = 1);

namespace SwagExchangeRates\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\HttpClient\GuzzleFactory;
use SwagExchangeRates\ExchangeBundle\Services\RatesService;

class TemplateRegistration implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;
    private RatesService $rateService;

    /**
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct($pluginDirectory, \Enlight_Template_Manager $templateManager)
    {
        $this->pluginDirectory = $pluginDirectory;
        $this->templateManager = $templateManager;
        $this->rateService = new RatesService(new GuzzleFactory());

    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch',
            'sBasket::sDeleteArticle::after' => 'onBasketDeleteArticle',
            'sBasket::sDeleteArticle::before' => 'onBasketBeforeDeleteArticle',
        ];
    }

    public function onPreDispatch()
    {
        $this->templateManager->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }


    public function onBasketDeleteArticle()
    {
        var_dump('After delete');
    }

    public function onBasketBeforeDeleteArticle()
    {
        var_dump('Before delete');
    }
}