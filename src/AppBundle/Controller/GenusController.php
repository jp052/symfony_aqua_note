<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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


        $notes = [
            'Octopus asked me a riddle, outsmarted me',
            'I counted 8 legs... as they wrapped around me',
            'Inked!'
        ];

        return $this->render('genus/show.html.twig', array(
            'name' => $genusName,
            'notes' => $notes,
            'funFact' => $funFact
        ));
    }
}
