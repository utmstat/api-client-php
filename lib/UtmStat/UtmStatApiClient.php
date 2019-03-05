<?php

namespace UtmStat;

class UtmStatApiClient
{

    private $token;

    private $url = 'https://api.utmstat.com/v1';

    private $lastResponseData;

    public function __construct($token, $url = null)
    {
        $this->token = $token;
        if ($url) {
            $this->url = $url;
        }
    }

    public function check()
    {
        $this->call('check');
        $result = $this->getLastResponseData()['http_code'] == 200;
        return $result;
    }

    public function hasError()
    {
        $result = $this->getLastResponseData()['http_code'] != 200;
        return $result;
    }

    public function leadAdd($lead)
    {
        $result = $this->call('lead/add', $lead);
        return $result;
    }

    public function leadsList($filter = null, $offset = null, $limit = null)
    {
        $params = [
            'offset' => $offset,
            'limit' => $limit
        ];

        $params = array_merge($params, $filter);

        $result = $this->call('leads/list', $params);

        return $result;
    }

    public function leadsUpdate($lead, $by = 'id')
    {
        $lead['update_by_field'] = $by;
        $result = $this->call('leads/update', $lead);
        return $result;
    }

    public function getLastResponseData()
    {
        return $this->lastResponseData;
    }

    private function call($method, $params = null)
    {
        $response = $this->sendRequest($method, $params);
        return $response;
    }

    private function sendRequest($method, $params = [])
    {

        $body = [
            'jsonrpc' => '2.0',
            'method' => $method,
            'id' => 1,
            'params' => $params
        ];

        $ch = curl_init($this->url);

        $raw = json_encode($body);

        $authorization = "Authorization: Bearer " . $this->token;

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $raw);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $response = curl_exec($ch);

        $this->lastResponseData = curl_getinfo($ch);

        $data = json_decode($response, 1);

        if (isset($data['result'])) {
            $result = $data['result'];
        } else {
            $result = null;
        }

        return $result;
    }


}