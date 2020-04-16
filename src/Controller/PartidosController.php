<?php

namespace App\Controller;

use App\Entity\Partidos;
use App\Form\PartidosType;
use App\Repository\PartidosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipo;
use App\Repository\EquipoRepository;


/**
 * @Route("/partidos")
 */
class PartidosController extends AbstractController
{
    /**
     * @Route("/", name="partidos_index", methods={"GET"})
     */
    public function index(PartidosRepository $partidosRepository, EquipoRepository $equipoRepository): Response
    {
        return $this->render('partidos/index.html.twig', [
            'partidos' => $partidosRepository->findAll(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partidos_new", methods={"GET","POST"})
     */
    public function new(Request $request, EquipoRepository $equipoRepository , PartidosRepository $partidosRepository): Response
    {
       
        
       
        
        
        $equipos = $equipoRepository->findAll();

        $matchs = array();


        foreach ($equipos as $k) {
            
            foreach ($equipos as $j) {

                if($k->getNombre() === $j->getNombre()){
                    continue;
                }
                $z = array($k,$j);
                sort($z);
                if(!in_array($z,$matchs)){
                    $matchs[] = $z;
                }
            
            }


        }
        foreach ($matchs as $r) {

           $r[0]->setPuntos(0);
           $r[0]->setGolesFavor(0);
           $r[0]->setGolesContra(0);
           $r[1]->setPuntos(0);
           $r[1]->setGolesFavor(0);
           $r[1]->setGolesContra(0);




        }
       


        for ($i=0; $i <2; $i++) { 
            foreach ($matchs as $x) {

        
                $golesLocal = mt_rand(0, 4);
                $golesVisitante = mt_rand(0, 4);
        
                $partido = new Partidos();
                $partido->setEquipoLocal($x[0]);

                $plocal = $x[0]->getPuntos();

                $glocalf = $x[0]->getGolesFavor();
                $glocalc = $x[0]->getGolesContra();
                $partido->setGolesLocal($golesLocal);   
                
                $x[0]->setGolesFavor($glocalf + $golesLocal);
                $x[0]->setGolesContra($glocalc + $golesVisitante);

                if ($golesLocal > $golesVisitante) {
               
                    $x[0]->setPuntos($plocal + 3);
                }  elseif ($golesLocal == $golesVisitante) {
                   
                    $x[0]->setPuntos($plocal + 1);
                   
                }



                $partido->setEquipoVisitante($x[1]);

                $pvisitante = $x[1]->getPuntos();

                $gvisitf = $x[1]->getGolesFavor();
                $gvisitc = $x[1]->getGolesContra();
                $partido->setGolesVisitante($golesVisitante);   
                
                $x[1]->setGolesFavor($gvisitf + $golesLocal);
                $x[1]->setGolesContra($gvisitc + $golesVisitante);

                if ($golesVisitante > $golesLocal) {
               
                    $x[1]->setPuntos($pvisitante + 3);
                }  elseif ($golesLocal == $golesVisitante) {
                   
                    $x[1]->setPuntos($pvisitante + 1);
                   
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($partido);
                $entityManager->flush();

      }
        }
     





      

      
      return $this->redirectToRoute('home');
        
        
      return $this->render('home/index.html.twig', [
          'partido' => $partido,
          
          'equipos' => $equipoRepository->findAll(),
          'partidos' => $partidosRepository->findAll(),
      ]);

      
        

        }
    /**
     * @Route("/{id}", name="partidos_show", methods={"GET"})
     */
    public function show(Partidos $partido, EquipoRepository $equipoRepository): Response
    {
        return $this->render('partidos/show.html.twig', [
            'partido' => $partido,
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partidos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partidos $partido, EquipoRepository $equipoRepository): Response
    {
        $form = $this->createForm(PartidosType::class, $partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partidos_index');
        }

        return $this->render('partidos/edit.html.twig', [
            'partido' => $partido,
            'form' => $form->createView(),
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="partidos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partidos $partido, EquipoRepository $equipoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $partido->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partidos_index');
    }
}
