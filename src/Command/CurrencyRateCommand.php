<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:currency-rate',
    description: 'Get rate.',
    hidden: false
)]
class CurrencyRateCommand extends Command
{
    private string $name = 'app:currency-rate';

    public function __construct(private HttpClientInterface $httpClient)
    {
        parent::__construct($this->name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            'https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=UAH'
        );

        $rate = json_decode($response->getContent(), true);
        $rate = $rate['UAH'];

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            'https://www.google-analytics.com/mp/collect?api_secret=wvpekWPZQhGkzSlZx2aXfA&measurement_id=G-10Q2148QS8',
            [
                'json' => [
                    'client_id' => 'user_id_123',
                    'non_personalized_ads' => false,
                    'events' => [
                        [
                            'name' => 'currency_rate_to_uah',
                            'params' => [
                                'currency' => 'ETH',
                                'rate' => $rate,
                            ]
                        ]
                    ]
                ]
            ],
        );

        $output->writeln(['Send data '.$rate.' '.$response->getStatusCode().PHP_EOL]);

        return Command::SUCCESS;
    }
}