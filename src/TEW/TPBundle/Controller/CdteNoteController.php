<?php

namespace TEW\TPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\JsonResponse;

use TEW\TPBundle\Entity\CdteNote;
use TEW\TPBundle\Form\CdteNoteType;

/**
 * CdteCdteNote controller for service requests
 *
 */
class CdteNoteController extends Controller {
    /**
     * Lists all notes for a given candidate.
     *
     */
    public function indexAction(\TEW\TPBundle\Entity\Candidate $cdte)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TEWTPBundle:CdteNote')->findByCandidate($cdte);

        return $this->render('TEWTPBundle:CdteNote:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * 
     *
     */
    public function jsonCdteNoteAddAction() {
        $request = $this->container->get('request');
        if ($request->isXmlHttpRequest()) {
//        if (true) {
            $note = new CdteNote();
            $response = new JsonResponse();
            
            $form = $this->createForm(new CdteNoteType(), $note);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($note);
                $em->flush();

                $response->setData(array(
                        'data' => array(
                            'title' => $note->getTitle(),
                            'date' => $note->getDate()->format('d M Y'),
                            'author' => $note->getAuthor()->getUsername(),
                            'note' => $note->getNote(),
                        ),
                        'message' => 'Note added!',
                        'query' => "jsonCdteAddNote()"
                        ));
            } else {
                $response->setData(array(
                        'data' => null,
                        'error' => true,
                        'message' => 'Note not added. Please try again later...',
                        'query' => "jsonCdteAddNote()"
                        ));
            }
            return $response;
        }
        throw new \Exception('Invalid call');
    }
}
