<?php

class Auth_Jam extends Kohana_Auth_Jam {

    public function check_password($password)
    {
        $user = $this->get_user();

        if ( ! $user) {
            return false;
        }

        return password_verify($password, $this->password($password));
    }

    /**
     * Logs a user in.
     *
     * @param   string   $username  username
     * @param   string   $password  password
     * @param   boolean  $remember  enable autologin
     * @return  boolean
     */
    protected function _login($user, $password, $remember)
    {
        $user = $this->_load_user($user);

        if ( !$user) {
            return false;
        }

        if ( !$user->roles->has('login')) {
            return false;
        }

        $hash = $this->password($user);

        // If the passwords match, perform a login
        if ( !password_verify($password, $hash)) {
            return false;
        }

        if ( ! $this->_config['hash_algorithm'])
            throw new Kohana_Exception('A valid hash algorithm must be set in your auth config.');

        $hash_options = Arr::get($this->_config, 'hash_options', array());

        // If options changed rehash password and update in database
        if (password_needs_rehash($hash, $this->_config['hash_algorithm'], $hash_options)) {
            $user->password = password_hash($password, $algorithm, $options);
        }

        if ($remember === TRUE)
        {
            $this->remember($user);
        }

        // Finish the login
        $this->complete_login($user);

        return true;
    }
}
