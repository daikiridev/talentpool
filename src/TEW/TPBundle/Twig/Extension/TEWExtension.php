<?php
// src/TEW/TPBundle/Twig/Extension/TEWExtension.php
namespace TEW\TPBundle\Twig\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Intl\Intl;

class TEWExtension extends \Twig_Extension
{
    private $skills;
    private $languages;
    private $currencies;
    
    
    public function __construct()
    {
        $this->skills = new ArrayCollection(array('none','novice','intermediate','fluent', 'mother tongue'));
        $this->cdteStatuses = new ArrayCollection(array('sleeping','active','in process','hired'));
        $this->languages = Intl::getLanguageBundle()->getLanguageNames();
        // $this->currencies = Intl::getCurrencyBundle()->getCurrencyNames(); // exhaustive list -> very long...
        // var_dump($this->currencies); exit;
        $this->currencies = array(
            'AUD' => 'Australian Dollar',
            'CAD' => 'Canadian Dollar',
            'CHF' => 'Swiss franc',
            'CNX' => 'Chinese People\'s Bank Dollar',
            'CNY' => 'Chinese Yuan',
            'EUR' => 'Euro',
            'INR' => 'Indian Rupee',
            'HKD' => 'Hong Kong Dollar',
            'NZD' => 'New Zealand Dollar',
            'SGD' => 'Singapore Dollar',
            'TWD' => 'New Taiwan Dollar',
            'USD' => 'US Dollar',
        );
        
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('stars', array($this, 'starsFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('gender', array($this, 'genderFilter')),
            new \Twig_SimpleFilter('mail', array($this, 'mailFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('languageSkill', array($this, 'languageSkillFilter')),
            new \Twig_SimpleFilter('currency', array($this, 'currencyFilter')),
            new \Twig_SimpleFilter('commentsByTalentpool', array($this, 'commentsByTalentpoolFilter')),
            new \Twig_SimpleFilter('commentsAverageScore', array($this, 'commentsAverageScoreFilter')),
        );
    }

    public function starsFilter($nb)
    {
        $stars = "";
        if ($nb>=0) {
            for ($i=1;$i<=5;$i++ ) { // star color: #158cba
                $stars .= $i<=$nb?"<i class=\"icon-star\" style=\"color:gold\" data-rating=\"$i\"></i>":"<i class=\"icon-star-empty\" style=\"color:lightgrey\" data-rating=\"$i\"></i>";
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
        $result = ($this->languages!=null && $languageSkill->getLanguage())?
                $this->languages[$languageSkill->getLanguage()].' ('.$this->skills[$languageSkill->getSkill()].')'
                :'';
        return $result;
    }
    
    public function currencyFilter($currency = null)
    {
        $result = ($this->currencies!=null && $currency)?$this->currencies[$currency]:'';
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
    
    public function commentsAverageScoreFilter(ArrayCollection $comments)
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