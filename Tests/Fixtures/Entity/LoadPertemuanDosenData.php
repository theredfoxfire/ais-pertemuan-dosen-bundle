<?php

namespace Ais\PertemuanDosenBundle\Tests\Fixtures\Entity;

use Ais\PertemuanDosenBundle\Entity\PertemuanDosen;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadPertemuanDosenData implements FixtureInterface
{
    static public $pertemuan_dosens = array();

    public function load(ObjectManager $manager)
    {
        $pertemuan_dosen = new PertemuanDosen();
        $pertemuan_dosen->setTitle('title');
        $pertemuan_dosen->setBody('body');

        $manager->persist($pertemuan_dosen);
        $manager->flush();

        self::$pertemuan_dosens[] = $pertemuan_dosen;
    }
}
