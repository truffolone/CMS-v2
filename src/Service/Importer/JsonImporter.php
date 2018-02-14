<?php

namespace App\Service\Importer;

use GuzzleHttp\Client;

class JsonImporter
{
    /**
     * Body of the Response
     * @var array $body
     */
    private $body = [];

    /**
     * Defines the complete URL of the call
     * @var string $url
     */
    private $url;

    /**
     * Data to Send in the call
     * @var array $data
     */
    private $data = [];

    /**
     * Method of the call
     * @var string $method
     * @default 'GET'
     */
    private $method = 'GET';

    /**
     * Define if enforce file overwrite
     * @var bool $enforce
     */
    private $enforce = true;

    /**
     * Define Response status
     * @var boolean $status
     */
    private $status = true;

    /**
     * Define Response message
     * @var string $message
     */
    private $message = '';

    /**
     * Define the path of the json file I am working with
     * @var string $filePath
     */
    private $filePath = '';

    /**
     * File handler for the session
     * @var resource $fileHandler
     */
    private $fileHandler = false;

    /**
     * Bind the file to work with and some others parameters
     * @param $folderPath
     * @param $fileName
     * @param bool $enforce
     * @return boolean
     */
    public function setJsonFile(string $folderPath, string $fileName, bool $enforce = true) :bool
    {
        /** checking folder existence */
        if (!$this->checkFolder($folderPath)) {
            $this->composeMessage(0, 'Impossible to create Folder ' . $folderPath);
        }

        /** checking file existence and getting the handler back */
        $filePath = $folderPath . $fileName . '.json';
        $this->enforce = $enforce;
        if (!$this->bindFile($filePath)) {
            $this->composeMessage(0, 'Impossible to create or open the File ' . $folderPath);
            return false;
        }

        /** saving the file path and returning true */
        $this->filePath = $filePath;
        $this->composeMessage(1, 'File has been successfully opened: ' . $folderPath);
        return true;
    }

    /**
     * Send the request after checking everything is ok
     * @return bool
     */
    public function sendRequest() :bool
    {
        /** Is Everything set up correctly? */
        if ($this->url === '') {
            $this->composeMessage(0, 'URL for the call is not defined');
            return false;
        }

        /** Setting up the client and sending the request */
        try {
            $client = new Client();
            $response = $client->request($this->method, $this->url, ['query' => $this->data]);
        } catch (\Exception $e) {
            $this->composeMessage(0, $e->getMessage());
            return false;
        }

        /** Saving Data */
        $decodedData = json_decode($response->getBody());
        if (!\is_array($decodedData)) {
            $this->composeMessage(0, 'Returned Data is incorrect');
            return false;
        }

        $this->body = $decodedData;
        return true;
    }


    /**
     * Save the data to the opened file
     * @param array $data
     * @return bool
     */
    public function saveDataToFile(array $data) :bool
    {
        /** do we have an opened file? */
        if (!$this->fileHandler) {
            $this->composeMessage(0, 'File to write is not opened');
            return false;
        }

        /** checking data */
        $dataCount = \count($data);
        if ($dataCount === 0) {
            $this->composeMessage(0, 'Data to write is empty');
            return false;
        }

        /** re-encoding the file as json */
        if (!$encodedData = json_encode($data)) {
            $this->composeMessage(0, 'There was a problem encoding the data to json');
            return false;
        }

        /** writing to file */
        if (!fwrite($this->fileHandler, $encodedData)) {
            $this->composeMessage(0, 'Impossible to write json string into file');
            return false;
        }

        /** closing the file handler */
        if (!fclose($this->fileHandler)) {
            $this->composeMessage(0, 'There was a problem closing the file');
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getBody() :array
    {
        return $this->body;
    }

    /**
     * Checks is the folder exists and create if it not
     * @param string $import
     * @return boolean
     */
    public function checkFolder(string $import) :bool
    {
        return !(!file_exists($import) && !mkdir($import) && !is_dir($import));
    }

    /**
     * @param string $filePath | Define the file path to check
     * @return bool
     */
    public function bindFile(string $filePath) : bool
    {
        /** if file doesn't exists */
        if ($this->enforce === true || !file_exists($filePath)) {
            return (bool) $this->fileHandler = @fopen($filePath, 'wb');
        }

        if ($this->enforce === false && file_exists($filePath)) {
            return (bool) $this->fileHandler = @fopen($filePath, 'rb');
        }

        return false;
    }

    /**
     * Returns the message that was set by the Service.
     * @param bool $getEncoded | defines if the data returned will be json encoded
     * @return array|string (json encoded)
     */
    public function getMessageData(bool $getEncoded = false)
    {
        /** checking if a message was set */
        if ($this->message === '') {
            $this->message = 'No message Was Set';
        }

        $data = ['status' => $this->status, 'message' => $this->message];

        if ($getEncoded === true) {
            return json_encode($data);
        }

        return $data;
    }

    /**
     * Adds a parameter to the send data
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addParameter(string $key, $value) :void
    {
        $this->data[$key] = $value;
    }

    /**
     * Define the url of the call
     * @param string $url
     * @return void
     */
    public function setUrl(string $url) :void
    {
        $this->url = $url;
    }

    /**
     * Define the method of the call
     * @param string $method
     * @return void
     */
    public function setMethod(string $method) :void
    {
        $this->method = $method;
    }

    /**
     * Create a response array
     * @param bool $status
     * @param string $message
     * @return void
     */
    protected function composeMessage(bool $status, string $message) :void
    {
        $this->status = $status;
        $this->message = $message;
    }
}
