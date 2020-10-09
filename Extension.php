<?php 

namespace Thoughtco\CustomerDisplay;

use DB;
use Event;
use Admin\Widgets\Form;
use System\Classes\BaseExtension;
use Thoughtco\CustomerDisplay\Models\Settings;
/**
 * Extension Information File
**/
class Extension extends BaseExtension
{
    public function boot()
    {
        
	    // write default settings to database if missing
	    if (Settings::get('prep_status') === NULL){
			Settings::set([
				'prep_status' => 2,
				'prep_color' => '#DDCC2C',
				'ready_status' => 3,
				'ready_color' => '#12D42B',
			]);
	    }
	    	    	    
    }
    
    public function registerPermissions()
    {
        return [
            'Thoughtco.CustomerDisplay.View' => [
                'description' => 'View orders ready to be collected by customers',
                'group' => 'module',
            ],
        ];
    }
    
    public function registerNavigation()
    {
        return [
            'sales' => [
                'child' => [
                    'customerdisplay' => [
                        'priority' => 10,
                        'class' => 'pages',
                        'href' => admin_url('thoughtco/customerdisplay/summary'),
                        'title' => lang('lang:thoughtco.customerdisplay::default.text_title'),
                        'permission' => 'Thoughtco.CustomerDisplay.View',
                    ],
                ],
            ],
        ];
    } 
    
	public function registerSettings()
	{
	    return [
	        'settings' => [
	            'label' => 'Customer Display Settings',
                'icon' => 'fa fa-users',
	            'description' => 'Manage customer display settings.',
                'model' => 'Thoughtco\CustomerDisplay\Models\Settings',
	            'permissions' => ['Thoughtco.CustomerDisplay.Manage'],
	        ],
	    ];
	}

}

?>
