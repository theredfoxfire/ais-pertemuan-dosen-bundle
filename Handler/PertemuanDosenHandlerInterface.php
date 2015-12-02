<?php

namespace Ais\PertemuanDosenBundle\Handler;

use Ais\PertemuanDosenBundle\Model\PertemuanDosenInterface;

interface PertemuanDosenHandlerInterface
{
    /**
     * Get a PertemuanDosen given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return PertemuanDosenInterface
     */
    public function get($id);

    /**
     * Get a list of PertemuanDosens.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post PertemuanDosen, creates a new PertemuanDosen.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return PertemuanDosenInterface
     */
    public function post(array $parameters);

    /**
     * Edit a PertemuanDosen.
     *
     * @api
     *
     * @param PertemuanDosenInterface   $pertemuan_dosen
     * @param array           $parameters
     *
     * @return PertemuanDosenInterface
     */
    public function put(PertemuanDosenInterface $pertemuan_dosen, array $parameters);

    /**
     * Partially update a PertemuanDosen.
     *
     * @api
     *
     * @param PertemuanDosenInterface   $pertemuan_dosen
     * @param array           $parameters
     *
     * @return PertemuanDosenInterface
     */
    public function patch(PertemuanDosenInterface $pertemuan_dosen, array $parameters);
}
