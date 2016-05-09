<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\ContentItem;
use AppBundle\Form\ContentItemType;

/**
 * ContentItem controller.
 *
 */
class ContentItemController extends FOSRestController
{
    /**
     * Lists all ContentItem entities.
     *
     *
     * @ApiDoc(
     *     statusCodes={
     *         200="Returned when successful"
     *     },
     *     tags={
     *         "in-development"
     *     }
     * )
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contentItems = $em->getRepository('AppBundle:ContentItem')->findAll();
        $view = $this->view($contentItems, 200)
            ->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Creates a new ContentItem entity.
     *
     *
     * @ApiDoc(
     *     statusCodes={
     *         202="Returned when successful"
     *     },
     *     input={
     *         "class"="\AppBundle\Form\ContentItemType"
     *     },
     *     tags={
     *         "in-development"
     *     }
     * )
     */
    public function newAction(Request $request)
    {
        $contentItem = new ContentItem();
        $form = $this->createForm('AppBundle\Form\ContentItemType', $contentItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contentItem);
            $em->flush();

            $view = $this->view($contentItem, 202);
        } else {
            $view = $this->view($form, 200);
        }

        $view->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Show single ContentItem.
     *
     *
     * @ApiDoc(
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     */
    public function showAction(ContentItem $contentItem)
    {
        $view = $this->view($contentItem, 200)
            ->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Edits a ContentItem entity.
     *
     *
     * @ApiDoc(
     *     statusCodes={
     *         200="Returned when successful"
     *     },
     *     input={
     *         "class"="\AppBundle\Form\ContentItemType"
     *     },
     *     tags={
     *         "in-development"
     *     }
     * )
     */
    public function editAction(Request $request, ContentItem $contentItem)
    {
        $editForm = $this->createForm('AppBundle\Form\ContentItemType', $contentItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contentItem);
            $em->flush();

            $view = $this->view($contentItem, 200);
        } else {
            $view = $this->view($editForm, 200);
        }

        $view->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Deletes a ContentItem entity.
     *
     *
     * @ApiDoc(
     *     statusCodes={
     *         204="Returned when successful"
     *     },
     *     tags={
     *         "in-development"
     *     }
     * )
     */
    public function deleteAction(Request $request, ContentItem $contentItem)
    {
        $form = $this->createDeleteForm($contentItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contentItem);
            $em->flush();
        }

        $view = $this->view(null, 204)->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Creates a form to delete a ContentItem entity.
     *
     * @param ContentItem $contentItem The ContentItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ContentItem $contentItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('content_delete', array('id' => $contentItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
