<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/change_password", name="app_change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createFormBuilder()
        ->add('old_password', PasswordType::class)
        ->add('new_password', PasswordType::class)
        ->add('repeated_password', PasswordType::class) 
        ->add('change', SubmitType::class)
        ->getForm();

        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return $this->render('change_password.html.twig', [
                'form' => $form->createView(),
            ]);;
        }

        $data = $form->getData();

        $old_pwd = $data['old_password'];
        $new_pwd = $data['new_password']; 
        $new_pwd_repeat = $data['repeated_password'];

        $user = $this->getUser();

        $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);
        if(!$checkPass) {
            return $this->render('change_password.html.twig', [
                'form' => $form->createView(),
                'errno' => 1,
                'msg' => "Niepoprawne hasło!"
            ]);
        }

        if ($new_pwd != $new_pwd_repeat) {
            return $this->render('change_password.html.twig', [
                'form' => $form->createView(),
                'errno' => 1,
                'msg' => 'Hasła nie zgadzają się!'
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $new_pwd_encoded = $passwordEncoder->encodePassword($user, $new_pwd_repeat); 
        $user->setPassword($new_pwd_encoded);
        $entityManager->flush($user);

        return $this->render('change_password.html.twig', [
            'form' => $form->createView(),
            'msg' => 'Poprawna zmiana hasła!'
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}