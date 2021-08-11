<?php declare(strict_types=1);

namespace SwagExchangeRates\ExchangeBundle\Services;

use DOMDocument;
use Exception;
use Shopware\Components\HttpClient\GuzzleFactory;
use Shopware\Components\HttpClient\GuzzleHttpClient as GuzzleClient;

class RatesService
{
    protected string $exchangeRateSourceProvider = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    private GuzzleClient $guzzleClient;

    public function __construct(GuzzleFactory $guzzlefactory)
    {
        $this->guzzleClient = new GuzzleClient($guzzlefactory);
    }

    public function geCurrentExchangeRates(): array
    {
        $sourceContentProvider = $this->getExternalPageContent();
        $rates = [];
        if ($sourceContentProvider) {
            $doc = new DOMDocument();
            $doc->preserveWhiteSpace = FALSE;
            $doc->loadXML($sourceContentProvider);
            $node1 = $doc->getElementsByTagName('Cube')->item(0);
            foreach ($node1->childNodes as $node2) {
                foreach ($node2->childNodes as $node3) {
                    $rate = [];
                    if (strtotime($node2->getAttribute('time')) > (time() - 24 * 3600)) {
                        $rate['name'] = $node3->getAttribute('currency');
                        $rate['rate'] = $node3->getAttribute('rate');
                        $rate['created_at'] = $node2->getAttribute('time');
                        $rates[] = $rate;

                    }
                    unset($rate);
                }
            }

        }

        return $rates;
    }

    private function getExternalPageContent(): string
    {
        try {
            $currentRate = $this->guzzleClient->get($this->exchangeRateSourceProvider);
            return $currentRate->getBody();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
