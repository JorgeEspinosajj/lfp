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
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PerfilController extends AbstractController
{
    /**
     * @Route("/perfil", name="perfil")
     */
    public function index(EquipoRepository $equipoRepository, PartidosRepository $partidosRepository , AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('perfil/perfil.html.twig', [
            'controller_name' => 'HomeController',
            'equipos' => $equipoRepository->findAll(),
            'partidos' => $partidosRepository->findAll(),
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/editarP/{id}", name="editar" , methods={"GET","POST"})
     */



    public function edit( EquipoRepository $equipoRepository, PartidosRepository $partidosRepository , AuthenticationUtils $authenticationUtils , Request $request, User $user){

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $filesystem = new Filesystem();
        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form->get('Foto')->getData();

            if ($foto) {
                $originalNombre = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('perfiles'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $filesystem->remove($this->getParameter('perfiles') . '/' . $user->getFoto());
                $user->setFoto($newFilename);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }



        return $this->render(
            'perfil/editP.html.twig',
            array('form' => $form->createView(),'equipos' => $equipoRepository->findAll(),'user'=>$user)
            
        );
     }
}
