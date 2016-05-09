<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\ContentItem;
use AppBundle\Form\ContentItemType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
     *         201="Returned when successful"
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

            $view = $this->view($contentItem, 201);
        } else {
            $view = $this->view($form, 200);
        }

        $view->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Update values for ContentItems.
     *
     *
     * @ApiDoc(
     *     statusCodes={
     *         200="Returned when successful"
     *     },
     *     tags={
     *         "in-development"
     *     },
     *     parameters={
     *         {"name"="form[type]", "dataType"="string", "required"="true", "description"="Possible types: views|bounce_rate|avg_time_on_page"},
     *         {"name"="form[value]", "dataType"="integer", "required"="true", "description"="Value"}
     *     }
     * )
     */
    public function valuesAction(Request $request, ContentItem $contentItem)
    {
        $form = $this->createFormBuilder([], array(
                'csrf_protection' => false,
            ))
            ->add('type', TextType::class)
            ->add('value', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        dump($form, $form->isSubmitted(), $form->isValid());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();

            switch ($data['type']) {
                case 'views':
                    $contentItem->setVisits($data['value']);
                    break;
                case 'bounce_rate':
                    $contentItem->setBounceRate($data['value']);
                    break;
                case 'avg_time_on_page':
                    $contentItem->setAvgTimeOnPage($data['value']);
                    break;
            }

            $em->flush();
            $view = $this->view($contentItem, 200);
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
