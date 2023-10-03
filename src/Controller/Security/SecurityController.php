<?php

namespace App\Controller\Security;

use App\Constants\RouteConstants;
use App\Constants\ToastConstants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Method to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @param Security $security
     * @return Response
     */
    #[Route('/login', name: RouteConstants::ROUTE_LOGIN, methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        // Check if the user is already authenticated
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash(ToastConstants::TOAST_ERROR, 'You are already logged in.');
            return $this->redirectToRoute(RouteConstants::ROUTE_HOME);
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername,
        ]);
    }
}
