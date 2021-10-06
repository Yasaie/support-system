<?php

namespace App\CoreRewrite\Passwords;

use Carbon\Carbon;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\DatabaseTokenRepository as CoreDatabaseTokenRepository;

class DatabaseTokenRepository extends CoreDatabaseTokenRepository implements TokenRepositoryInterface
{
    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return array
     */
    public function create(CanResetPasswordContract $user)
    {
        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken();
		$pin = $this->createNewPin();
        $this->getTable()->insert($this->makePayload($user, $token, $pin));

        return ['token'=>$token,'pin'=>$pin];
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user)
    {
        return $this->getTable()
        		->where('email', $user->email)
        		->orWhere('mobile',$user->mobile)
        		->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  mixed  $user
     * @param  string  $token
     * @param  string  $pin
     * @return array
     */
    protected function makePayload($user, $token, $pin)
    {
        return [
			'email' 	 => $user->email ,
			'mobile' 	 => $user->mobile,
			'token' 	 => $this->hasher->make($token),
			'pin'		 => $this->hasher->make($pin),
			'created_at' => new Carbon
		];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token)
    {
        $record = (array) $this->getTable()
							->where('mobile', $user->mobile)
							->orWhere('email', $user->email)
							->first();
		if(!empty($record['email'])){
			return $record &&
				! $this->tokenExpired($record['created_at']) &&
				$this->hasher->check($token, $record['token']);
		}
		return $record &&
			! $this->tokenExpired($record['created_at']) &&
			$this->hasher->check($token, $record['pin']);
	}

	/**
	 * Determine if a Pin record exists and is valid.
	 * @param CanResetPasswordContract $user
	 * @param $token
	 * @return bool
	 */
	public function existsPin(CanResetPasswordContract $user, $token){
        $record = (array) $this->getTable()
							->where('mobile', $user->mobile)
							->orWhere('email', $user->email)
							->first();
		return $record &&
			! $this->tokenExpired($record['created_at']) &&
			$this->hasher->check($token, $record['pin']);
	}

	/**
	 * Determine if a token record exists and is valid.
	 *
	 * @param CanResetPasswordContract $user
	 * @param $token
	 * @return bool
	 */
	public function existsToken(CanResetPasswordContract $user, $token){
        $record = (array) $this->getTable()
							->where('mobile', $user->mobile)
							->orWhere('email', $user->email)
							->first();
		return $record &&
			! $this->tokenExpired($record['created_at']) &&
			$this->hasher->check($token, $record['token']);
	}

    /**
     * Determine if the token has expired.
     *
     * @param  string  $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    /**
     * Delete a token record by user.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return void
     */
    public function delete(CanResetPasswordContract $user)
    {
        $this->deleteExisting($user);
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

	/**
	 * create a PIN number for user.
	 *
	 * @param int $length
	 * @return string
	 */
    public function createNewPin($length=6){
		$pin=hexdec(bin2hex(openssl_random_pseudo_bytes($length)));
		return mb_substr(preg_replace('/[a-zA-Z\+\^]/iu','',$pin),(-$length));
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return $this->connection->table($this->table);
    }

	/**
     * Get the hasher instance.
	 *
	 * @return \Illuminate\Contracts\Hashing\Hasher
	 */
    public function getHasher()
    {
        return $this->hasher;
    }
}
