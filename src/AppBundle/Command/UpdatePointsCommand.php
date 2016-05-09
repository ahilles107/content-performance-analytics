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

class UpdatePointsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('calculate:points')
            ->setDescription('Calculate points for content items')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        //TODO: get only articles older than one 6 hours and youger than 7 days
        $contentItems = $em->getRepository('AppBundle:ContentItem')->findAll();

        $maxPointsViews = $this->getContainer()->getParameter('max_points_views');
        $goodValueViews = $this->getContainer()->getParameter('good_value_views');
        $maxPointsBounceRate = $this->getContainer()->getParameter('max_points_bounce_rate');
        $goodValueBounceRate = $this->getContainer()->getParameter('good_value_bounce_rate');
        $maxPointsAvgTimeOnPage = $this->getContainer()->getParameter('max_points_avg_time_on_page');
        $goodValueAvgTimeOnPage = $this->getContainer()->getParameter('good_value_avg_time_on_page');

        $rows = [];
        foreach ($contentItems as $key => $item) {
            $pointsForVisits = $this->calculatePointsForVisits($item, $maxPointsViews, $goodValueViews);
            $pointsForBounceRate = $this->calculatePointsForBounceRate($item, $maxPointsBounceRate, $goodValueBounceRate);
            $pointsForAvgTimeOnPage = $this->calculatePointsForAvgTimeOnPage($item, $maxPointsAvgTimeOnPage, $goodValueAvgTimeOnPage);
            $item->setVisitsPoints($pointsForVisits);
            $item->setBounceRatePoints($pointsForBounceRate);
            $item->setAvgTimeOnPagePoints($pointsForAvgTimeOnPage);
            $rows[] = array(
                $item->getUrl(),
                $item->getVisits(),
                $pointsForVisits,
                $item->getBounceRate(),
                $pointsForBounceRate,
                $item->getAvgTimeOnPage(),
                $pointsForAvgTimeOnPage,
                $pointsForVisits + $pointsForBounceRate + $pointsForAvgTimeOnPage
            );
        }

        $em->flush();

        $table = new Table($output);
        $table
            ->setHeaders(array('Path', 'Visits', 'Visits Points', 'Bounce Rate', 'Bounce Rate Points', 'Avg Time On Page', 'Avg Time On Page Points', 'All Points'))
            ->setRows($rows)
        ;
        $table->render();
    }

    private function calculatePointsForVisits($item, $maxPoints, $goodValue)
    {
        $viewsNumber = $item->getVisits();
        $goodPoint = round($maxPoints/2) + 1;
        $points = ($viewsNumber*$goodPoint) / $goodValue;

        return $points >= $maxPoints ? $maxPoints : round($points);
    }

    private function calculatePointsForBounceRate($item, $maxPoints, $goodValue)
    {
        $bounceRateNumber =  $item->getBounceRate();
        $goodPoint = round($maxPoints/2) + 1;
        $points = $maxPoints - (($bounceRateNumber*$goodPoint) / $goodValue);

        return $points >= $maxPoints ? $maxPoints : round($points) <= 0 ? 0 : round($points);
    }

    private function calculatePointsForAvgTimeOnPage($item, $maxPoints, $goodValue)
    {
        $avgTimeOnPage =  $item->getAvgTimeOnPage();
        $goodPoint = round($maxPoints/2) + 1;
        $points = ($avgTimeOnPage*$goodPoint) / $goodValue;

        return $points >= $maxPoints ? $maxPoints : round($points);
    }
}
