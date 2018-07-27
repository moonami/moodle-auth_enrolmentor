<?php
/**
 * Auto enrol mentors, parents or managers based on a custom profile field.
 *
 * @package    auth
 * @subpackage enrolmentor
 * @copyright  2013 Virgil Ashruf (v.ashruf@avetica.nl)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2018072700;
$plugin->requires  = 2012110900;
$plugin->component = 'auth_enrolmentor';
$plugin->maturity = MATURITY_STABLE;
$plugin->release = '1.1';