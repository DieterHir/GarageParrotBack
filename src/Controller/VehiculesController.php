<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Repository\VehiculesRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/vehicules', name: 'app_api_vehicules_')]

class VehiculesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private VehiculesRepository $repository,
        private SerializerInterface $serializer
    ) {
    }

    #[Route(name: 'new', methods: 'POST')]
    public function addVehicule(Request $request): JsonResponse
    {
        //GET : $request->query
        //POST: $request->request
        //    var_dump($request->getPayload());
        //     exit;

        $vehicule = $this->serializer->deserialize($request->getContent(),  Vehicules::class, 'json');
        $vehicule->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($vehicule);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($vehicule, 'json');

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }

    // #[Route(name: 'show', methods: 'GET')]
    // public function showVehicule(EntityManagerInterface $manager): JsonResponse
    // {
    //     //$repository = $manager->getRepository(Vehicules::class);
    //     $repository = $manager->getRepository(Vehicules::class);
    //     $vehicules = $repository->findAll();
    //     var_dump($vehicules);
    //     exit;
    // }

    #[Route(name: 'show', methods: 'GET')]
    public function showVehicule(VehiculesRepository $repo): JsonResponse
    {
        $vehicules = $repo->findAll();
        $vehicules = $this->serializer->serialize($vehicules, 'json');
        return new JsonResponse($vehicules, Response::HTTP_ACCEPTED, [], true);
    }

    #[Route(name: 'delete', methods: 'DELETE')]
    public function deleteVehicule(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get('id');

        $vehicule = $this->repository->findOneBy(['id' => $id]);

        if (!$vehicule) {
            return $this->json(
                ['message' => 'Erreur lors de la suppression du véhicule']
            );
        }

        $this->manager->remove($vehicule);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($vehicule, 'json');

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }

    #[Route(name: 'update', methods: 'PUT')]
    public function edit(Request $request): JsonResponse
    {

        $id = $request->getPayLoad()->get('id');
        $newInfos = $request->getContent();
        $vehicule = $this->repository->findOneBy(['id' => $id]);

        $this->serializer->deserialize($newInfos, Vehicules::class, 'json',
        [AbstractNormalizer::OBJECT_TO_POPULATE => $vehicule]);
        $vehicule->setUpdatedAt(new \DateTime);

        if(!$vehicule) {
            return $this->json(
                ['message' => 'Erreur lors de la modification de l\'offre']
            );
        }

        $this->manager->flush();

        $responseData = $this->serializer->serialize($vehicule, 'json');

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }
}
