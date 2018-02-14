<?php

namespace App\Service\Importer;

class ArrayImporterParser
{
    /**
     * Array of the field names
     * @var array $fields
     */
    protected $fields = [];

    /**
     * Array with everything in raw
     * @var array $rawData
     */
    protected $rawData = [];

    /**
     * Array with the parsed Data
     * @var array $parsedData;
     */
    protected $parsedData = [];

    /**
     * Where the valuable data starts (exclude the fields)
     * @var int $start
     */
    protected $start = 0;

    /**
     * Data array count
     * @var int $count
     */
    protected $count = 0;

    /**
     * Define Response status
     * @var boolean $status
     */
    protected $status = true;

    /**
     * Define Response message
     * @var string $message
     */
    protected $message = '';

    /**
     * Parses All data
     * @return bool
     */
    public function parseData() :bool
    {
        /** checking array length */
        if ($this->count === 0) {
            $this->composeMessage(0, 'Data is Empty');
            return false;
        }

        for ($i = $this->start; $i < $this->count; $i++) {
            $fieldCount = \count($this->rawData[$i]);
            for ($n = 0; $n < $fieldCount; $n++) {
                $this->parsedData[$i][$this->fields[$n]] = $this->rawData[$i][$n];
            }
        }

        if (\count($this->parsedData) === 0) {
            $this->composeMessage(0, 'Parsed Data is Empty');
            return false;
        }

        return true;
    }

    /**
     * Sets up the raw data and the count
     * @param array $data
     * @return bool
     */
    public function setRawData(array $data) : bool
    {
        /** counting data */
        $count = \count($data);
        if ($count === 0) {
            $this->composeMessage(0, 'Data is Empty');
            return false;
        }

        $this->count = $count;
        $this->rawData = $data;

        return true;
    }

    /**
     * Loads field names from specified index
     * @param int $index
     * @return bool
     */
    public function setFieldsFromDataIndex(int $index) :bool
    {
        /** checking if the index is valid */
        if (!\array_key_exists($index, $this->rawData)) {
            $this->composeMessage(0, 'The index set up as field mapping is incorrect');
            return false;
        }

        /** getting the fields */
        $fieldsArray = $this->rawData[$index];
        if (\count($fieldsArray) === 0) {
            $this->composeMessage(0, 'No Fields Found on specified Index');
            return false;
        }

        $this->fields = $fieldsArray;
        return true;
    }

    /**
     * Returns the raw data
     * @return array
     */
    public function getRawData() :array
    {
        return $this->rawData;
    }

    /**
     * Returns the data count
     * @return int
     */
    public function getCount() :int
    {
        return $this->count;
    }

    public function getParsedData() :array
    {
        return $this->parsedData;
    }

    /**
     * Sets the start value of the array data content
     * @param int $start
     * @return bool
     */
    public function setStart(int $start) :bool
    {
        /** checking if the start is a valid index */
        if (!\array_key_exists($start, $this->rawData)) {
            $this->composeMessage(0, 'The index set up as start is incorrect');
            return false;
        }

        $this->start = $start;

        return true;
    }

    /**
     * Returns the message that was set by the Service.
     * @param bool $getEncoded | defines if the data returned will be json encoded
     * @return mixed
     */
    public function getMessageData(bool $getEncoded = false) :mixed
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