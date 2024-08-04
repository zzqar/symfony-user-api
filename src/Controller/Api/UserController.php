<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\UserAuthRequest;
use App\Request\UserCreateRequest;
use App\Request\UserUpdateRequest;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/user', name: 'api_user_')]
class UserController extends AbstractController
{
    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function list(UserRepository $userRepository): Response
    {
        $userList = $userRepository->findAll();

        return $this->json(['users' => $userList]);
    }

    #[Route(path: '/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if ($user === null) {
            return $this->json(['message' => 'Пользователь не найден'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user, Response::HTTP_OK);
    }

    #[Route(
        path: '/',
        name: 'create',
        methods: ['POST']
    )]
    public function create(
        UserCreateRequest           $request,
        EntityManagerInterface      $entityManager,
        ValidatorInterface          $validator,
        UserPasswordHasherInterface $hasher
    ): Response
    {
        $newUser = new User();

        $newUser
            ->setName($request->name)
            ->setLogin($request->login)
            ->setPassword($request->password)
            ->setEmail($request->email)
            ->setSex($request->sex)
            ->setPhone($request->phone)
            ->setBirthday(new DateTime($request->birthday))
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTime());

        $newUser->setPassword($hasher->hashPassword($newUser, $request->password));

        $errors = $validator->validate($newUser);

        if (count($errors) > 0) {
            $mes = [];
            foreach ($errors as $error) {
                $mes[] = $error->getMessage();
            }
            return $this->json(['message' => $mes], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($newUser);
        $entityManager->flush();


        return $this->json($newUser, Response::HTTP_CREATED);
    }


    #[Route(path: '/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(
        int                         $id,
        UserUpdateRequest           $request,
        UserRepository              $userRepository,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $hasher
    ): Response
    {
        // Находим пользователя по ID
        $user = $userRepository->find($id);

        if ($user === null) {
            return $this->json(['message' => 'Пользователь не найден'], Response::HTTP_NOT_FOUND);
        }
        // Обновляем поля пользователя
        $user
            ->setName($request->name ?? $user->getName())
            ->setPhone($request->phone ?? $user->getPhone())
            ->setSex($data['sex'] ?? $user->getSex())
            ->setBirthday(new DateTime($data['birthday']) ?? $user->getBirthday());
        $user->setPassword($hasher->hashPassword($user, $request->password));

        // Сохраняем изменения
        $entityManager->flush();
        return $this->json($user, Response::HTTP_OK);
    }

    #[Route(path: '/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        if ($user === null) {
            return $this->json(['message' => 'Пользователь не найден'], Response::HTTP_NOT_FOUND);
        }
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json([], Response::HTTP_OK);
    }

    #[Route(path: '/auth', name: 'auth', methods: ['POST'])]
    public function auth(
        UserAuthRequest             $request,
        UserRepository              $userRepository,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface    $JWTTokenManager
    ): Response
    {

        $user = $userRepository->findOneBy(['login' => $request->login]);


        if ($user !== null && $hasher->isPasswordValid($user, $request->password)) {

            return $this->json([
                'user' => $user,
                'token' => $JWTTokenManager->create($user)
            ], Response::HTTP_OK);
        }

        return $this->json(['message' => 'Логин или пароль не верный'], Response::HTTP_NOT_FOUND);
    }
}