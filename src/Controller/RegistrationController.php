<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $entityManager = $this->getDoctrine()->getManager();

        if (empty($username) || empty($password) || empty($email)) {
            $result = array('success' => false, 'result' => 'Username, Password and Email required');
            return new Response(
                json_encode($result),
                Response::HTTP_FORBIDDEN,
                array('content-type' => 'json')
            );
        }

        if (!empty($entityManager->getRepository(User::class)->checkUser($username, $email))) {
            $result = array('success' => false, 'result' => 'Username or Email already taken');
            return $response = new Response(
                json_encode($result),
                Response::HTTP_FORBIDDEN,
                array('content-type' => 'json')
            );
        }

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setApiToken(hash('sha256', uniqid() . $email . $username));
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $password
            )
        );

        $entityManager->persist($user);
        $entityManager->flush();

        // do anything else you need here, like send an email
        $result = array('success' => true, 'apiToken' => $user->getApiToken());
        return $response = new Response(
            json_encode($result),
            Response::HTTP_CREATED,
            array('content-type' => 'json')
        );
        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );

    }
}
