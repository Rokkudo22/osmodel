<?php

namespace OSModel\Controller;

use App\Entity\OSModel;
use App\Manager\OSModelManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OSController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/os")
     * @Rest\QueryParam(
     *     name="osType",
     *     nullable=true,
     *     description="The os type to search for."
     * )
     *
     * @Rest\QueryParam(
     *     name="attributes",
     *     nullable=true,
     *     description="The attributes of the OS."
     * )
     *
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of os per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The current page"
     * )
     */
    public function listOSAction(ParamFetcherInterface $paramFetcher, OSModelManager $OSModelManager): Response
    {
        $pagerfanta = $OSModelManager->getPagerfanta($paramFetcher->all());
        $data = $pagerfanta->getCurrentPageResults();
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/os/{id}")
     */
    public function getOSAction(Request $request, int $id): Response
    {
        $data = $this->getDoctrine()->getRepository(OSModel::class)->find($id);
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/os/{id}", requirements={"id": "\d+"})
     * @ParamConverter("newOSModel", converter="fos_rest.request_body")
     */
    public function updateAction(OSModel $OSModel, OSModel $newOSModel): Response
    {
        $OSModel->setAttributes($newOSModel->getAttributes());

        $this->getDoctrine()->getManager()->flush();
        $view = $this->view($OSModel, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/os")
     * @ParamConverter("osModel", converter="fos_rest.request_body")
     */
    public function postOSAction(OSModel $osModel): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($osModel);
        $em->flush();

        $view = $this->view($osModel, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Delete("/os/{id}", requirements={"id": "\d+"})
     */
    public function deleteAction(OSModel $OSModel)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($OSModel);
        $em->flush();
        $view = $this->view(null, 204);

        return $this->handleView($view);
    }
}
