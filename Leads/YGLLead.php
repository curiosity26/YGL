<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:49 PM
 */

namespace YGL\Leads;


use YGL\YGLJsonObject;

class YGLLead extends YGLJsonObject {

    public function __construct(array $values = NULL) {
        $this->_properties = array(
            'leadId'            =>  self::integerProperty(),
            'contactId'         =>  self::integerProperty(),
            'secondaryContactId'=>  self::integerProperty(),
            'addedOn'           =>  self::datetimeProperty(),
            'associate'         =>  self::stringProperty(45),
            'budgetMin'         =>  self::integerProperty(),
            'budgetMax'         =>  self::integerProperty(),
            'callCenterId'      =>  self::stringProperty(),
            'dischargePlannerId'=>  self::integerProperty(),
            'familyStatusId'    =>  self::integerProperty(),
            'fundingType'       =>  self::integerProperty(),
            'inquiryMethod'     =>  self::stringProperty(30),
            'leadResident'      =>  self::residentProperty(),
            'notes'             =>  self::notesProperty(),
            'ownership'         =>  self::stringProperty(1),
            'primaryContact'    =>  self::contactProperty(),
            'priority'          =>  self::integerProperty(),
            'referralSources'   =>  self::referralSourceCollectionProperty(),
            'residentContact'   =>  self::contactProperty(),
            'secondaryContact'  =>  self::contactProperty(),
            'secondFundingType' =>  self::integerProperty(),
            'userName'          =>  self::stringProperty(10),
            'veteran'           =>  self::stringProperty(1)
        );

        parent::__construct($values);
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['leadId']['value'];
        }

        return parent::__get($name);
    }
} 