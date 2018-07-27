<?php

class enrolmentor_helper {
    
    /**
     * __construct() HIDE: WE'RE STATIC
     */
    protected function __construct()
    {
        // static's only please!
    }
    
    /**
     * get_enrolled_employees($roleid, $userid) 
     * returns an array of user ids that resemble the userid's the user is enrolled in
     *
     */
    static public function get_enrolled_employees($roleid, $userid) {
        global $DB;

        $sql  = "SELECT c.instanceid
                FROM {context} AS c
                JOIN {role_assignments} AS ra ON ra.contextid = c.id
                WHERE ra.roleid = :roleid
                AND ra.userid = :userid
                AND c.contextlevel = :contextlevel";

        return array_keys($DB->get_records_sql($sql, array('roleid' => $roleid, 'userid' => $userid, 'contextlevel' => CONTEXT_USER)));
    }

    /**
     * get_list_empolyees($user, $username)
     * returns an array of user ids for which the $user is a parent
     */
    static public function get_list_employees($user, $username, $switch) {
        global $DB;

        switch($switch->compare) {
            case 'id':
            case 'idnumber':
            case 'username':
            case 'email':
                $data = $user->{$switch->compare};
                break;
            default:
                $data = @$user->profile[$switch->compare];
                break;
        }

        // don't compare empty values
        if (empty($data)) {
            return array();
        }

        $sql = "SELECT userid FROM {user_info_data} WHERE data = :data AND fieldid = :fieldid";
        return array_keys($DB->get_records_sql($sql, array('data' => $data, 'fieldid' => $switch->profile_field)));
    }
    
    /**
     * get_profile_fields(null);
     * returns an array of custom profile fields
     *
     */    
    static public function get_profile_fields($key = 'id') {
        global $DB;
        
        $fields = $DB->get_records_menu('user_info_field', null, null, $fields = "$key, name");

        return $fields;
    }
    
    /**
     * doEnrol($toEnrol);
     * returns an array of user ids that this user need to be enrolled in
     *
     */
    static public function doEnrol($toEnrol, $roleid, $user){
        foreach($toEnrol as $enrol) {
            role_assign($roleid, $user->id, context_user::instance($enrol)->id, '', 0, '');
        }
    }
    
    /**
     * doUnenrol($toUnenrol);
     * returns an array of user ids thad this user need to be unenrolled in
     *
     */
    static public function doUnenrol($toUnenrol, $roleid, $user){
        foreach($toUnenrol as $unenrol) {
            role_unassign($roleid, $user->id, context_user::instance($unenrol)->id, '', 0, '');
        }
    }    
}