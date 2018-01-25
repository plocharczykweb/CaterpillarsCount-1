<?php

require_once('../api/Site.php');

class SiteTest extends PHPUnit_Framework_TestCase
{
	/*
		This function will test the getPlantComposition when the siteID passed as 
		a parameter is not an ID stored in the database
		@covers	\api\Site.php::getPlantComposition($siteID)
	*/
	public function testGetPlantCompositionIDNotFound(){
		$IDNotPresent = -1;
		$APIresponse = Site::getPlantComposition($IDNotPresent);
		$expectedResponse = -1;
		$this->assertEquals($expectedResponse, $APIresponse);
	}
	
	/*
		This function will test the getArthropodComposition when the siteID passed as
		a parameter is not an ID stored in the database
		@covers \api\Site.php::getArthropodComposition($siteID)
	*/
	public function testGetArthropodCompositionIDNotFound(){
		$IDNotPresent = -1;
		$response = Site::getArthropodComposition($IDNotPresent);
		$expectedResponse = -1;
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getSiteStatistics function when the siteID passed as 
		a parameter is not an ID stored in the database
		@covers \api\Site.php::getSiteStatistics($siteID)
	*/
	public function testGetStatisticsIDNotFound(){
		$IDNotPresent = -1;
		$response = Site::getSiteStatistics($IDNotPresent);
		$expectedResponse = -1;
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getPlantComposition when the siteID passed as a parameter 
		is present in the database, but that site contains no surveys to compute a plant 
		composition.
		@covers \api\Site.php::getPlantComposition($siteID)
	*/
	public function testGetPlantCompositionNoResults(){
		$emptyID = 8892352;
		$response = Site::getPlantComposition($emptyID);
		$expectedResponse = -1;
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getArthropod when the siteID passed as a parameter 
		is present in the database, but that site contains no surveys to compute an arthropod 
		composition.
		@covers \api\Site.php::getArthropodComposition($siteID)
	*/
	public function testGetArthropodCompositionNoResults(){
		$emptyID = 8892352;
		$response = Site::getArthropodComposition($emptyID);
		$expectedResponse = -1;
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getSiteStatistics function when the siteID passed as a 
		parameter is present in the database, but that site contains no surveys.
		@covers \api\Site.php::getSiteStatistics($siteID)
	*/
	public function testGetStatisticsNoResults(){
		$emptyID = 8892352;
		$response = Site::getSiteStatistics($emptyID);
		$expectedResponse = '{"siteName":"testRaul","siteDescription":"Testing site","countSurveys":0,"countUsers":0,"countArthropods":0}';
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getArthropodComposition function when the siteID passed as a 
		parameter is present in the database, and the site contains several surveys.
		@covers \api\Site.php::getArthropodComposition($siteID)
	*/
	public function testGetArthropodCompositionNormal(){
		$siteID = 8892346;
		$response = Site::getArthropodComposition($siteID);
		$expectedResponse = '{"Ants (Formicidae)":1,"Beetles (Coleoptera)":2,"Caterpillars (Lepidoptera larvae)":1,"Flies (Diptera)":3,"Leaf hoppers and Cicadas (Auchenorrhyncha)":4,"Spiders (Araneae)":9,"Other":1}';
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getPlantComposition function when the siteID passed as a 
		parameter is present in the database, and the site contains several surveys.
		@covers \api\Site.php::getPlantComposition($siteID)
	*/
	public function testGetPlantCompositionNormal(){
		$siteID = 8892346;
		$response = Site::getPlantComposition($siteID);
		$expectedResponse = '{"Sweet birch":5,"Striped maple":3}';
		$this->assertEquals($expectedResponse, $response);
	}
	
	/*
		This function will test the getSiteStatistics function when the siteID passed as a 
		parameter is present in the database, and the site contains several surveys.
		@covers \api\Site.php::getSiteStatistics($siteID)
	*/
	public function testGetStatisticsNormal(){
		$siteID = 8892346;
		$result = Site::getSiteStatistics($siteID);
		$expectedResponse = '{"siteName":"Site 8892346","siteDescription":"","countSurveys":8,"countUsers":1,"countArthropods":7}';
		$this->assertEquals($expectedResponse, $result);
	}
	
	/*
		This function will test the nullTester function when no values are passed, so the function 
		will assign default ones.
		@covers \api\Site.php::nullTester($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testNullTesterNoValues(){
		$result = Site::nullTester(null, null, null, null, null);
		$this->assertEquals($result['siteName'], '%');
		$this->assertEquals($result['minObservations'], 0);
		$this->assertEquals($result['startDate'], '2010-00-00');
		$this->assertEquals($result['endDate'], date('Y-m-d'));
		$this->assertEquals($result['arthropodOrder'], '%');
	}
	
	/*
		This function will test the nullTester function when values are passed as parameters, so the 
		function won't assign default ones.
		@covers \api\Site.php::nullTester($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testNullTesterWithValues(){
		$result = Site::nullTester('Site 8892346', 5, '2012-02-02', '2014-04-04', 'Ants (Formicidae)');
		$this->assertEquals($result['siteName'], 'Site 8892346');
		$this->assertEquals($result['minObservations'], 5);
		$this->assertEquals($result['startDate'], '2012-02-02');
		$this->assertEquals($result['endDate'], '2014-04-04');
		$this->assertEquals($result['arthropodOrder'], 'Ants (Formicidae)');
	}
	
	/*
		This function will test the filteredSites function when the user sends the name of the site to be filteredSites
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesName(){
		$result = Site::getFilteredSites('Site 2704111', null, null, null, null);
		$this->assertEquals($result, '[{"siteName":"Site 2704111","siteID":2704111,"siteLat":34.9052,"siteLong":-83.4784}]');
	}
	
	/*
		This function will test the filteredSites service when the user asks for a name that is not present in the database
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesNameNotFound(){
		$result = Site::getFilteredSites('SiteNotFound', null, null, null, null);
		$this->assertEquals(-1, $result);
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have surveys submitted 
		in 2010.
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSites2010(){
		$result = Site::getFilteredSites(null, null, '2010-01-01', '2010-12-31', null);
		$this->assertEquals(30, count(json_decode($result)));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have surveys submitted 
		in 2011.
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSites2011(){
		$result = Site::getFilteredSites(null, null, '2011-01-01', '2011-12-31', null);
		$this->assertEquals(14, count(json_decode($result)));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have surveys submitted 
		between 2013 and 2015. No sites should be returned.
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSites20132015(){
		$result = Site::getFilteredSites(null, null, '2013-01-01', '2015-12-31', null);
		$this->assertEquals(-1, json_decode($result));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have surveys submitted 
		in 2010 between January and May.
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesJanMay(){
		$result = Site::getFilteredSites(null, null, '2010-01-01', '2010-05-31', null);
		$this->assertEquals(12, count(json_decode($result)));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have no observations
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesNoObservations(){
		$result = Site::getFilteredSites(null, 0, null, null, null);
		$this->assertEquals(36, count(json_decode($result)));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have a normal-high number of observations
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesHighObservations(){
		$result = Site::getFilteredSites(null, 50, null, null, null);
		$this->assertEquals(20, count(json_decode($result)));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have too many observations (no sites will 
		be returned)
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesTooManyObservations(){
		$result = Site::getFilteredSites(null, 250, null, null, null);
		$this->assertEquals(-1, json_decode($result));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have surveys with caterpillars
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesArthropod(){
		$result = Site::getFilteredSites(null, null, null, null, 'Caterpillars (Lepidoptera larvae)');
		$this->assertEquals(34, count(json_decode($result)));
	}
	
	/*
		This function will test the filteredSites service when the user asks for the sites that have an arthropod order not present 
		in the database
		@covers \api\Site.php::getFilteredSites($siteName, $minObservations, $startDate, $endDate, $arthropodOrder)
	*/
	public function testFilterSitesArthropodNotFound(){
		$result = Site::getFilteredSites(null, null, null, null, 'ArthropodNotFound');
		$this->assertEquals(-1, json_decode($result));
	}
}