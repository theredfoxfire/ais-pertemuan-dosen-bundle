<?php

namespace Ais\PertemuanDosenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\PertemuanDosenBundle\Model\PertemuanDosenInterface;
/**
 * PertemuanDosen
 */
class PertemuanDosen implements PertemuanDosenInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $pertemuan_id;

    /**
     * @var integer
     */
    private $dosen_id;

    /**
     * @var integer
     */
    private $kehadiran;

    /**
     * @var string
     */
    private $keterangan;

    /**
     * @var boolean
     */
    private $is_delete;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pertemuanId
     *
     * @param integer $pertemuanId
     *
     * @return PertemuanDosen
     */
    public function setPertemuanId($pertemuanId)
    {
        $this->pertemuan_id = $pertemuanId;

        return $this;
    }

    /**
     * Get pertemuanId
     *
     * @return integer
     */
    public function getPertemuanId()
    {
        return $this->pertemuan_id;
    }

    /**
     * Set dosenId
     *
     * @param integer $dosenId
     *
     * @return PertemuanDosen
     */
    public function setDosenId($dosenId)
    {
        $this->dosen_id = $dosenId;

        return $this;
    }

    /**
     * Get dosenId
     *
     * @return integer
     */
    public function getDosenId()
    {
        return $this->dosen_id;
    }

    /**
     * Set kehadiran
     *
     * @param integer $kehadiran
     *
     * @return PertemuanDosen
     */
    public function setKehadiran($kehadiran)
    {
        $this->kehadiran = $kehadiran;

        return $this;
    }

    /**
     * Get kehadiran
     *
     * @return integer
     */
    public function getKehadiran()
    {
        return $this->kehadiran;
    }

    /**
     * Set keterangan
     *
     * @param string $keterangan
     *
     * @return PertemuanDosen
     */
    public function setKeterangan($keterangan)
    {
        $this->keterangan = $keterangan;

        return $this;
    }

    /**
     * Get keterangan
     *
     * @return string
     */
    public function getKeterangan()
    {
        return $this->keterangan;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return PertemuanDosen
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}
