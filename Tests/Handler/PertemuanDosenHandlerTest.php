<?php

namespace Ais\PertemuanDosenBundle\Tests\Handler;

use Ais\PertemuanDosenBundle\Handler\PertemuanDosenHandler;
use Ais\PertemuanDosenBundle\Model\PertemuanDosenInterface;
use Ais\PertemuanDosenBundle\Entity\PertemuanDosen;

class PertemuanDosenHandlerTest extends \PHPUnit_Framework_TestCase
{
    const DOSEN_CLASS = 'Ais\PertemuanDosenBundle\Tests\Handler\DummyPertemuanDosen';

    /** @var PertemuanDosenHandler */
    protected $pertemuan_dosenHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::DOSEN_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $pertemuan_dosen = $this->getPertemuanDosen();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($pertemuan_dosen));

        $this->pertemuan_dosenHandler = $this->createPertemuanDosenHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $this->pertemuan_dosenHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $pertemuan_dosens = $this->getPertemuanDosens(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($pertemuan_dosens));

        $this->pertemuan_dosenHandler = $this->createPertemuanDosenHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $all = $this->pertemuan_dosenHandler->all($limit, $offset);

        $this->assertEquals($pertemuan_dosens, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pertemuan_dosen = $this->getPertemuanDosen();
        $pertemuan_dosen->setTitle($title);
        $pertemuan_dosen->setBody($body);

        $form = $this->getMock('Ais\PertemuanDosenBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pertemuan_dosen));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_dosenHandler = $this->createPertemuanDosenHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pertemuan_dosenObject = $this->pertemuan_dosenHandler->post($parameters);

        $this->assertEquals($pertemuan_dosenObject, $pertemuan_dosen);
    }

    /**
     * @expectedException Ais\PertemuanDosenBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pertemuan_dosen = $this->getPertemuanDosen();
        $pertemuan_dosen->setTitle($title);
        $pertemuan_dosen->setBody($body);

        $form = $this->getMock('Ais\PertemuanDosenBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_dosenHandler = $this->createPertemuanDosenHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $this->pertemuan_dosenHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pertemuan_dosen = $this->getPertemuanDosen();
        $pertemuan_dosen->setTitle($title);
        $pertemuan_dosen->setBody($body);

        $form = $this->getMock('Ais\PertemuanDosenBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pertemuan_dosen));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_dosenHandler = $this->createPertemuanDosenHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pertemuan_dosenObject = $this->pertemuan_dosenHandler->put($pertemuan_dosen, $parameters);

        $this->assertEquals($pertemuan_dosenObject, $pertemuan_dosen);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $pertemuan_dosen = $this->getPertemuanDosen();
        $pertemuan_dosen->setTitle($title);
        $pertemuan_dosen->setBody($body);

        $form = $this->getMock('Ais\PertemuanDosenBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pertemuan_dosen));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_dosenHandler = $this->createPertemuanDosenHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pertemuan_dosenObject = $this->pertemuan_dosenHandler->patch($pertemuan_dosen, $parameters);

        $this->assertEquals($pertemuan_dosenObject, $pertemuan_dosen);
    }


    protected function createPertemuanDosenHandler($objectManager, $pertemuan_dosenClass, $formFactory)
    {
        return new PertemuanDosenHandler($objectManager, $pertemuan_dosenClass, $formFactory);
    }

    protected function getPertemuanDosen()
    {
        $pertemuan_dosenClass = static::DOSEN_CLASS;

        return new $pertemuan_dosenClass();
    }

    protected function getPertemuanDosens($maxPertemuanDosens = 5)
    {
        $pertemuan_dosens = array();
        for($i = 0; $i < $maxPertemuanDosens; $i++) {
            $pertemuan_dosens[] = $this->getPertemuanDosen();
        }

        return $pertemuan_dosens;
    }
}

class DummyPertemuanDosen extends PertemuanDosen
{
}
