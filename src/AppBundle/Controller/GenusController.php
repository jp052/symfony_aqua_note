<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GenusController extends Controller

{
    /**
     * @Route("/genus/{genusName}")
     */
    public function showAction($genusName)

    {
        $funFact = 'Octopuses can change the color of their body in just *three-tenths* of a second!';

        //quick access to container via just using get
        $funFact = $this->get('markdown.parser')
                ->transform($funFact);



        return $this->render('genus/show.html.twig', array(
            'name' => $genusName,
            'funFact' => $funFact
        ));
    }

    //Sensio @Method("GET") doesnt work, so use symfony core @Route functionality
    /**
     * @Route("/genus/{genusName}/notes", name="genus_show_notes", methods={"GET"})
     */
    public function getNotesAction($genusName) {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}
