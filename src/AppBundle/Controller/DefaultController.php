<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     */
    public function indexAction(Request $request)
    {
        $view = $this->view([], 200)
            ->setFormat('json');

        return $this->handleView($view);
    }
}
