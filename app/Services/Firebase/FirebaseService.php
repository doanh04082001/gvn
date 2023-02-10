<?php
namespace App\Services\Firebase;

use Firebase;

class FirebaseService
{
    protected $auth;
    protected $database;
    protected $reference = "/";

    /**
     * FirebaseService constructor.
     *
     */
    public function __construct()
    {
        $this->auth = Firebase::auth();
        $this->database = Firebase::database();
    }

    /**
     * Create auth user on firebase.
     *
     * @param array $user
     *
     * @return Kreait\Firebase\Auth
     */
    public function createAuthUser($user)
    {
        return $this->auth->createUser($user);
    }

    /**
     * Create firebase custom token
     *
     * @param string $uid
     *
     * @return Lcobucci\JWT\Token
     */
    public function createCustomToken($uid)
    {
        return $this->auth->createCustomToken($uid);
    }

    /**
     * Sign in firebase using custom token
     *
     * @param string $uid
     *
     * @return Kreait\Firebase\Auth
     */
    public function signInWithCustomToken($uid)
    {
        $customToken = $this->createCustomToken($uid);

        return $this->auth->signInWithCustomToken($customToken);
    }

    /**
     * Get store path on firebase
     *
     * @param string $path
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function getReference($path)
    {
        return $this->database->getReference($this->reference . $path);
    }

    /**
     * Get the data from firebase
     *
     * @param string $path
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function getSnapshot($path)
    {
        return $this->getReference($path)->getSnapshot();
    }

    /**
     * Get the data from firebase
     *
     * @param string $path
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function get($path)
    {
        return $this->getSnapshot($path)->getValue();
    }

    /**
     * Validate if the store path has data
     *
     * @param string $path
     * @param string $child
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function hasChild($path, $child)
    {
        return $this->getSnapshot($path)->hasChild($child);
    }

    /**
     * Overwrite data on firebase with new ones
     *
     * @param string $path
     * @param array $data
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function set($path, $data)
    {
        return $this->getReference($path)->set($data);
    }

    /**
     * Store data on firebase
     *
     * @param string $path
     * @param array $data
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function push($path, $data)
    {
        return $this->getReference($path)->push($data);
    }

    /**
     * Update data on firebase
     *
     * @param string $path
     * @param array $data
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function update($path, $data)
    {
        return $this->getReference($path)->update($data);
    }

    /**
     * Delete data on firebase
     *
     * @param string $path
     *
     * @return Kreait\Firebase\Database\Reference
     */
    public function delete($path)
    {
        return $this->getReference($path)->remove();
    }
}
