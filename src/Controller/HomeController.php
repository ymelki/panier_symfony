<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    protected $mailer;
    /**
     * @Route("/home", name="app_home")
     */
    public function index(MailerInterface $mailerInterface): Response
    {
        $this->mailer=$mailerInterface;
        // ROW MESSAGE nécessaire pour le send
        $email=new TemplatedEmail();
        $email->from(new Address("contact@mail.com","Infos de la boutique"))
               ->to("admin@mail.com")
               ->htmlTemplate("mails/home.html.twig")
               ->subject("Visite de la page HOME");

        $this->mailer->send($email);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
