<?php

namespace App\Test\Controller;

use App\Entity\Planning;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanningControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PlanningRepository $repository;
    private string $path = '/planning/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Planning::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Planning index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'planning[semaine]' => 'Testing',
            'planning[description]' => 'Testing',
            'planning[id_c]' => 'Testing',
        ]);

        self::assertResponseRedirects('/planning/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Planning();
        $fixture->setSemaine('My Title');
        $fixture->setDescription('My Title');
        $fixture->setId_c('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Planning');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Planning();
        $fixture->setSemaine('My Title');
        $fixture->setDescription('My Title');
        $fixture->setId_c('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'planning[semaine]' => 'Something New',
            'planning[description]' => 'Something New',
            'planning[id_c]' => 'Something New',
        ]);

        self::assertResponseRedirects('/planning/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSemaine());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getId_c());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Planning();
        $fixture->setSemaine('My Title');
        $fixture->setDescription('My Title');
        $fixture->setId_c('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/planning/');
    }
}
