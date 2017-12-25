<?php
namespace App\Utils;

/**
 * SchemaOrg : 
 * 
 * @category Awesomeness
 * @package  SchemaOrg
 * @author   euonymus
 * @license  euonymus
 * @version  1.0.0
 */
use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Log\Log;
class SchemaOrg
{
  public function __construct(array $token = array(), array $consumer = array())
  {
  }

  public static $schema_type = [
    '0'  => [
	     'type'        => 'Thing',
	     'name'        => 'name',
	     'image_path'  => 'image',
	     'description' => 'description',
	     'start'       => 'startDate',
	     'end'         => 'endDate',
	     'url'         => 'url',
	     ],
    '1'  => [
	     'type'        => 'Person',
	     'name'        => 'name',
	     'image_path'  => 'image',
	     'description' => 'description',
	     'start'       => 'birthdate',
	     'end'         => 'deathdate',
	     'url'         => 'url',
	     'gender'      => 'gender',
	     'gluons' => [
			  'nationality' => 'nationality',
			  'hasband'     => 'spouse',
			  'wife'        => 'spouse',
			  'father'      => 'parent',
			  'mother'      => 'parent',
			  'sibling',
			  'children',
			  'relatedTo',
			  'affiliation',
			  'alumniOf',
			  'worksFor',
			  'hasOccupation',
			  'colleague',
			  'memberOf',
			  'performerIn',
			  'owns',
			  'knows',
		    ],
	     'sections' => [
			  'nationality' => 'nationality',
			  'hasband'     => 'spouse',
			  'wife'        => 'spouse',
			  'father'      => 'parent',
			  'mother'      => 'parent',
			  'sibling',
			  'children',
			  'relatedTo',
			  'affiliation',
			  'alumniOf',
			  'worksFor',
			  'hasOccupation',
			  'colleague',
			  'memberOf',
			  'performerIn',
			  'owns',
			  'knows',
		    ],
	     ],
    '2'  => 'CreativeWork',
    '3'  => 'WebSite',
    '4'  => 'Book',
    '5'  => 'PublicationIssue',
    '6'  => 'Article',
    '7'  => 'SoftwareApplication',
    '8'  => 'Game',
    '9'  => 'Movie',
    '10' => 'Painting',
    '11' => 'Photograph',
    '12' => 'MusicPlaylist',
    '13' => 'MusicAlbum',
    '14' => 'MusicRecording',
    '15' => 'CreativeWorkSeries',
    '16' => 'Event',
    '17' => 'Intangible',
    '18' => 'Brand',
    '19' => 'BroadcastChannel',
    '20' => 'TelevisionChannel',
    '21' => 'Organization',
    '22' => 'Corporation',
    '23' => 'EducationalOrganization',
    '24' => 'CollegeOrUniversity',
    '25' => 'ElementarySchool',
    '26' => 'HighSchool',
    '27' => 'MiddleSchool',
    '28' => 'Preschool',
    '29' => 'School',
    '30' => 'GovernmentOrganization',
    '31' => 'LocalBusiness',
    '32' => 'Store',
    '33' => 'MedicalOrganization',
    '34' => 'Hospital',
    '35' => 'NGO',
    '36' => 'PerformingGroup',
    '37' => 'MusicGroup',
    '38' => 'SportsOrganization',
    '39' => 'SportsTeam',
    '40' => 'Place',
    '41' => 'Accommodation',
    '42' => 'AdministrativeArea',
    '43' => 'City',
    '44' => 'Country',
    '45' => 'State',
    '46' => 'CivicStructure',
    '47' => 'Landform',
    '48' => 'LandmarksOrHistoricalBuildings',
    '49' => 'Residence',
    '50' => 'TouristAttraction',
    '51' => 'Product',
  ];


/* name	◯ */
/* headline	 */
/* image	◯ */
/* description	◯ */
/* startDate	◯ */
/* birthdate	 */
/* dateCreated	 */
/* datePublished	 */
/* foundingDate	 */
/* releaseDate	 */
/* endDate	◯ */
/* deathdate	 */
/* expires	 */
/* dissolutionDate	 */
/* url	◯ */
	
/* nationality	 */
/* spouse	 */
/* parent	 */
/* sibling	 */
/* children	 */
/* relatedTo	 */
/* affiliation	 */
/* alumniOf	 */
/* worksFor	 */
/* hasOccupation	 */
/* colleague	 */
/* memberOf	 */
/* performerIn	 */
/* owns	 */
/* knows	 */
/* creator	 */
/* author	 */
/* contributor	 */
/* publisher	 */
/* producer	 */
/* character	 */
/* director	 */
/* actor	 */
/* musicBy	 */
/* productionCompany	 */
/* track	 */
/* byArtist	 */
/* inAlbum	 */
/* attendee	 */
/* organizer	 */
/* location	 */
/* performer	 */
/* alumni	 */
/* brand	 */
/* department	 */
/* employee	 */
/* event	 */
/* founder	 */
/* member	 */
/* parentOrganization	 */
/* subOrganization	 */
/* album	 */
/* track	 */
/* sport	 */
/* athlete	 */
/* coach	 */
/* manufacturer	 */

}
