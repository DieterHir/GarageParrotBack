<?php

namespace App\Controller;

use App\Entity\Garage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GarageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('api/garage', name: 'app_api_garage_')]

class GarageController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private GarageRepository $repository)
    {
    }

    #[Route(name: 'new', methods: 'POST')]
    public function new(): JsonResponse
    {
        $garage = new Garage();
        $garage->setName('Garage Parrot');
        $garage->setDescription('Blabla description blabla');
        $garage->setCreatedAt(new \DateTime());
        $garage->setAmOpeningTime(new \DateTime("09:00:00"));
        $garage->setPmOpeningTime(new \DateTime("14:00:00"));

        $this->manager->persist($garage);

        $this->manager->flush();

        return new JsonResponse(
            array('message' => "Garage resource created with {$garage->getId()} id", "status" => Response::HTTP_CREATED)
        );
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): Response
    {
        $garage = $this->repository->findOneBy(['id' => $id]);
        if (!$garage) {
            throw $this->createNotFoundException("No Garage found for {$id} id");
        }
        return $this->json(
            ['message' => "A Garage was found : {$garage->getName()} for {$garage->getId()} id"]
        );
    }

    #[Route('/', name: 'edit', methods: 'PUT')]
    public function edit(): Response
    {
    }

    #[Route('/', name: 'delete', methods: 'DELETE')]
    public function delete(): Response
    {
    }
}
