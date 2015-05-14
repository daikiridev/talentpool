<?php

namespace TEW\TPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\JsonResponse;

use TEW\TPBundle\Entity\CdteComment;
use TEW\TPBundle\Form\CdteCommentType;

use TEW\TPBundle\Twig\Extension\TEWExtension;

/**
 * CdteCdteComment controller for service requests
 *
 */
class CdteCommentController extends Controller {

    /**
     * Return the zone associated to a given country
     *
     */
    public function jsonCdteCommentAddAction() {
        $request = $this->container->get('request');
        if ($request->isXmlHttpRequest()) {
//        if (true) {
            $comment = new CdteComment();
            $response = new JsonResponse();
            
            $form = $this->createForm(new CdteCommentType(), $comment);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                $tewext = new TEWExtension(); 

                $response->setData(array(
                        'data' => array(
                            'title' => $comment->getTitle(),
                            'stars' => $tewext->starsFilter($comment->getScore()),
                            'score' => $comment->getScore(),
                            'date' => $comment->getDate()->format('d M Y'),
                            'author' => $comment->getAuthor()->getUsername(),
                            'comment' => $comment->getComment(),
                        ),
                        'message' => 'Comment added!',
                        'query' => "jsonCdteAddComment()"
                        ));
            } else {
                $response->setData(array(
                        'data' => null,
                        'error' => true,
                        'message' => 'Comment not added. Please try again later...',
                        'query' => "jsonCdteAddComment()"
                        ));
            }
            return $response;
        }
        throw new \Exception('Invalid call');
    }
}
