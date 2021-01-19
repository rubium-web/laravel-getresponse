<?php

namespace Rubium\Getresponse;

use Getresponse\Sdk\GetresponseClientFactory;
use Getresponse\Sdk\Operation\Campaigns\GetCampaigns\GetCampaigns;
use Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact;
use Getresponse\Sdk\Operation\Contacts\DeleteContact\DeleteContact;
use Getresponse\Sdk\Operation\Contacts\GetContact\GetContact;
use Getresponse\Sdk\Operation\Contacts\GetContact\GetContactFields;
use Getresponse\Sdk\Operation\Contacts\GetContacts\GetContacts;
use Getresponse\Sdk\Operation\Contacts\GetContacts\GetContactsSearchQuery;
use Getresponse\Sdk\Operation\Model\CampaignReference;
use Getresponse\Sdk\Operation\Model\NewContact;

class Getresponse
{
    // Build your next great package.
    private $config;
    /**
     * @var \Getresponse\Sdk\Client\GetresponseClient
     */
    private $client;

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = GetresponseClientFactory::createWithApiKey($this->config['api_key']);
    }

    public function deleteContact($code)
    {
        try {
            $deleteContact = new DeleteContact($code);

            $response = $this->client->call($deleteContact);
            $arData = $response->isSuccess();
        }catch (\Exception $exception) {
            throw $exception;
        }
        return $arData;
    }

    public function setContact($campaignId, $email)
    {
        try {
            $newContact = new NewContact(new CampaignReference($campaignId), $email);
            $createContact = new CreateContact($newContact);

            $response = $this->client->call($createContact);
            $arData = $response->isSuccess();
        }catch (\Exception $exception) {
            throw $exception;
        }
        return $arData;
    }

    public function getContacts($arWhere = [])
    {
        try {
            $getContactsOperation = new GetContacts();
            foreach ($arWhere as $sWhereKey => $sWhereValue) {
                switch ($sWhereKey) {
                    case 'email':
                        $searchQuery = new GetContactsSearchQuery();
                        $searchQuery->whereEmail($sWhereValue);
                        $getContactsOperation->setQuery($searchQuery);
                        break;
                    case 'campaign_id':
                        $searchQuery = new GetContactsSearchQuery();
                        $searchQuery->whereCampaignId($sWhereValue);
                        $getContactsOperation->setQuery($searchQuery);
                        break;
                }
            }

            $response = $this->client->call($getContactsOperation);
            if ($response->getResponse()->getStatusCode() != 200) {
                $sReasonPhrase = $response->getResponse()->getReasonPhrase();
                $iStatusCode = $response->getResponse()->getStatusCode();
                throw new \Exception($sReasonPhrase, $iStatusCode);
            }
            $arData = $response->getData();
        }catch (\Exception $exception) {
            throw $exception;
        }
        return $arData;
    }

    /**
     * @return array
     * @throws \Getresponse\Sdk\Client\Exception\MalformedResponseDataException
     */
    public function getCampaigns()
    {
        try {
            $campaignsOperation = new GetCampaigns();
            $response = $this->client->call($campaignsOperation);
            if ($response->getResponse()->getStatusCode() != 200) {
                $sReasonPhrase = $response->getResponse()->getReasonPhrase();
                $iStatusCode = $response->getResponse()->getStatusCode();
                throw new \Exception($sReasonPhrase, $iStatusCode);
            }
            $arData = $response->getData();
        }catch (\Exception $exception) {
            throw $exception;
        }
        return $arData;
    }
}
