<?php
// src/TEW/TPBundle/Twig/Extension/TEWExtension.php
namespace TEW\TPBundle\Twig\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Intl\Intl;

class TEWExtension extends \Twig_Extension
{
    private $skills;
    private $languages;
    
    
    public function __construct()
    {
        $this->skills = new ArrayCollection(array('none','novice','spoken','bilingual', 'mother tongue'));
        $this->languages = Intl::getLanguageBundle()->getLanguageNames();
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('stars', array($this, 'starsFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('gender', array($this, 'genderFilter')),
            new \Twig_SimpleFilter('mail', array($this, 'mailFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('languageSkill', array($this, 'languageSkillFilter')),
            new \Twig_SimpleFilter('commentsByTalentpool', array($this, 'commentsByTalentpoolFilter')),
            new \Twig_SimpleFilter('commentAverageScore', array($this, 'commentAverageScoreFilter')),
        );
    }

    public function starsFilter($nb)
    {
        $stars = "";
        if ($nb>0) {
            for ($i=1;$i<=5;$i++ ) {
                $stars .= $i<=$nb?"<i class=\"icon-star\" data-rating=\"$i\"></i>":"<i class=\"icon-star-empty\" data-rating=\"$i\"></i>";
            }
        }
        return $stars;
    }
    
    public function genderFilter($gender)
    {
        return $gender=='m'?'Male':'Female';
    }
    
    public function mailFilter($email)
    {
        return "<a href=\"mailto:$email\">$email</a>";
    }
    
    public function languageSkillFilter(\TEW\TPBundle\Entity\CdteLanguage $languageSkill = null)
    {
        //echo '@'.$languageSkill->getLanguage().'@';

        $result = ($this->languages!=null && $languageSkill->getLanguage())?$this->languages[$languageSkill->getLanguage()].' ('.$this->skills[$languageSkill->getSkill()].')':'';

        return $result;
    }

    public function commentsByTalentpoolFilter(\Doctrine\ORM\PersistentCollection $comments, \TEW\TPBundle\Entity\talentpool $tp = null)
    {
        $result = new ArrayCollection();
        foreach ($comments as $comment) {
            if ($comment->getTalentpool() == $tp){
                $result->add($comment);
            }
        }
        return $result; 
    }
    
    public function commentAverageScoreFilter(ArrayCollection $comments)
    {
        $result = 0; $i=0;
        foreach ($comments as $comment) {
            $i++;
            $result += $comment->getScore();
        }
        return $result/($i==0?1:$i);
    }
    
    public function getName()
    {
        return 'tew_extension';
    }
}