<?php
// src/TEW/TPBundle/Twig/Extension/TEWExtension.php
namespace TEW\TPBundle\Twig\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Intl\Intl;

class TEWExtension extends \Twig_Extension
{
    private $skills;
    private $languages;
    private $countries;
    private $currencies;
    
    
    public function __construct()
    {
        $this->skills = new ArrayCollection(array('none','beginner','intermediate','fluent', 'mother tongue'));
        $this->cdteStatuses = new ArrayCollection(array('sleeping','active','in process','hired'));
        $this->languages = Intl::getLanguageBundle()->getLanguageNames();
        $this->countries = Intl::getRegionBundle()->getCountryNames();
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
            new \Twig_SimpleFilter('gender', array($this, 'genderFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('mail', array($this, 'mailFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('languageSkill', array($this, 'languageSkillFilter')),
            new \Twig_SimpleFilter('country', array($this, 'countryFilter')),
            new \Twig_SimpleFilter('currency', array($this, 'currencyFilter')),
            new \Twig_SimpleFilter('hashJoin', array($this, 'hashJoinFilter')),
            new \Twig_SimpleFilter('status', array($this, 'statusFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('commentsByTalentpool', array($this, 'commentsByTalentpoolFilter')),
            new \Twig_SimpleFilter('commentsAverageScore', array($this, 'commentsAverageScoreFilter')),
            new \Twig_SimpleFilter('commentsAverageScoreStars', array($this, 'commentsAverageScoreStarsFilter'), array('is_safe' => array('html'))),
        );
    }

    public function starsFilter($nb)
    {
        $stars = "";
        if ($nb>=0) {
            for ($i=1;$i<=5;$i++ ) { // star color: #158cba
                $stars .= $i<=$nb?"<i class=\"icon-star\" style=\"color:#ff851b\" data-rating=\"$i\"></i>":"<i class=\"icon-star-empty\" style=\"color:lightgrey\" data-rating=\"$i\"></i>";
            }
        }
        return $stars;
    }
    
    public function genderFilter($gender)
    {
        return ($gender=='m')?'<i class="icon-male"></i>':($gender=='f'?'<i class="icon-female"></i>':'');
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
    
    public function countryFilter($country = null)
    {
        $result = (($this->countries!=null) && $country)?$this->countries[$country]:'';
        return $result;
    }
    
    public function currencyFilter($currency = null)
    {
        $result = ($this->currencies!=null && $currency)?$this->currencies[$currency]:'';
        return $result;
    }

    public function hashJoinFilter($array = null, $join)
    {
        $result = '';
        foreach ($array as $key=>$value){
            $key = $key=='active'?'visible':$key;
            $result .= ($result!=''?$join:'')."$key: $value";
        }
        return $result;
    }
    
    public function statusFilter(\TEW\TPBundle\Entity\CdteStatus $status = null)
    {
        $result = '<i class="icon icon-'.$status->getIcon().'" style="cursor:help; color:'.$status->getColor().'" title="'.$status->getName().'"></i>';
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
    
    public function commentsAverageScoreStarsFilter(ArrayCollection $comments)
    {
        return $this->starsFilter($this->commentsAverageScoreFilter($comments)).' ('.$comments->count().')';
    }
    
    public function getName()
    {
        return 'tew_extension';
    }
}