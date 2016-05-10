<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Widop\GoogleAnalytics\Query;
use Widop\GoogleAnalytics\Client;
use Widop\HttpAdapter\CurlHttpAdapter;
use Widop\GoogleAnalytics\Service;
use Symfony\Component\Console\Helper\Table;

class FetchGADataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ga:fetch')
            ->setDescription('Fetch data for urls from Google Analytics')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientId = $this->getContainer()->getParameter('ga_client_id');
        $profileId = $this->getContainer()->getParameter('ga_profile_id');
        $privateKeyFile = $this->getContainer()->getParameter('kernel.root_dir').'/../bin/ga_p12_key/certificate.p12';
        $httpAdapter = new CurlHttpAdapter();
        $client = new Client($clientId, $privateKeyFile, $httpAdapter);
        $em = $this->getContainer()->get('doctrine')->getManager();

        $contentItems = $em->getRepository('AppBundle:ContentItem')->getValidContentItems()->getResult();
        $rows = [];
        foreach ($contentItems as $key => $item) {
            $service = new Service($client);
            $response = $service->query($this->getQuery($profileId, $item->getUrl()));
            $item->setVisits($response->getTotalsForAllResults()['ga:visits']);
            $item->setBounceRate($response->getTotalsForAllResults()['ga:bounceRate']);
            $item->setAvgTimeOnPage($response->getTotalsForAllResults()['ga:avgTimeOnPage']);
            $item->setValuesUpdatedDate(new \DateTime());

            $rows[] = array(
                $item->getUrl(),
                $item->getVisits(),
                $item->getBounceRate(),
                $item->getAvgTimeOnPage(),
            );
        }

        $em->flush();

        $table = new Table($output);
        $table
            ->setHeaders(array('Path', 'Visits', 'Bounce Rate', 'Avg Time On Page'))
            ->setRows($rows)
        ;
        $table->render();
    }

    private function getQuery($profileId, $path)
    {
        $query = new Query($profileId);
        $query->setStartDate(new \DateTime('-1year'));
        $query->setEndDate(new \DateTime());
        // See https://developers.google.com/analytics/devguides/reporting/core/dimsmets
        $query->setMetrics(array('ga:visits' ,'ga:bounceRate', 'ga:avgTimeOnPage'));
        $query->setDimensions(array('ga:pagePath'));
        // See https://developers.google.com/analytics/devguides/reporting/core/v3/reference#filters
        $query->setFilters(array('ga:pagePath=~^'.$path));

        return $query;
    }
}
