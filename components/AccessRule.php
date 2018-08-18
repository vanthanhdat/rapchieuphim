<?php 
namespace app\components;

use app\models\User;
/**
 * summary
 */
class AccessRule extends \yii\filters\AccessRule
{
    /**
     * summary
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role == '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role == User::ROLE_USER) {
                if (!$user->getIsGuest()) {
                    return true;
                }
            // Check if the user is logged in, and the roles matchRole
            } elseif (!$user->getIsGuest() && $role == $user->identity->role) {
                return true;
            }
        }
        return false;
    }
}
?>