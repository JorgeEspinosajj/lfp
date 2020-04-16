<?php

namespace App\Controller;

use App\Entity\Jugador;
use App\Form\JugadorType;
use App\Repository\EquipoRepository;
use App\Repository\JugadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jugador")
 */
class JugadorController extends AbstractController
{
    /**
     * @Route("/", name="jugador_index", methods={"GET"})
     */
    public function index(JugadorRepository $jugadorRepository, EquipoRepository $equipoRepository): Response
    {
        return $this->render('jugador/index.html.twig', [
            'jugadors' => $jugadorRepository->findAll(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jugador_new", methods={"GET","POST"})
     */
    function new (Request $request, EquipoRepository $equipoRepository): Response {
        $jugador = new Jugador();
        $form = $this->createForm(JugadorType::class, $jugador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $foto = $form->get('Foto')->getData();

            if ($foto) {
                $originalNombre = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('jugadores'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $jugador->setFoto($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jugador);
            $entityManager->flush();

            return $this->redirectToRoute('jugador_index');
        }

        return $this->render('jugador/new.html.twig', [
            'jugador' => $jugador,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),

        ]);
    }

    /**
     * @Route("/{id}", name="jugador_show", methods={"GET"})
     */
    public function show(Jugador $jugador, EquipoRepository $equipoRepository): Response
    {
        return $this->render('jugador/show.html.twig', [
            'jugador' => $jugador,
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jugador_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Jugador $jugador, EquipoRepository $equipoRepository): Response
    {
        $form = $this->createForm(JugadorType::class, $jugador);
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
                        $this->getParameter('jugadores'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $filesystem->remove($this->getParameter('jugadores') . '/' . $jugador->getFoto());
                $jugador->setFoto($newFilename);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jugador_index');
        }

        return $this->render('jugador/edit.html.twig', [
            'jugador' => $jugador,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="jugador_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Jugador $jugador, EquipoRepository $equipoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jugador->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jugador);
            $entityManager->flush();
            $filesystem->remove($this->getParameter('jugadores') . '/' . $jugador->getFoto());

        }

        return $this->redirectToRoute('jugador_index');
    }
}
