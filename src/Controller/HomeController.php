<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipo;
use App\Repository\EquipoRepository;
use App\Entity\Partidos;
use App\Form\PartidosType;
use App\Repository\PartidosRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Comentario;
use App\Form\ComentarioType;
use App\Repository\ComentarioRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EquipoRepository $equipoRepository, PartidosRepository $partidosRepository , AuthenticationUtils $authenticationUtils , ComentarioRepository $comentarioRepository)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'equipos' => $equipoRepository->findAll(),
            'partidos' => $partidosRepository->findAll(),
            'last_username' => $lastUsername,
            'comentarios' => $comentarioRepository->findAll(),
        ]);
    }
}
