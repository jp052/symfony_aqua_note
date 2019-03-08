<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenusController extends Controller

{
    /**
     * @Route("/genus/new")
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus' . rand(1, 100));
        $genus->setSubFamily('Octopedia');
        $genus->setSpeciesCount(rand(100, 9999));
        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->flush();

        return new Response('Genus created');
    }

    /** @Route("/genus")
     * @return Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAll();

        return $this->render('genus/list.html.twig', [
            'genuses' => $genuses,
        ]);

    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     * @param $genusName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($genusName)
    {
        $em = $this->getDoctrine()->getManager();
        $genusRepo = $em->getRepository('AppBundle:Genus');
        $genus = $genusRepo->findOneBy(['name' => $genusName]);

        if(!$genus) {
            throw $this->createNotFoundException('genus not found');
        }


        //cache every marked down sentence to get better performance
        //TODO JP: activate caching again
        /*$cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);
        if ($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            sleep(1);
            $funFact = $this->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }

        //quick access to container via just using get
        $funFact = $this->get('markdown.parser')
            ->transform($funFact);
        */


        return $this->render('genus/show.html.twig', array(
            'genus' => $genus,
        ));
    }

    //Sensio @Method("GET") doesnt work, so use symfony core @Route functionality

    /**
     * @Route("/genus/{genusName}/notes", name="genus_show_notes", methods={"GET"})
     * @param $genusName
     * @return JsonResponse
     */
    public function getNotesAction($genusName)
    {
        $notes = [
            [
                'id' => 1,
                'username' => 'AquaPelham',
                'avatarUri' => '/images/leanna.jpeg',
                'note' => 'Octopus asked me a riddle, outsmarted me',
                'date' => 'Dec. 10, 2015'
            ],
            [
                'id' => 2,
                'username' => 'AquaWeaver',
                'avatarUri' => '/images/ryan.jpeg',
                'note' => 'I counted 8 legs... as they wrapped around me',
                'date' => 'Dec. 1, 2015'
            ],
            [
                'id' => 3,
                'username' => 'AquaPelham',
                'avatarUri' => '/images/leanna.jpeg',
                'note' => 'Inked!',
                'date' => 'Aug. 20, 2015'
            ],
        ];

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}
