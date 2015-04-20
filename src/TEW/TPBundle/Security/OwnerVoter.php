<?php
namespace TEW\TPBundle\Security;
 
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
 
class OwnerVoter implements VoterInterface
{

    public function supportsAttribute($attribute)
    {
        //return 1 === preg_match('/^ROLE_(TALENTPOOL|CANDIDATE|COMPANY)_/', $attribute);
        return 1 === preg_match('/^ROLE_TEW_OBJECT_(EDIT|DELETE|VIEW|ANONYMOUS_VIEW)/', $attribute);
    }
 

    public function supportsClass($class) 
    {
        return false;
    }
 
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        //return VoterInterface::ACCESS_GRANTED;
        // No opinion by default
        $vote = VoterInterface::ACCESS_ABSTAIN;
        $classname = get_class($object);
        if ($classname === 'TEW\TPBundle\Security\OwnerVoter') { // in sonata_admin, this could happen
            return $vote;
        }
        // we check all roles for this user...
//                    print_r($attributes);
        foreach ($attributes as $attribute) {
            // ... we ignore roles that are not concerned by the voter rule
            if (false === $this->supportsAttribute($attribute)) {
                continue;
            }
 
            // for a given target role, the default rule is to deny access...
            $user = $token->getUser();
//            print "<br>$attribute - ".get_class($object)."<br>";
//            print "<br>$attribute - user cie: ".$user->getCompany()."<br>";
 
            // ...except for the owner of the object
            if ($object->getOwningCompany()->getId() === $user->getCompany()->getId()) { // the user's company is the same as the object's one
                return 'ROLE_TEW_OBJECT_DELETE'!==$attribute?VoterInterface::ACCESS_GRANTED:VoterInterface::ACCESS_DENIED;
            } else { // The user is not owner but has the role to do it 
                switch ($attribute) {
                    case "ROLE_TEW_OBJECT_VIEW":
                        switch($classname) {
                            case "TEW\TPBundle\Entity\TalentPool":
                                return $object->getCompanies()->contains($user->getCompany())?VoterInterface::ACCESS_GRANTED:VoterInterface::ACCESS_DENIED;
                                break;
                            default:
                                return VoterInterface::ACCESS_DENIED;
                        }
                        break;
                        
                    case "ROLE_TEW_OBJECT_ANONYMOUS_VIEW":
                        switch($classname) {
                            case "TEW\TPBundle\Entity\TalentPool":
                                return $object->getCompanies()->contains($user->getCompany())?VoterInterface::ACCESS_GRANTED:VoterInterface::ACCESS_DENIED;
                                break;
                            case "TEW\TPBundle\Entity\Candidate": 
                                foreach ($object->getTalentPools() as $tp) {
                                    if (($tp->getOwningCompany()->getId()===$user->getCompany()->getId()) ||
                                        $tp->getCompanies()->contains($user->getCompany())) {
                                        print "<em>$object tp $tp</em>: anonymous OK<br>";
                                        return VoterInterface::ACCESS_GRANTED;
                                    }
                                }
                                return VoterInterface::ACCESS_DENIED;;
                                break;
                            default: // this should not happen
                                return VoterInterface::ACCESS_DENIED;
                        }
                        break;
                    default:
                        return VoterInterface::ACCESS_DENIED;
                }
//                print "<br>$attribute - user cie: ".$user->getCompany()." / object cie: ".$object->getOwningCompany()."<br>";
                
            }
        }  
        return $vote;
    }
}