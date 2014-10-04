<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-06-17
 * Time: 19:24
 */

namespace Application\PHPFramework;

use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\Models\User;

/**
 * Class SessionManager
 * All cred to Treehouse http://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
 * @package Application\PHPFramework
 */
class SessionManager{
   static function startSession($name, $limit = 0, $path = '/', $domain = null, $secure = null){

      session_start();

      self::setInitialValues($name, $limit, $path, $domain, $secure);

      if (self::hasSessionExpired()){
         self::endSession();
      } else{
         self::restoreSession();
      }
   }

   static function setInitialValues($name, $limit, $path, $domain, $secure){
      // Set the cookie name.
      session_name($name . "_Session");

      // Set the domain to default to the current domain.
      $domain = isset($domain) ? $domain : isset($_SERVER['SERVER_NAME']);

      // Set the default secure value to whether the site is being accessed with SSL
      $https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);

      // Set the cookie settings and start the session
      session_set_cookie_params($limit, $path, $domain, $https, true);
   }

   static protected function restoreSession(){
      $resetSessionVariable = self::hasTheSessionBeenSetBefore() === false || self::hasTheSessionVariablesChanged();

      if ($resetSessionVariable){
         self::resetSessionVariables();
         // Give a 5% chance of the session id changing on any request.
      } elseif (rand(1, 100) < 5){
         self::regenerateSession();
      }
   }

   static protected function resetSessionVariables(){
      $_SESSION['IPAddress'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
   }

   /**
    * This function will return true when a session is loaded by a host with a different IP address or browser.
    * The function will be false if the session is valid and true otherwise. This means it will return true on
    * malicious attempts.
    * @return bool
    */
   static protected function hasTheSessionVariablesChanged(){
      $hasTheSessionVariablesChanged = false;

      if (isset($_SESSION['IPAddress']) && $_SESSION['IPAddress'] != $_SERVER['REMOTE_ADDR']){
         $hasTheSessionVariablesChanged = true;
      }

      if (isset($_SESSION['userAgent']) && $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']){
         $hasTheSessionVariablesChanged = true;
      }

      return $hasTheSessionVariablesChanged;
   }

   /**
    * Checks if the session is completely new.
    * @return bool
    */
   static protected function hasTheSessionBeenSetBefore(){
      return isset($_SESSION['IPaddress']) && isset($_SESSION['userAgent']);
   }

   static protected function regenerateSession(){
      // If this session is obsolete it means there already is a new id
      if (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true){
         return;
      }

      // Set current session to expire in 10 seconds.
      $_SESSION['OBSOLETE'] = true;
      $_SESSION['EXPIRES']  = time() + 10;

      // Create new session without destroying the old one.
      session_regenerate_id(false);

      // Grab current session Id and close both sessions to allow other scripts to use them.
      $newSessionId = session_id();
      session_write_close();

      // Set session Id to the new on, and start it back up again.
      session_id($newSessionId);
      session_start();

      // Now we unset the obsolete and expiration values for the session we want to keep.
      unset($_SESSION['OBSOLETE']);
      unset($_SESSION['EXPIRES']);
   }

   /**
    * Check if the session has expired.
    * @return bool
    */
   static protected function hasSessionExpired(){
      return isset($_SESSION['OBSOLETE']) && isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time();
   }

   /**
    * @param array $userData
    */
   static public function setUserData(array $userData){
      $_SESSION['user'] = $userData;
   }

   /**
    * Ends the current session.
    */
   static function endSession(){
      $_SESSION = array();
      session_destroy();
      session_start();
   }

   /**
    * @return bool
    */
   static function isUserLoggedIn(){
      return isset($_SESSION['user']);
   }

   /**
    * @return User
    * @throws ErrorHandling\Exceptions\ApplicationException
    */
   static function getCurrentUser(){
      if (!isset($_SESSION['user'])){
         throw new ApplicationException('Ingen användare är inloggad.');
      }

      return new User($_SESSION['user']);
   }
} 