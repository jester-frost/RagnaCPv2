<?php

/**
* @fileoverview characterhead.php, display character's head (only)
* @author Vincent Thibault (alias KeyWorld - Twitter: @robrowser)
* @version 1.0.0
*/


// Avoid direct access
defined("__ROOT__") OR die();


// Include Render class
require_once(  __ROOT__ . 'render/class.CharacterHeadRender.php' );



class CharacterHead_Controller extends Controller {

	/**
	 * Load database, specify where to cache things
	 */
	public function __construct()
	{
		parent::loadDatabase();
		Cache::setNamespace('characterhead');
	}


	/**
	 * Process entry
	 */
	public function process($pseudo)
	{
		header('Content-type:image/png');
		header('Cache-Control: max-age='. Cache::$time .', public');

		Cache::setFilename($pseudo . ".png");
		$content    = "";

		// Load the cache file ?
		if( Cache::get($content) ) {
			die( $content );
		}

		// Find and render
		$data = $this->getPlayerData($pseudo);
		$this->render($data);

		// Cache
		Cache::save();
	}


	/**
	 * Get player data from SQL
	 */
	private function getPlayerData($pseudo)
	{
		$data = $this->query("
			SELECT
				char.hair, char.hair_color,
				char.head_top, char.head_mid, char.head_bottom,
				char.sex
			FROM `char`
			LEFT JOIN `login` ON login.account_id = char.account_id
			WHERE char.name = ?
			LIMIT 1",
			array($pseudo)
		);

		// No character found ? Load a default character ?
		if( empty($data) ) {

			// Store file, not needed to recalculate it each time
			Cache::setFilename("[notfound].png");
			$content    = "";

			if( Cache::get($content) ) {
				die($content);
			}

			return array(
				"class"         =>  0,
				"clothes_color" =>  0,
				"hair"          =>  2,
				"hair_color"    =>  0,
				"head_top"      =>  0,
				"head_mid"      =>  0,
				"head_bottom"   =>  0,
				"robe"          =>  0,
				"weapon"        =>  0,
				"shield"        =>  0,
				"sex"           => "M"
			);
		}

		return $data[0];
	}


	/**
	 * Render avatar
	 */
	private function render($data)
	{
		// Load Sprites and set parameters
		$chargen                 =  new CharacterHeadRender();
		$chargen->direction      =  CharacterHeadRender::DIRECTION_SOUTH;
		$chargen->doridori       =  2;

		// Doram Heads
		$doran_heads = array(
			1 => 31,
			2 => 32,
			3 => 33,
			4 => 34,
			5 => 35,
			6 => 36,
		);
		// Human Heads
		$human_heads= array(
			     1  => 1, 
			     2  => 2, 
			     3  => 3, 
			     4  => 4, 
			     5  => 5, 
			     6  => 6, 
			     7  => 7, 
			     8  => 8, 
			     9  => 9, 
			     10  => 10, 
			     11  => 11, 
			     12  => 12, 
			     13  => 13, 
			     14  => 14, 
			     15  => 15, 
			     16  => 16, 
			     17  => 17, 
			     18  => 18, 
			     19  => 19, 
			     20  => 20, 
			     21  => 21, 
			     22  => 22, 
			     23  => 23, 
			     24  => 24, 
			     25  => 25, 
			     26  => 26, 
			     27  => 27, 
			     28  => 28, 
			     29  => 29, 
			     30  => 30, 
			     31  => 85, 
			     32  => 86, 
			     33  => 87, 
			     34  => 88, 
			     35  => 89, 
			     36  => 90, 
			     37  => 37, 
			     38  => 38, 
			     39  => 39, 
			     40  => 40, 
			     41  => 41, 
			     42  => 42, 
			     43  => 43, 
			     44  => 44, 
			     45  => 45, 
			     46  => 46, 
			     47  => 47, 
			     48  => 48, 
			     49  => 49, 
			     50  => 50, 
			     51  => 51, 
			     52  => 52, 
			     53  => 53, 
			     54  => 54, 
			     55  => 55, 
			     56  => 56, 
			     57  => 57, 
			     58  => 58, 
			     59  => 59, 
			     60  => 60, 
			     61  => 61, 
			     62  => 62, 
			     63  => 63, 
			     64  => 64, 
			     65  => 65, 
			     66  => 66, 
			     67  => 67, 
			     68  => 68, 
			     69  => 69, 
			     70  => 70, 
			     71  => 71, 
			     72  => 72, 
			     73  => 73, 
			     74  => 74, 
			     75  => 75, 
			     76  => 76, 
			     77  => 77, 
			     78  => 78,
			     79  => 79,
			     80  => 80,
			     81  => 81,
			     82  => 82,
			     83  => 83,
			     84  => 84,
		); 
		if( $data['class'] == 4218 || $data['class'] == 4220 ){
			$data['hair'] = $doran_heads[$data['hair']];
		}else{
			$data['hair'] = $human_heads[$data['hair']];
		}


		// Generate Image
		$chargen->loadFromSqlData($data);
		$img  = $chargen->render();

		imagepng($img);
	}

}
