<?php 

class w2dc_locations_controller extends w2dc_frontend_controller {

	public function init($args = array()) {
		global $w2dc_instance;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'parent' => 0,
				'depth' => 1,
				'columns' => 2,
				'count' => 1,
				'hide_empty' => 0,
				'sublocations' => 0,
				'locations' => array(),
		), $args);
		$this->args = $shortcode_atts;

		if ($this->args['custom_home']) {
			if ($w2dc_instance->getShortcodeProperty('webdirectory', 'is_location')) {
				$location = $w2dc_instance->getShortcodeProperty('webdirectory', 'location');
				$this->args['parent'] = $location->term_id;
			}

			$this->args['depth'] = w2dc_getValue($args, 'depth', get_option('w2dc_locations_nesting_level'));
			$this->args['columns'] = w2dc_getValue($args, 'columns', get_option('w2dc_locations_columns'));
			$this->args['count'] = w2dc_getValue($args, 'count', get_option('w2dc_show_location_count'));
			$this->args['hide_empty'] = w2dc_getValue($args, 'hide_empty', get_option('w2dc_hide_empty_categories'));
			$this->args['sublocations'] = w2dc_getValue($args, 'subcats', get_option('w2dc_sublocations_items'));
			if ($w2dc_instance->current_directory->locations)
				$this->args['locations'] = implode(',', $w2dc_instance->current_directory->locations);
		}
		if (isset($this->args['locations']) && !is_array($this->args['locations']))
			if ($locations = array_filter(explode(',', $this->args['locations']), 'trim'))
				$this->args['locations'] = $locations;

		apply_filters('w2dc_locations_controller_construct', $this);
	}

	public function display() {
		global $w2dc_instance;
		
		ob_start();
		
		if ($this->args['custom_home'] && $w2dc_instance->getShortcodeProperty('webdirectory', 'is_location') && !get_option('w2dc_show_locations_index')) {
			w2dc_renderAllLocations($this->args['parent'], 1, $this->args['columns'], $this->args['count'], $this->args['sublocations'], $this->args['locations'], $this->args['hide_empty']);
		} else
			w2dc_renderAllLocations($this->args['parent'], $this->args['depth'], $this->args['columns'], $this->args['count'], $this->args['sublocations'], $this->args['locations'], $this->args['hide_empty']);
		
		$output = ob_get_clean();

		return $output;
	}
}

?>