<?php
// TEW/src/TEW/TPBundle/Entity/Mail.php

namespace TEW\TPBundle\Entity;


/**
 * Mail
 *
 */
class Mail
{

    /**
     * @var string
     *
     */
    private $object;
    
    /**
     * @var string
     *
     */
    private $content;
    
    /**
     * @var string
     *
     */
    private $from;
    
    /**
     * @var string
     *
     */
    private $to;
    
    /**
     * @var integer
     *
     */
    private $candidate_details_request;
 
    /**
     * Constructor
     */
    public function __construct(\TEW\UserBundle\Entity\User $fromUser=null, \TEW\UserBundle\Entity\User $toUser=null)
    {
        $this->from = $fromUser?$fromUser->getEmail():null;
        $this->to = $toUser?$toUser->getEmail():null;
        $this->candidate_details_request = -1;
    }
    
    /**
     * Set object
     *
     * @param string $object
     * @return Mail
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string 
     */
    public function getObject()
    {
        return $this->object;
    }
    
    /**
     * Set content
     *
     * @param string $content
     * @return Mail
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set from
     *
     * @param string $from
     * @return Mail
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return string 
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * Set to
     *
     * @param string $to
     * @return Mail
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return string 
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set Candidate_details_request
     *
     * @param integer $id
     * @return Mail
     */
    public function setCandidateDetailsRequest($id)
    {
        $this->candidate_details_request = $id;

        return $this;
    }

    /**
     * Get Candidate_details_request
     *
     * @return integer 
     */
    public function getCandidateDetailsRequest()
    {
        return $this->candidate_details_request;
    }

}
