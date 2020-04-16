<?php

namespace App\Controller;

use App\Entity\Entrenador;
use App\Form\EntrenadorType;
use App\Repository\EntrenadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipo;
use App\Repository\EquipoRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;


/**
 * @Route("/entrenador")
 */
class EntrenadorController extends AbstractController
{
    /**
     * @Route("/", name="entrenador_index", methods={"GET"})
     */
    public function index(EntrenadorRepository $entrenadorRepository , EquipoRepository $equipoRepository): Response
    {
        return $this->render('entrenador/index.html.twig', [
            'entrenadors' => $entrenadorRepository->findAll(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entrenador_new", methods={"GET","POST"})
     */
    public function new(Request $request , EquipoRepository $equipoRepository): Response
    {
        $entrenador = new Entrenador();
        $form = $this->createForm(EntrenadorType::class, $entrenador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form->get('Foto')->getData();
            
            if($foto){
                $originalNombre = pathinfo($foto->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('entrenadores'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $entrenador->setFoto($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrenador);
            $entityManager->flush();

            return $this->redirectToRoute('entrenador_index');
        }

        return $this->render('entrenador/new.html.twig', [
            'entrenador' => $entrenador,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/{id}", name="entrenador_show", methods={"GET"})
     */
    public function show(Entrenador $entrenador , EquipoRepository $equipoRepository): Response
    {
        return $this->render('entrenador/show.html.twig', [
            'entrenador' => $entrenador,
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entrenador_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrenador $entrenador , EquipoRepository $equipoRepository): Response
    {
        $form = $this->createForm(EntrenadorType::class, $entrenador);
        $form->handleRequest($request);
        $filesystem = new Filesystem();
        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form->get('Foto')->getData();
            
            if($foto){
                $originalNombre = pathinfo($foto->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('entrenadores'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $filesystem->remove($this->getParameter('entrenadores').'/'.$entrenador->getFoto());
                $entrenador->setFoto($newFilename);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrenador_index');
        }

        return $this->render('entrenador/edit.html.twig', [
            'entrenador' => $entrenador,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrenador_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entrenador $entrenador , EquipoRepository $equipoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrenador->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem();
           
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrenador);
            $entityManager->flush();
            $filesystem->remove($this->getParameter('entrenadores').'/'.$entrenador->getFoto());
        }

        return $this->redirectToRoute('entrenador_index');
    }
}
