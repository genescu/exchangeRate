<?php declare(strict_types = 1);

namespace SwagExchangeRates;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use SwagExchangeRates\Bootstrap\Database;

/**
 * Class SwagExchangeRates
 * @package SwagExchangeRates
 */
class SwagExchangeRates extends Plugin
{
    /**
     * @param InstallContext $installContext
     */
    public function install(InstallContext $installContext)
    {
        $database = new Database($this->container->get('models'));
        $database->install();
    }

    /**
     * @param UninstallContext $uninstallContext
     */
    public function uninstall(UninstallContext $uninstallContext)
    {
        $database = new Database($this->container->get('models'));
        if ($uninstallContext->keepUserData()) {
            return;
        }
        $database->uninstall();
    }

}
