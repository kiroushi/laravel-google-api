<?php

namespace Kiroushi\LaravelGoogleApi;

use Google_Client;

class GoogleApi
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @param array $this->config
     * @param string $userEmail
     */
    public function __construct()
    {
        
        $this->config = config('google-api');

        // create an instance of the google client for OAuth2
        $this->client = new Google_Client(array_get($this->config, 'config', []));

        // set application name
        $this->client->setApplicationName(array_get($this->config, 'application_name', ''));

        // set oauth2 configs
        $this->client->setClientId(array_get($this->config, 'client_id', ''));
        $this->client->setClientSecret(array_get($this->config, 'client_secret', ''));
        $this->client->setRedirectUri(array_get($this->config, 'redirect_uri', ''));
        $this->client->setScopes(array_get($this->config, 'scopes', []));
        $this->client->setAccessType(array_get($this->config, 'access_type', 'online'));
        //$this->client->setApprovalPrompt(array_get($this->config, 'approval_prompt', 'auto'));

        // set developer key
        // $this->client->setDeveloperKey(array_get($this->config, 'developer_key', ''));

        // auth for service account
        if (array_get($this->config, 'service.enable', false)) {
            $this->auth('');
        }
    }

    /**
     * Getter for the google client.
     *
     * @return \Google_Client
     */
    public function getClient()
    {
        return $this->client;
    }
    

    public function impersonate(string $subject)
    {

        $this->client->setSubject($subject);

        return $this;

    }

    public function setScopes(array $scopes)
    {

        $this->client->setScopes($scopes);

        return $this;

    }

    public function setUseBatch(bool $state)
    {

        $this->client->setUseBatch($state);

        return $this;

    }

    /**
     * Setter for the google client.
     *
     * @param string $client
     *
     * @return self
     */
    public function setClient(Google_Client $client)
    {
        $this->client = $client;
        
        return $this;
    }

    /**
     * Getter for the google service.
     *
     * @param string $service
     *
     * @throws \Exception
     *
     * @return \Google_Service
     */
    public function getService($service)
    {
        $service = 'Google_Service_'.ucfirst($service);

        if (class_exists($service)) {
            $class = new \ReflectionClass($service);

            return $class->newInstance($this->client);
        }

        throw new UnknownServiceException($service);
    }

    /**
     * Setup correct auth method based on type.
     *
     * @param $userEmail
     * @return void
     */
    protected function auth($userEmail = '')
    {
        // see (and use) if user has set Credentials
        if ($this->useAssertCredentials($userEmail)) {
            return;
        }

        // fallback to compute engine or app engine
        $this->client->useApplicationDefaultCredentials();
    }

    /**
     * Determine and use credentials if user has set them.
     * @param $userEmail
     * @return bool used or not
     */
    protected function useAssertCredentials($userEmail = '')
    {
        $serviceJsonUrl = array_get($this->config, 'service.file', '');

        if (empty($serviceJsonUrl)) {
            return false;
        }

        $this->client->setAuthConfig($serviceJsonUrl);
        
        if (! empty($userEmail)) {
            $this->client->setSubject($userEmail);
        }

        return true;
    }

    /**
     * Magic call method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->client, $method)) {
            return call_user_func_array([$this->client, $method], $parameters);
        }

        throw new \BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }
}
