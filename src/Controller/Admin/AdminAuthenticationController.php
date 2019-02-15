<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LoginType;
use App\Form\RegistrationType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


class AdminAuthenticationController extends Controller
{
    /**
     * @Route("/fabrikadmin/login", name="admin_login")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class, array($lastUsername));

        return $this->render('admin/authentication/index.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * @Route("/fabrikadmin/registration", name="admin_registration")
     */
    public function adminRegistration(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $adminExist = !empty($userManager->findUsers());

        // Prevent access if admin already exists
        if ($adminExist) {
            throw new NotFoundHttpException();
        }

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save user
            $user->addRole('ROLE_ADMIN');
            $user->setEnabled(1);
            $userManager->updateUser($user);

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            // Fire the login event manually
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/authentication/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
