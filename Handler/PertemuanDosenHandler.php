<?php

namespace Ais\PertemuanDosenBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\PertemuanDosenBundle\Model\PertemuanDosenInterface;
use Ais\PertemuanDosenBundle\Form\PertemuanDosenType;
use Ais\PertemuanDosenBundle\Exception\InvalidFormException;

class PertemuanDosenHandler implements PertemuanDosenHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a PertemuanDosen.
     *
     * @param mixed $id
     *
     * @return PertemuanDosenInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of PertemuanDosens.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new PertemuanDosen.
     *
     * @param array $parameters
     *
     * @return PertemuanDosenInterface
     */
    public function post(array $parameters)
    {
        $pertemuan_dosen = $this->createPertemuanDosen();

        return $this->processForm($pertemuan_dosen, $parameters, 'POST');
    }

    /**
     * Edit a PertemuanDosen.
     *
     * @param PertemuanDosenInterface $pertemuan_dosen
     * @param array         $parameters
     *
     * @return PertemuanDosenInterface
     */
    public function put(PertemuanDosenInterface $pertemuan_dosen, array $parameters)
    {
        return $this->processForm($pertemuan_dosen, $parameters, 'PUT');
    }

    /**
     * Partially update a PertemuanDosen.
     *
     * @param PertemuanDosenInterface $pertemuan_dosen
     * @param array         $parameters
     *
     * @return PertemuanDosenInterface
     */
    public function patch(PertemuanDosenInterface $pertemuan_dosen, array $parameters)
    {
        return $this->processForm($pertemuan_dosen, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param PertemuanDosenInterface $pertemuan_dosen
     * @param array         $parameters
     * @param String        $method
     *
     * @return PertemuanDosenInterface
     *
     * @throws \Ais\PertemuanDosenBundle\Exception\InvalidFormException
     */
    private function processForm(PertemuanDosenInterface $pertemuan_dosen, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new PertemuanDosenType(), $pertemuan_dosen, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $pertemuan_dosen = $form->getData();
            $this->om->persist($pertemuan_dosen);
            $this->om->flush($pertemuan_dosen);

            return $pertemuan_dosen;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createPertemuanDosen()
    {
        return new $this->entityClass();
    }

}
