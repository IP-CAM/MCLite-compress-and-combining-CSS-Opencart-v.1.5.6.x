<?php 
/**
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
class ModelMcliteSetting extends Model {
	public function getSetting($group, $store_id = 0) {
		$data = array(); 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}
		return $data;
	}
	
	public function saveCache($cache){
		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($cache) . "' WHERE  `". DB_PREFIX ."setting`.`key` = 'mclite_cache_list'");
	}

	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	
	public function deleteSetting($group, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	}
	
	public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UDPATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . " WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UDPATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($value)) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "', serialized = '1'");
		}
	}
	// Функция оптимизации БД
	public function optimizeTables(){
		$link = null;
		if (!$link = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)) {
      		trigger_error('Error: Could not make a database link using ' . DB_USERNAME . '@' . DB_HOSTNAME);
		}else{
			mysql_select_db(DB_DATABASE);
			$alltables = mysql_query("SHOW TABLES", $link);

			while ($table = mysql_fetch_assoc($alltables)){
				foreach ($table as $db => $tablename){
					$row = array();
					$mysql_result = mysql_fetch_array( mysql_query("OPTIMIZE TABLE `".$tablename."`", $link) );
					$row['name'] 	= $mysql_result['Table'];
					$row['result'] 	= $mysql_result['Msg_text'];
					$result[] = $row;
					unset($row);
				}
			}
			mysql_close($link);
			return $result;
		}
	}
}
?>