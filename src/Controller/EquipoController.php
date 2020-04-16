<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Form\EquipoType;
use App\Repository\EquipoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/equipo")
 */
class EquipoController extends AbstractController
{


    /**
     * @Route("/", name="equipo_index", methods={"GET"})
     */
    public function index(EquipoRepository $equipoRepository): Response
    {
        return $this->render('equipo/index.html.twig', [
            'equipos' => $equipoRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="equipo_new", methods={"GET","POST"})
     */
    public function new(Request $request, EquipoRepository $equipoRepository): Response
    {
        $equipo = new Equipo();
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form->get('Escudo')->getData();
            $equipo->setPuntos(0);
            $equipo->setGolesFavor(0);
            $equipo->setGolesContra(0);
            if ($foto) {
                $originalNombre = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('escudos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $equipo->setEscudo($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipo);
            $entityManager->flush();

            return $this->redirectToRoute('equipo_index');
        }

        return $this->render('equipo/new.html.twig', [
            'equipo' => $equipo,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipo_show", methods={"GET"})
     */
    public function show(Equipo $equipo, EquipoRepository $equipoRepository): Response
    {
        return $this->render('equipo/show.html.twig', [
            'equipo' => $equipo,
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipo $equipo, EquipoRepository $equipoRepository): Response
    {
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);
        $filesystem = new Filesystem();
        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form->get('Escudo')->getData();

            if ($foto) {
                $originalNombre = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('escudos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $filesystem->remove($this->getParameter('escudos') . '/' . $equipo->getEscudo());
                $equipo->setEscudo($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipo_index');
        }

        return $this->render('equipo/edit.html.twig', [
            'equipo' => $equipo,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Equipo $equipo, EquipoRepository $equipoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $equipo->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipo);
            $entityManager->flush();
            $filesystem->remove($this->getParameter('escudos') . '/' . $equipo->getEscudo());
        }

        return $this->redirectToRoute('equipo_index');
    }
}
