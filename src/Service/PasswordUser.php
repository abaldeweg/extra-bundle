<?php

namespace Baldeweg\Bundle\ExtraBundle\Service;

use Baldeweg\Bundle\ExtraBundle\Form\PasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PasswordUser
{
    public function __construct(
        private TokenStorageInterface $token,
        private AuthorizationCheckerInterface $auth,
        private UserPasswordEncoderInterface $encoder,
        private ManagerRegistry $registry,
        private FormFactoryInterface $form
    ) {
    }

    protected function getUser()
    {
        return $this->token->getToken()->getUser();
    }

    protected function isGranted($attribute, $subject = null): bool
    {
        return $this->auth->isGranted($attribute, $subject);
    }

    protected function getDoctrine(): ManagerRegistry
    {
        return $this->registry;
    }

    protected function createForm(string $type, $data = null, array $options = []): FormInterface
    {
        return $this->form->create($type, $data, $options);
    }

    public function password(Request $request): JsonResponse
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        if (null === $this->getUser()) {
            return new JsonResponse([]);
        }

        $user = $this->getUser();
        $form = $this->createForm(PasswordType::class, $user);

        $form->submit(
            json_decode(
                $request->getContent(),
                true
            )
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->encoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'id' => $this->getUser()->getId(),
                'username' => $this->getUser()->getUsername(),
                'roles' => $this->getUser()->getRoles(),
                'isUser' => $this->isGranted('ROLE_USER'),
                'isAdmin' => $this->isGranted('ROLE_ADMIN'),
            ]);
        }

        return new JsonResponse([
                'msg' => 'The password could not be changed!',
        ], 400);
    }
}
