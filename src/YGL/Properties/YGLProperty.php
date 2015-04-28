<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:37 PM
 */

namespace YGL\Properties;


use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Leads\Collection\YGLLeadCollection;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLProperty extends YGLJsonObject
{
    protected $uniqueId = 'propertyId';

    public function __construct($values = null, YGLClient $client = null)
    {

        $this->_properties = array(
            'propertyId'=> self::integerProperty(),
            'name'      => self::stringProperty(255),
            'address1'  => self::stringProperty(),
            'address2'  => self::stringProperty(),
            'city'      => self::stringProperty(255),
            'region'    => self::stringProperty(40),
            'state'     => self::stringProperty(10),
            'zip'       => self::stringProperty(30),
            'division'  => self::stringProperty(40),
            'country'   => self::stringProperty(2),
            'updatedBy' => self::stringProperty(10),
            'updatedOn' => self::datetimeProperty()
        );

        parent::__construct((array)$values, $client);
    }

  /**
   * @param null                               $id
   * @param int                                $limit
   * @param int                                $page
   * @param \ODataQuery\ODataResourceInterface $query
   * @return bool|mixed|\YGL\Response\YGLResponse|\YGL\Leads\Collection\YGLLeadCollection
   */
    public function getLeads($id = null, $limit = 20, $page = 0,
      ODataResourceInterface $query = null)
    {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->getLeads($this, $id, $limit, $page, $query);
        }

        return false;
    }

  /**
   * @param \YGL\Leads\YGLLead $lead
   * @return null|\YGL\Response\YGLResponse|\YGL\Leads\YGLLead
   */
    public function addLead(YGLLead $lead)
    {
        $lead->setProperty($this);
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->addLead($this, $lead);
        }

        return null;
    }

  /**
   * @param \YGL\Leads\Collection\YGLLeadCollection $leads
   * @return null|\YGL\Response\YGLResponse|\YGL\Leads\Collection\YGLLeadCollection
   */
    public function addLeads(YGLLeadCollection $leads)
    {
        $leads->setProperty($this);
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->addLeads($this, $leads);
        }

        return null;
    }

  /**
   * @param \ODataQuery\ODataResourceInterface $query
   * @return bool|mixed|\YGL\Response\YGLResponse|\YGL\Tasks\Collection\YGLTaskCollection
   */
    public function getTasks(ODataResourceInterface $query = null)
    {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->getTasks($this, $query);
        }

        return false;
    }

  /**
   * @param null                               $id
   * @param \ODataQuery\ODataResourceInterface $query
   * @return bool|mixed|\YGL\Response\YGLResponse|\YGL\Users\Collection\YGLUsersCollection
   */
    public function getUsers($id = null, ODataResourceInterface $query = null)
    {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->getUsers($this, $id, $query);
        }

        return false;
    }

  /**
   * @param null                               $id
   * @param \ODataQuery\ODataResourceInterface $query
   * @return bool|mixed|\YGL\Response\YGLResponse|\YGL\ReferralSource\Collection\YGLReferralSourceCollection
   */
    public function getReferralSources($id = null, ODataResourceInterface $query = null) {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
          return $client->getReferralSources($this, $id, $query);
        }

        return false;
    }
} 