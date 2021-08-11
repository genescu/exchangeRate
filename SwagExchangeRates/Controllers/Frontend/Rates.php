<?php declare(strict_types = 1);

class Shopware_Controllers_Frontend_Rates extends Enlight_Controller_Action
{
    public function indexAction()
    {
        $this->container->get('front')->Plugins()->ViewRenderer()->setNoRender();
        $exchangeRates = $this->getExchangeRates();
        $this->response->setHeader('Content-type', 'application/json');
        $this->response->setBody(json_encode($exchangeRates));
        return $this->response;

    }

    private function getExchangeRates(): array
    {
        $query = $this->container->get('dbal_connection')->createQueryBuilder();
        $query->select(['name', 'rate'])
            ->from('s_exchange_rates', 'exchangeRates');

        $currenciesQueryResults = $query->execute()->fetchAll();
        $currencies["EUR"] = (float)1;
        if ($currenciesQueryResults) {
            foreach ($currenciesQueryResults as $currency) {
                $currencies[$currency['name']] = (float)$currency['rate'];
            }
            ksort($currencies);
        }

        $response ['status'] = (float)1;
        $response ['currencies'] = $currencies;
        return $response;
    }

    public function updateAction()
    {
        $this->container->get('front')->Plugins()->ViewRenderer()->setNoRender();
        $currentRates = $this->container->get('swag_exchange_rates.services.rates_service')->geCurrentExchangeRates();

        try {
            if (isset($currentRates[0]['name']) && $currentRates[0]['name'] !== '') {
                Shopware()->Db()->executeQuery('TRUNCATE TABLE `s_exchange_rates`');
                foreach ($currentRates as $rate) {
                    Shopware()->Db()->insert('s_exchange_rates', $rate);
                }

                $response['status'] = 1;
                $response['message'] = "Successfully updated!";

            }
            else
            {
                $response['status'] = 0;
                $response['message'] = "Invalid or empty source provided";
            }


        } catch (Exception $e) {

            $response['status'] = 0;
            $response['message'] = "There was a problem during the update. Try again later. Error message: " . $e->getMessage();

        } finally {

            $this->response->setHeader('Content-type', 'application/json');
            $this->response->setBody(json_encode($response));
            return $this->response;
        }

    }


}