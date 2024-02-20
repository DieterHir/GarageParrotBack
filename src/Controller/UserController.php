<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\GarageRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('api/users', name: 'app_api_users_')]

class UserController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager,
        private UserRepository $repository,
        private SerializerInterface $serializer,
        private GarageRepository $garageRepository,
    ) {
    }

    #[ROUTE(name: 'new', methods: 'POST')]
    public function add(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get('garage_id');
        $user = $this->serializer->deserialize($request->getContent(),  User::class, 'json');
        $user->setCreatedAt(new DateTimeImmutable());

        $garage = $this->garageRepository->findOneBy(['id' => $id]);

        $user->setGarage($garage);

        $this->manager->persist($user);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($user, 'json', ['groups' => ['user']]);

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }

    #[ROUTE(name: 'show', methods: 'GET')]
    public function show(UserRepository $repo): JsonResponse
    {
        $users = $repo->findAll();
        $users = $this->serializer->serialize($users, 'json', ['groups' => ['user']]);
        return new JsonResponse($users, Response::HTTP_ACCEPTED, [], true);
    }

    #[ROUTE(name: 'update', methods: 'PUT')]
    public function update(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get('id');
        $newInfos = $request->getContent();
        $user = $this->repository->findOneBy(['id' => $id]);

        $this->serializer->deserialize(
            $newInfos,
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );
        $user->setUpdatedAt(new \DateTime);

        if (!$user) {
            return $this->json(
                ['message' => 'Erreur lors de la modification du compte employé']
            );
        }

        $this->manager->flush();

        $responseData = $this->serializer->serialize($user, 'json', ['groups' => ['user']]);

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }

    #[ROUTE(name: 'delete', methods: 'DELETE')]
    public function delete(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get('id');

        $user = $this->repository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->json(
                ['message' => 'Erreur lors de la suppression du compte employé']
            );
        }

        $this->manager->remove($user);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($user, 'json', ['groups' => ['user']]);

        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }

    #[ROUTE('/connexion', name: 'login', methods: 'POST')]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {
        if(null === $user){
            return new JsonResponse(['message' => 'Missing credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'user' => $user->getEmail(),
            'apiToken' => $user->getApiToken(),
            'roles' => $user->getRoles(),
        ]);
    }
}


    // {
    //     $id = $request->getPayLoad()->get('id');

    //     $user = $this->repository->findOneBy(['id' => $id]);

    //     if(!$user){
    //         return $this->json(
    //             ['message' => 'Utilisateur introuvable']
    //         );
    //     }

    //     $responseData = $this->serializer->serialize($user, 'json', ['groups' => ['user']]);

    //     return new JsonResponse($responseData, Response::HTTP_ACCEPTED, [], true);
    // }