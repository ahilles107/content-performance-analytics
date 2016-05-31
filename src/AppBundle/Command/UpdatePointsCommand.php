<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
        $contentItems = $em->getRepository('AppBundle:ContentItem')->getMaintainedItems()->getResult();

        $maxPointsViews = $this->getContainer()->getParameter('max_points_views');
        $goodValueViews = $this->getContainer()->getParameter('good_value_views');
        $maxPointsBounceRate = $this->getContainer()->getParameter('max_points_bounce_rate');
        $goodValueBounceRate = $this->getContainer()->getParameter('good_value_bounce_rate');
        $maxPointsAvgTimeOnPage = $this->getContainer()->getParameter('max_points_avg_time_on_page');
        $goodValueAvgTimeOnPage = $this->getContainer()->getParameter('good_value_avg_time_on_page');

        $rows = [];
        foreach ($contentItems as $key => $item) {
            $pointsForVisits = $this->calculatePointsForVisits($item, $maxPointsViews, $goodValueViews);
            $pointsForBounceRate = $this->calculatePointsForBounceRate($item, $maxPointsBounceRate, $goodValueBounceRate, $pointsForVisits);
            $pointsForAvgTimeOnPage = $this->calculatePointsForAvgTimeOnPage($item, $maxPointsAvgTimeOnPage, $goodValueAvgTimeOnPage, $pointsForVisits);
            $item->setVisitsPoints($pointsForVisits);
            $item->setBounceRatePoints($pointsForBounceRate);
            $item->setAvgTimeOnPagePoints($pointsForAvgTimeOnPage);
            $item->setPointsCalculatedDate(new \DateTime());
            $item->setTotalPoints(
                $item->getVisitsPoints() +
                $item->getBounceRatePoints() +
                $item->getAvgTimeOnPagePoints()
            );

            $rows[] = array(
                $item->getGaPath(),
                $item->getVisits(),
                $pointsForVisits,
                $item->getBounceRate(),
                $pointsForBounceRate,
                $item->getAvgTimeOnPage(),
                $pointsForAvgTimeOnPage,
                $pointsForVisits + $pointsForBounceRate + $pointsForAvgTimeOnPage,
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
        $treshold = ($maxPoints * 60) / 100;
        $points = ($viewsNumber * $treshold) / $goodValue;

        return $points >= $maxPoints ? $maxPoints : round($points);
    }

    private function calculatePointsForBounceRate($item, $maxPoints, $goodValue, $visitsPoints)
    {
        if ($visitsPoints < 1) {
            return 0;
        }

        $bounceRateNumber = $item->getBounceRate();
        $treshold = ($maxPoints * 60) / 100;
        $points = $maxPoints - (($bounceRateNumber * $treshold) / $goodValue);

        return $points <= 0 ? $maxPoints : round($points) <= 0 ? 0 : round($points);
    }

    private function calculatePointsForAvgTimeOnPage($item, $maxPoints, $goodValue, $visitsPoints)
    {
        if ($visitsPoints < 1) {
            return 0;
        }

        $avgTimeOnPage = $item->getAvgTimeOnPage();
        $treshold = ($maxPoints * 60) / 100;
        $points = ($avgTimeOnPage * $treshold) / $goodValue;

        return $points >= $maxPoints ? $maxPoints : round($points);
    }
}
