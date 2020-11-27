<?php

namespace Thoughtco\CustomerDisplay\Controllers;

use AdminMenu;
use Admin\Facades\AdminLocation;
use Admin\Models\Locations_model;
use Admin\Models\Orders_model;
use ApplicationException;
use Carbon\Carbon;
use Request;
use Template;
use Thoughtco\CustomerDisplay\Models\Settings;

/**
 * Order Summary
 */
class Summary extends \Admin\Classes\AdminController
{

    protected $requiredPermissions = 'Thoughtco.CustomerDisplay.*';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('sales', 'summary');
        Template::setTitle(lang('lang:thoughtco.customerdisplay::default.text_title'));

    }

    public function index()
    {
	    // add CSS and JS
	    $this->addCSS('extensions/thoughtco/customerdisplay/assets/css/cds.css', 'thoughtco-cds');
	    $this->addJS('extensions/thoughtco/customerdisplay/assets/js/cds.js', 'thoughtco-cds');
	}

	public function getParams(){

	    $locations = $this->getLocations();

	    $locationParam = Request::get('location', array_keys($locations)[0]);

	    return [$locationParam];

    }

	public function getLocations()
    {

    	if ($this->locations) return $this->locations;

    	$locations = [];

    	foreach (Locations_model::get() as $l){

			if (AdminLocation::getId() === NULL || AdminLocation::getId() == $l->location_id){

				if ($l->location_status){

					$locations[$l->location_id] = $l->location_name;

				}
			}

    	}

    	$this->locations = $locations;

    	return $locations;

    }

    public function renderResults()
    {

	    // to allow us to pass in use()
	    [$locationParam] = $this->getParams();

	    $locations = $this->getLocations();

	    // get our location
	    $selectedLocation = false;
	    foreach ($locations as $i=>$l){
		    if ($i == $locationParam){
			    $selectedLocation = Locations_model::where('location_id', $i)->first();
		    }
	    }

	    if ($selectedLocation === false) return '<br /><h2>Location not found</h2>';

		// get our first and last processing statuses
		$prepStatus = Settings::get('prep_status');
		$prepColor = Settings::get('prep_color');
		$readyStatus = Settings::get('ready_status');
		$readyColor = Settings::get('ready_color');

	    // get orders for the day requested
	    $getOrders = Orders_model::where(function($query) use ($selectedLocation, $prepStatus, $readyStatus){
		    $query
				->whereIn('status_id', [$prepStatus, $readyStatus]);

		    //if (AdminLocation::getId() !== NULL){
		    	$query->where('location_id', $selectedLocation->location_id);
		    //}
		})
		->orderBy('order_date', 'asc')
		->orderBy('order_time', 'asc')
		->limit(30)
		->get();

		$outputRunning = [];

	    foreach ($getOrders as $o){
			$outputRunning[] = (object)[
				'id' => $o->order_id,
				'time' => $o->order_time,
				'name' => $o->first_name,
				'status' => $o->status_id == $prepStatus ? 'prepared' : 'ready',
				'status_color' => $o->status_id == $prepStatus ? $prepColor : $readyColor,
			];
		}

		return $outputRunning;

    }

}
