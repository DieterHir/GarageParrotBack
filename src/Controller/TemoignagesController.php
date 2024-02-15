<?php

namespace App\Controller;

use App\Entity\Temoignages;
use App\Repository\GarageRepository;
use App\Repository\TemoignagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[ROUTE('api/temoignages', name: 'app_api_temoignages_')]

class TemoignagesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TemoignagesRepository $repository,
        private SerializerInterface $serializer,
        private GarageRepository $garageRepository,
    ) {
    }

    #[ROUTE(name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get('garage_id');
        var_dump($request->get('FirstName'));

        $temoignage = $this->serializer->deserialize($request->getContent(), Temoignages::class, 'json');
        $temoignage->setCreatedAt(new \DateTimeImmutable());

        $garage = $this->garageRepository->findOneBy(['id' => $id]);

        $temoignage->setGarage($garage);

        $this->manager->persist($temoignage);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($temoignage, 'json', ['groups' => ['temoignage']]);

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }

        #[ROUTE(name:'show', methods: 'GET')]
        public function show(TemoignagesRepository $repository): JsonResponse
        {
            $temoignages = $repository->findAll();
            $temoignages = $this->serializer->serialize($temoignages, 'json', ['groups' => ['temoignages']]);

            return new JsonResponse($temoignages, Response::HTTP_ACCEPTED, [], true);
        }

        #[ROUTE(name:'update', methods: 'PUT')]
        public function update(Request $request){

            $id = $request->getPayload()->get('id');
            $updatedData = $request->getContent();

            $temoignage = $this->repository->findOneBy(['id' => $id]);
            $this->serializer->deserialize($updatedData, Temoignages::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $temoignage]);
            $temoignage->setUpdatedAt(new \DateTime);

            if(!$temoignage){
                return $this->json(
                    ['message' => 'Erreur dans l\'approbation du témoignage -back']
                );
            }

            $this->manager->flush();

            $responseData = $this->serializer->serialize($temoignage, 'json', ['groups'=> ['temoignages']]);

            return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);

        }

        #[ROUTE(name: 'delete', methods: 'DELETE')]
        public function delete(Request $request){

            $id = $request->getPayLoad()->get('id');

            $temoignage = $this->repository->findOneBy(['id' => $id]);

            if(!$temoignage){
                return $this->json(
                    ['message' => 'Erreur lors de la suppression du témoignage']
                );
            }

            $this->manager->remove($temoignage);
            $this->manager->flush();

            $responseData = $this->serializer->serialize($temoignage, 'json', ['groups' => ['temoignages']]);
            
            return new JsonResponse($responseData, Response::HTTP_CREATED, [],true);
        }
}
