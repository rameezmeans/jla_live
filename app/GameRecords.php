<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GameRecords extends Model
{
    protected $table = 'game_records';
    protected $fillable = ['gp', 'gb', 'shots', 'spct', 'sog', 'sogpct', 'fo', 'fopct', 'game_id', 'team_id', 'opponent_id', 'is_published'];


    /**
	 * Get excerpt from string
	 * 
	 * @param String $str String to get an excerpt from
	 * @param Integer $startPos Position int string to start excerpt from
	 * @param Integer $maxLength Maximum length the excerpt may be
	 * @return String excerpt
	 */
	public static function getExcerpt($str, $startPos = 0, $maxLength = 50) {
		if(strlen($str) > $maxLength) {
			$excerpt   = substr($str, $startPos, $maxLength - 6);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt   = substr($excerpt, 0, $lastSpace);
			$excerpt  .= ' [...]';
		} else {
			$excerpt = $str;
		}
		
		return $excerpt;
	}
}