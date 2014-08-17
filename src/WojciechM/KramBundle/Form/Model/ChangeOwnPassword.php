<?php

namespace WojciechM\KramBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeOwnPassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong password"
     * )
     */
     protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Password should by at least {{ limit }} chars long"
     * )
     * @Assert\Regex(pattern="/\d+/", message="Password must contain a digit")
     * @Assert\Regex(pattern="/[A-Z]+/u", message="Password must contain an uppercase character")
     * @Assert\Regex(pattern="/[a-z]+/u", message="Password must contain a lowercase character")
     */
     protected $newPassword;
	 
	 public function getNewPassword() {
		return $this->newPassword;
	 }
	 
	 public function getOldPassword() {
		return $this->oldPassword;
	 }
	 
	 public function setNewPassword($password) {
		$this->newPassword = $password;
	 }
	 
	 public function setOldPassword($password) {
		$this->oldPassword = $password;
	 }
}