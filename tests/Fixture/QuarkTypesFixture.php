<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QuarkTypesFixture
 *
 */
class QuarkTypesFixture extends TestFixture
{

    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'quark_types'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'name' => 'Thing',
            'image_path' => '/img/no_image.jpg',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 1,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 2,
            'name' => 'Person',
            'image_path' => '/img/person.png',
            'name_prop' => 'name',
            'start_prop' => 'birthDate',
            'end_prop' => 'deathDate',
            'has_gender' => 1,
            'sort' => 2,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 3,
            'name' => 'CreativeWork',
            'image_path' => '/img/creative_work.png',
            'name_prop' => 'name',
            'start_prop' => 'dateCreated',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 37,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 4,
            'name' => 'WebSite',
            'image_path' => '/img/web_site.png',
            'name_prop' => 'name',
            'start_prop' => 'dateCreated',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 13,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 5,
            'name' => 'Book',
            'image_path' => '/img/book.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 7,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 6,
            'name' => 'PublicationIssue',
            'image_path' => '/img/publication_issue.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 38,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 7,
            'name' => 'Article',
            'image_path' => '/img/article.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 39,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 8,
            'name' => 'SoftwareApplication',
            'image_path' => '/img/software_application.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 12,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 9,
            'name' => 'Game',
            'image_path' => '/img/game.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 11,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 10,
            'name' => 'Movie',
            'image_path' => '/img/movie.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'expires',
            'has_gender' => 0,
            'sort' => 6,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 11,
            'name' => 'Painting',
            'image_path' => '/img/painting.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 41,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 12,
            'name' => 'Photograph',
            'image_path' => '/img/photograph.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 40,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 13,
            'name' => 'MusicPlaylist',
            'image_path' => '/img/music_playlist.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 42,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 14,
            'name' => 'MusicAlbum',
            'image_path' => '/img/music_album.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 9,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 15,
            'name' => 'MusicRecording',
            'image_path' => '/img/music_recording.png',
            'name_prop' => 'name',
            'start_prop' => 'datePublished',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 10,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 16,
            'name' => 'CreativeWorkSeries',
            'image_path' => '/img/creative_work_series.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 14,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 17,
            'name' => 'Event',
            'image_path' => '/img/event.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 17,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 18,
            'name' => 'Intangible',
            'image_path' => '/img/intangible.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 18,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 19,
            'name' => 'Brand',
            'image_path' => '/img/brand.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 35,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 20,
            'name' => 'BroadcastChannel',
            'image_path' => '/img/broadcast_channel.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 27,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 21,
            'name' => 'TelevisionChannel',
            'image_path' => '/img/television_channel.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 28,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 22,
            'name' => 'Organization',
            'image_path' => '/img/organization.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 19,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 23,
            'name' => 'Corporation',
            'image_path' => '/img/corporation.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 3,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 24,
            'name' => 'EducationalOrganization',
            'image_path' => '/img/educational_organization.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 29,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 25,
            'name' => 'CollegeOrUniversity',
            'image_path' => '/img/college_or_university.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 4,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 26,
            'name' => 'ElementarySchool',
            'image_path' => '/img/elementary_school.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 25,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 27,
            'name' => 'HighSchool',
            'image_path' => '/img/high_school.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 23,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 28,
            'name' => 'MiddleSchool',
            'image_path' => '/img/middle_school.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 24,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 29,
            'name' => 'Preschool',
            'image_path' => '/img/preschool.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 26,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 30,
            'name' => 'School',
            'image_path' => '/img/school.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 22,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 31,
            'name' => 'GovernmentOrganization',
            'image_path' => '/img/government_organization.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 5,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 32,
            'name' => 'LocalBusiness',
            'image_path' => '/img/local_business.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 30,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 33,
            'name' => 'Store',
            'image_path' => '/img/store.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 31,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 34,
            'name' => 'MedicalOrganization',
            'image_path' => '/img/medical_organization.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 21,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 35,
            'name' => 'Hospital',
            'image_path' => '/img/hospital.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 15,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 36,
            'name' => 'NGO',
            'image_path' => '/img/ngo.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 20,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 37,
            'name' => 'PerformingGroup',
            'image_path' => '/img/performing_group.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 34,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 38,
            'name' => 'MusicGroup',
            'image_path' => '/img/music_group.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 8,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 39,
            'name' => 'SportsOrganization',
            'image_path' => '/img/sports_organization.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 32,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 40,
            'name' => 'SportsTeam',
            'image_path' => '/img/sports_team.png',
            'name_prop' => 'name',
            'start_prop' => 'foundingDate',
            'end_prop' => 'dissolutionDate',
            'has_gender' => 0,
            'sort' => 33,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 41,
            'name' => 'Place',
            'image_path' => '/img/place.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 43,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 42,
            'name' => 'Accommodation',
            'image_path' => '/img/accommodation.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 44,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 43,
            'name' => 'AdministrativeArea',
            'image_path' => '/img/administrative_area.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 45,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 44,
            'name' => 'City',
            'image_path' => '/img/city.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 46,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 45,
            'name' => 'Country',
            'image_path' => '/img/country.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 47,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 46,
            'name' => 'State',
            'image_path' => '/img/state.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 48,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 47,
            'name' => 'CivicStructure',
            'image_path' => '/img/civic_structure.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 49,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 48,
            'name' => 'Landform',
            'image_path' => '/img/landform.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 50,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 49,
            'name' => 'LandmarksOrHistoricalBuildings',
            'image_path' => '/img/landmarks_or_historical_buildings.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 16,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 50,
            'name' => 'Residence',
            'image_path' => '/img/residence.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 51,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 51,
            'name' => 'TouristAttrcaction',
            'image_path' => '/img/tourist_attraction.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 52,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 52,
            'name' => 'Product',
            'image_path' => '/img/product.png',
            'name_prop' => 'name',
            'start_prop' => 'startDate',
            'end_prop' => 'endDate',
            'has_gender' => 0,
            'sort' => 36,
            'created' => null,
            'modified' => null
        ],
    ];
}
