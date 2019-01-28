<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace jazmy\FormBuilder\Services;

class RolesProvider
{
	/**
	 * Return the array of roles in the format
	 *
	 * [
	 * 	 1 => 'Role Name',
	 * ]
	 * @return array
	 */
    public function __invoke() : array
    {
    	return [
    		1 => 'Default',
    	];
    }
}
