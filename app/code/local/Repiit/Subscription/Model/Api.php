<?php

class Repiit_Subscription_Model_Api
{

    //get authorization key
    /**
     * @param string $apiurl
     * @param string $accountid
     * @param string $key
     * @return string
     */
    public function getAuthorizationKey($apiurl = "", $accountid = "", $key = "")
    {
        return $_COOKIE['repiit_token'];
    }

    //get api url
    /**
     * @return string
     */
    protected function getApiUrl()
    {
        return Mage::getStoreConfig('repiitsubscription/api/url');
    }

    //get navigator userAgent
    public function getNavigatorUserAgent()
    {
        return isset($_COOKIE['navigator_useragent'])?$_COOKIE['navigator_useragent']:'';
    }

    //get dataset
    /**
     * @return string
     */
    public function getDataset()
    {
        return (string)Mage::getStoreConfig('repiitsubscription/api/dataset')?Mage::getStoreConfig('repiitsubscription/api/dataset'):'DAT';
    }

    /*
     * Get with curl
     * Params: apiUrl - url request including get parameters
     *         key - authorization key
     */
    protected function curlGet($apiUrl, $key)
    {

        $curlHost = Mage::getStoreConfig('repiitsubscription/api/curl_host');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_DNS_USE_GLOBAL_CACHE => false,
            CURLOPT_DNS_CACHE_TIMEOUT => 2,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST =>  0,
            CURLOPT_RESOLVE => ["repiitportalmanager.azurewebsites.net:443:65.52.130.1","repiitportalmanager.azurewebsites.net:80:65.52.130.1"],
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: $key",
                "Cache-Control: no-cache",
                "Accept: */*",
                "Accept-Encoding: gzip, deflate, sdch",
                "Accept-Language: en-US,en;q=0.8,ro;q=0.6,es;q=0.4,da;q=0.2",
                "User-Agent: " . $this->getNavigatorUserAgent(),
                "Content-Type: text/plain",
                "Connection: keep-alive",
                "Host: $curlHost"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $info = curl_getinfo($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        elseif (trim($response) == "") {
            return "Reponse empty. " . json_encode($info);
        }
        else {
            return $response;
        }
    }

    /*
     * POST with curl
     * Params: apiUrl - url request including parameters
     *         key - authorization key
     */
    protected function curlPost($apiUrl, $key)
    {

        $curlHost = Mage::getStoreConfig('repiitsubscription/api/curl_host');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            //CURLOPT_URL => "http://repiitportalmanager.azurewebsites.net/api/Item?itemNumber=testproduct&itemText=texttext&price=10000&ruleID=02&costPrice=70000&unit=1&deliveryTime=1&supplier=1",
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RESOLVE => ["repiitportalmanager.azurewebsites.net:443:65.52.130.1"],
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: $key",
                "Cache-Control: no-cache",
                "Accept: */*",
                "Accept-Encoding: gzip, deflate, sdch",
                "Accept-Language: en-US,en;q=0.8,ro;q=0.6,es;q=0.4,da;q=0.2",
                "User-Agent: " . $this->getNavigatorUserAgent(),
                "Content-Type: application/json",
                "Connection: keep-alive",
                "Host: $curlHost"
            ),
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => ""
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $info = curl_getinfo($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        elseif (trim($response) == "") {
            return "Reponse empty. " . json_encode($info);
        }
        else {
            return $response;
        }
    }

    /*
     * POST with curl
     * Params: apiUrl - url request including parameters
     *         key - authorization key
     */
    protected function curlPostBody($apiUrl,$key, $jsonData)
    {

        $curlHost = Mage::getStoreConfig('repiitsubscription/api/curl_host');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RESOLVE => ["repiitportalmanager.azurewebsites.net:443:65.52.130.1"],
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                "authorization: $key",
                "Cache-Control: no-cache",
                "Accept: */*",
                "Accept-Encoding: gzip, deflate, sdch",
                "Accept-Language: en-US,en;q=0.8,ro;q=0.6,es;q=0.4,da;q=0.2",
                "User-Agent: " . $this->getNavigatorUserAgent(),
                "Content-Type: application/json",
                "Connection: keep-alive",
                "Host: $curlHost"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $info = curl_getinfo($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        elseif (trim($response) == "") {
            return "Reponse empty. " . json_encode($info);
        }
        else {
            return $response;
        }
    }

    /*
     * DELETE with curl
     * Params: apiUrl - url request including get parameters
     *         key - authorization key
     */
    private function curlDelete($apiUrl, $key)
    {
        $curlHost = Mage::getStoreConfig('repiitsubscription/api/curl_host');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RESOLVE => ["repiitportalmanager.azurewebsites.net:443:65.52.130.1"],
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "authorization: $key",
                "Cache-Control: no-cache",
                "Accept: */*",
                "Accept-Encoding: gzip, deflate, sdch",
                "Accept-Language: en-US,en;q=0.8,ro;q=0.6,es;q=0.4,da;q=0.2",
                "User-Agent: " . $this->getNavigatorUserAgent(),
                "Content-Type: application/json",
                "Connection: keep-alive",
                "Host: $curlHost"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $info = curl_getinfo($curl);

        curl_close($curl);

        Mage::log($response);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        elseif (trim($response) == "") {
            return "Reponse empty. " . json_encode($info);
        }
        else {
            return $response;
        }
    }

    /*
     * PUT with curl
     * Params: apiUrl - url request including get parameters
     *          key - authorization key
     */

    protected function curlPut($apiUrl,$key, $jsonData)
    {
        $curlHost = Mage::getStoreConfig('repiitsubscription/api/curl_host');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RESOLVE => ["repiitportalmanager.azurewebsites.net:443:65.52.130.1"],
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                "authorization: $key",
                "Cache-Control: no-cache",
                "Accept: */*",
                "Accept-Encoding: gzip, deflate, sdch",
                "Accept-Language: en-US,en;q=0.8,ro;q=0.6,es;q=0.4,da;q=0.2",
                "User-Agent: " . $this->getNavigatorUserAgent(),
                "Content-Type: application/json",
                "Connection: keep-alive",
                "Host: $curlHost"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $info = curl_getinfo($curl);

        curl_close($curl);

        Mage::log($response);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        elseif (trim($response) == "") {
            return "Reponse empty. " . json_encode($info);
        }
        else {
            return $response;
        }
    }

    //get item by id
    /**
     * @param $apiUrl
     * @param $key
     * @param $itemId
     * @return string: json format|error message
     */
    public function getItemData($apiUrl, $key, $itemId)
    {
        //construct apiUrl = apiUrl /Item [/ItemId]
        $apiUrl = $apiUrl . "Item" . ((isset($itemId) && $itemId)?"/" .$itemId:"");

        $response = $this->curlGet($apiUrl, $key);

        return $response;
    }

    //post item
    /**
     * @param $postData
     * @return mixed|string
     */
    public function createItem($postData)
    {
        $helper = Mage::helper('Repiit_Subscription');
        $apiUrl = $this->getApiUrl() . "Item" . $helper->makeUrl($postData);

        Mage::log($apiUrl);

        $key = $this->getAuthorizationKey();

        Mage::log($key);

        $ret = $this->curlPost($apiUrl, $key);

        return $ret;
    }

    //get result for username
    /**
     *
     * @param string $username
     * @return string
     */
    public function getResultUsername($username)
    {
        $apiUrl = $this->getApiUrl() . "Login?username=" . rawurlencode($username);

        $result = $this->curlGet($apiUrl,'');

        return $result;
    }

}