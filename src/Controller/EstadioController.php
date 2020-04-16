<?php

namespace App\Controller;

use App\Entity\Estadio;
use App\Form\EstadioType;
use App\Repository\EstadioRepository;
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
 * @Route("/estadio")
 */
class EstadioController extends AbstractController
{
    /**
     * @Route("/", name="estadio_index", methods={"GET"})
     */
    public function index(EstadioRepository $estadioRepository , EquipoRepository $equipoRepository): Response
    {
        return $this->render('estadio/index.html.twig', [
            'estadios' => $estadioRepository->findAll(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estadio_new", methods={"GET","POST"})
     */
    public function new(Request $request , EquipoRepository $equipoRepository): Response
    {
        $estadio = new Estadio();
        $form = $this->createForm(EstadioType::class, $estadio);
        $form->handleRequest($request);
        $foto = $form->get('Foto')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if($foto){
                $originalNombre = pathinfo($foto->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalNombre);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
                try {
                    $foto->move(
                        $this->getParameter('estadios'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $estadio->setFoto($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estadio);
            $entityManager->flush();

            return $this->redirectToRoute('estadio_index');
        }

        return $this->render('estadio/new.html.twig', [
            'estadio' => $estadio,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="estadio_show", methods={"GET"})
     */
    public function show(Estadio $estadio , EquipoRepository $equipoRepository): Response
    {
        return $this->render('estadio/show.html.twig', [
            'estadio' => $estadio,
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estadio_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estadio $estadio , EquipoRepository $equipoRepository): Response
    {
        $form = $this->createForm(EstadioType::class, $estadio);
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
                        $this->getParameter('estadios'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $filesystem->remove($this->getParameter('estadios').'/'.$estadio->getFoto());
                $estadio->setFoto($newFilename);

            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estadio_index');
        }

        return $this->render('estadio/edit.html.twig', [
            'estadio' => $estadio,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="estadio_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Estadio $estadio , EquipoRepository $equipoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estadio->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estadio);
            $entityManager->flush();
            $filesystem->remove($this->getParameter('estadios').'/'.$estadio->getFoto());
        }

        return $this->redirectToRoute('estadio_index');
    }
}
