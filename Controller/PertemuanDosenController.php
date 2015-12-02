<?php

namespace Ais\PertemuanDosenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\PertemuanDosenBundle\Exception\InvalidFormException;
use Ais\PertemuanDosenBundle\Form\PertemuanDosenType;
use Ais\PertemuanDosenBundle\Model\PertemuanDosenInterface;


class PertemuanDosenController extends FOSRestController
{
    /**
     * List all pertemuan_dosens.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pertemuan_dosens.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pertemuan_dosens to return.")
     *
     * @Annotations\View(
     *  templateVar="pertemuan_dosens"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getPertemuanDosensAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->all($limit, $offset);
    }

    /**
     * Get single PertemuanDosen.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a PertemuanDosen for a given id",
     *   output = "Ais\PertemuanDosenBundle\Entity\PertemuanDosen",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the pertemuan_dosen is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="pertemuan_dosen")
     *
     * @param int     $id      the pertemuan_dosen id
     *
     * @return array
     *
     * @throws NotFoundHttpException when pertemuan_dosen not exist
     */
    public function getPertemuanDosenAction($id)
    {
        $pertemuan_dosen = $this->getOr404($id);

        return $pertemuan_dosen;
    }

    /**
     * Presents the form to use to create a new pertemuan_dosen.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newPertemuanDosenAction()
    {
        return $this->createForm(new PertemuanDosenType());
    }
    
    /**
     * Presents the form to use to edit pertemuan_dosen.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanDosenBundle:PertemuanDosen:editPertemuanDosen.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pertemuan_dosen id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pertemuan_dosen not exist
     */
    public function editPertemuanDosenAction($id)
    {
		$pertemuan_dosen = $this->getPertemuanDosenAction($id);
		
        return array('form' => $this->createForm(new PertemuanDosenType(), $pertemuan_dosen), 'pertemuan_dosen' => $pertemuan_dosen);
    }

    /**
     * Create a PertemuanDosen from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new pertemuan_dosen from the submitted data.",
     *   input = "Ais\PertemuanDosenBundle\Form\PertemuanDosenType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanDosenBundle:PertemuanDosen:newPertemuanDosen.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postPertemuanDosenAction(Request $request)
    {
        try {
            $newPertemuanDosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newPertemuanDosen->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_dosen', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing pertemuan_dosen from the submitted data or create a new pertemuan_dosen at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\PertemuanDosenBundle\Form\PertemuanDosenType",
     *   statusCodes = {
     *     201 = "Returned when the PertemuanDosen is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanDosenBundle:PertemuanDosen:editPertemuanDosen.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pertemuan_dosen id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pertemuan_dosen not exist
     */
    public function putPertemuanDosenAction(Request $request, $id)
    {
        try {
            if (!($pertemuan_dosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $pertemuan_dosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $pertemuan_dosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->put(
                    $pertemuan_dosen,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $pertemuan_dosen->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_dosen', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing pertemuan_dosen from the submitted data or create a new pertemuan_dosen at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\PertemuanDosenBundle\Form\PertemuanDosenType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPertemuanDosenBundle:PertemuanDosen:editPertemuanDosen.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pertemuan_dosen id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pertemuan_dosen not exist
     */
    public function patchPertemuanDosenAction(Request $request, $id)
    {
        try {
            $pertemuan_dosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $pertemuan_dosen->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_dosen', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a PertemuanDosen or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return PertemuanDosenInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($pertemuan_dosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $pertemuan_dosen;
    }
    
    public function postUpdatePertemuanDosenAction(Request $request, $id)
    {
		try {
            $pertemuan_dosen = $this->container->get('ais_pertemuan_dosen.pertemuan_dosen.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $pertemuan_dosen->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pertemuan_dosen', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
