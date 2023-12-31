<?php
namespace Http;

/**
 * Class Request an http request
 *
 *
 * @package Http
 */
class Request
{

    /**
     *  Get COOKIE Super Global
     * @var
     */
    public $cookie;

    /**
     *  Get REQUEST Super Global
     * @var
     */
    public $request;

    /**
     *  Get FILES Super Global
     * @var
     */
    public $files;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = ($_REQUEST);
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
    }

    /**
     *  Get Headers
     *
     * @return string
     */
    public function getHeaders()
    {
        return apache_request_headers();
    }


    /**
     *  Get Post
     *
     * @return string
     */
    public function getPost()
    {
        return $_POST;
    }

    /**
     *  Get PUT
     *
     * @return string
     */
    public function getPut()
    {
        parse_str(file_get_contents('php://input'), $_PUT);
        return $_PUT;
    }

    /**
     *  Get $_GET parameter
     *
     * @param String $key
     * @return string
     */
    public function get(string $key = '')
    {
        if ($key != '')
            return isset($_GET[$key]) ? $this->clean($_GET[$key]) : null;

        return $this->clean($_GET);
    }

    /**
     *  Get $_POST parameter
     *
     * @param String $key
     * @return string
     */
    public function post(string $key = '')
    {
        if ($key != '')
            return isset($_POST[$key]) ? $this->clean($_POST[$key]) : null;

        return $this->clean($_POST);
    }

    /**
     *  Get POST parameter
     *
     * @param String $key
     * @return string
     */
    public function input(string $key = '')
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($key != '') {
            return isset($request[$key]) ? $this->clean($request[$key]) : null;
        }

        return ($request);
    }

    /**
     *  Get value for server super global var
     *
     * @param String $key
     * @return string
     */
    public function server(string $key = '')
    {
        return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
    }

    /**
     *  Get Method
     *
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($this->server('REQUEST_METHOD'));
    }

    /**
     *  Returns the client IP addresses.
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->server('REMOTE_ADDR');
    }

    /**
     *  Script Name
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->server('REQUEST_URI');
    }

    /**
     *  Get Body
     *
     * @return string
     */
    public function getBody()
    {
        return file_get_contents('php://input');
    }

    /**
     *  Get Bearer Token
     * @return string
     */
    public function getBearerToken()
    {
        $headers = $this->getHeaders();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            return preg_replace('/Bearer\s/', '', $authHeader);
        }
        return null;
    }

    /**
     *  Set User
     * @return string
     */
    public function setUser($user)
    {
        $this->request['user'] = $user;
    }

    /**
     *  Get User
     * @return string
     */
    public function getUser()
    {
        return $this->request['user'];
    }

    /**
     * Clean Data
     *
     * @param $data
     * @return string
     */
    private function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                // Delete key
                unset($data[$key]);

                // Set new clean key
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}