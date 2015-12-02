<?php

namespace Ais\PertemuanDosenBundle\Model;

Interface PertemuanDosenInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set pertemuanId
     *
     * @param integer $pertemuanId
     *
     * @return PertemuanDosen
     */
    public function setPertemuanId($pertemuanId);

    /**
     * Get pertemuanId
     *
     * @return integer
     */
    public function getPertemuanId();

    /**
     * Set dosenId
     *
     * @param integer $dosenId
     *
     * @return PertemuanDosen
     */
    public function setDosenId($dosenId);

    /**
     * Get dosenId
     *
     * @return integer
     */
    public function getDosenId();

    /**
     * Set kehadiran
     *
     * @param integer $kehadiran
     *
     * @return PertemuanDosen
     */
    public function setKehadiran($kehadiran);

    /**
     * Get kehadiran
     *
     * @return integer
     */
    public function getKehadiran();

    /**
     * Set keterangan
     *
     * @param string $keterangan
     *
     * @return PertemuanDosen
     */
    public function setKeterangan($keterangan);

    /**
     * Get keterangan
     *
     * @return string
     */
    public function getKeterangan();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return PertemuanDosen
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
