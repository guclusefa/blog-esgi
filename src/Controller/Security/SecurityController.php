<?php

namespace App\Controller\Security;

use App\Constants\RouteConstants;
use App\Constants\ToastConstants;
use App\Utils\SecurityUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct
    (
        private readonly SecurityUtils $securityUtils
    )
    {
    }

    /**
     * Method to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: RouteConstants::ROUTE_LOGIN, methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // Check if the user is already authenticated
        if ($this->securityUtils->isUserAuthenticated()) {
            $this->addFlash(ToastConstants::TOAST_ERROR, 'You are already logged in.');
            return $this->redirectToRoute(RouteConstants::ROUTE_HOME);
        }

        // Check if there is any error
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash(ToastConstants::TOAST_ERROR, $error->getMessage());
        }

        // Retrieve the last username
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'lastUsername' => $lastUsername
        ]);
    }

    #[Route('/register', name: RouteConstants::ROUTE_REGISTER, methods: ['GET', 'POST'])]
    public function register(): Response
    {
        // Check if the user is already authenticated
        if ($this->securityUtils->isUserAuthenticated()) {
            $this->addFlash(ToastConstants::TOAST_ERROR, 'You are already logged in.');
            return $this->redirectToRoute(RouteConstants::ROUTE_HOME);
        }

        return $this->render('security/register.html.twig');
    }
}
