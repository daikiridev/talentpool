<?php
namespace TEW\TPBundle\Security;
 
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
 
class OwnerVoter implements VoterInterface
{
    // Cette méthode permet de définir pour quels rôles le voteur doit être
    // appelé, nous définissons ici que ce voteur sera appelé seulement sur
    // les rôles qui commencent par 'ROLE_ARTICLE_'
    public function supportsAttribute($attribute)
    {
        //return 1 === preg_match('/^ROLE_(TALENTPOOL|CANDIDATE|COMPANY)_/', $attribute);
        return 1 === preg_match('/^ROLE_TEW_OBJECT_(EDIT|DELETE|VIEW)/', $attribute);
    }
 
    // Cette méthode est utilisée pour vérifier la classe de l'utilisateur,
    // ce qui ne nous concerne pas dans notre exemple
    public function supportsClass($class) 
    {
        return true;
    }
 
    // La méthode principale qui doit retourner le vote
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        //return VoterInterface::ACCESS_GRANTED;
        // No opinion by default
        $vote = VoterInterface::ACCESS_ABSTAIN;
 
        // we check all roles for this user...
//                    print_r($attributes);
        foreach ($attributes as $attribute) {
            // ... we ignore roles that are not concerned by the voter rule
            if (false === $this->supportsAttribute($attribute)) {
                continue;
            }
 
            // for a given target role, the default rule is to deny access...
            $user = $token->getUser();
//            print "<br>$attribute - user cie: ".$user->getCompany()."<br>";
 
            // ...except for the owner of the object
            if ($object->getOwningCompany()->getId() === $user->getCompany()->getId()) { // the user's company is the same as the object's one
                return VoterInterface::ACCESS_GRANTED;
            } else { // The user is not owner but has the role to do it 
                return VoterInterface::ACCESS_DENIED;
//                print "<br>$attribute - user cie: ".$user->getCompany()." / object cie: ".$object->getOwningCompany()."<br>";
                
            }
        }   
        
        return $vote;
    }
}