<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Googleplus {

    public function __construct() {

        $CI = & get_instance();
        $CI->config->load('googleplus');

        require FCPATH . 'vendor/google-login-api/apiClient.php';
        require FCPATH . 'vendor/google-login-api/contrib/apiOauth2Service.php';
        
        $this->client = new apiClient();
        $this->client->setApplicationName($CI->config->item('application_name', 'googleplus'));
        $this->client->setClientId($CI->settings->google_key);
        $this->client->setClientSecret($CI->settings->google_secret);
        $this->client->setRedirectUri($CI->config->item('redirect_uri', 'googleplus'));
        $this->client->setDeveloperKey($CI->config->item('api_key', 'googleplus'));
        $this->client->setScopes($CI->config->item('scopes', 'googleplus'));
        $this->client->setAccessType('online');
        $this->client->setApprovalPrompt('auto');
        $this->oauth2 = new apiOauth2Service($this->client);
    }

    public function loginURL() {
        return $this->client->createAuthUrl();
    }

    public function getAuthenticate() {
        return $this->client->authenticate();
    }

    public function getAccessToken() {
        return $this->client->getAccessToken();
    }

    public function setAccessToken() {
        return $this->client->setAccessToken();
    }

    public function revokeToken() {
        return $this->client->revokeToken();
    }

    public function getUserInfo() {
        return $this->oauth2->userinfo->get();
    }

}

?>