<?php

namespace Fuel\Tasks;

/*

list.csvを置き以下実行

C:\xampp\epos>C:\xampp\php\php.exe oil refine import_csv


*/
class Import_csv
{
	private $_csv_file_path = './fuel/app/tasks/list.csv';

	public function run()
	{
		$csv_file_path = $this->_csv_file_path;
		if (!is_file($csv_file_path))
		{
			die("csv file not found.\n");
		}

		$columns = $this->_getColumns();

		$count = 0;
		// Shift_JIS で読み込み
		$fp = fopen($csv_file_path,"r");
		while($rows = fgetcsv($fp)){
			$count += 1;
			$insert = array();

			for($i=0;$i<count($rows);$i++){
				if (!array_key_exists($i, $columns)) continue;

				// UTF-8 に変換
				$data = mb_convert_encoding($rows[$i], 'utf-8', 'SJIS-win');

				//発表形式
				if($columns[$i] == "category") {
					$data = 'scientific';
				}

				//パスワード
				if($columns[$i] == "password") {
					$data = \Auth::instance('Subjectauth')->hash_password($data);
				}

				//会場
				if($columns[$i] == "place_id") {
					$data = $this->_getPlaceId($data);
				}

				//name
				if($columns[$i] == "presenter_name") {
					$d = explode(" ", $data);
					$insert['presenter_last_name'] = $d[0];
					$insert['presenter_first_name'] = $d[1];
					continue;
				}

				$insert[$columns[$i]] = $data;
			}

			$insert['sort'] = $count * 10;
			$insert['type_warter_mark'] = 0;
			$insert['not_warter_mark'] = 0;
			$insert['prize'] = 0;
			$insert['cancel'] = 0;
			$insert['created_at'] = date('Y-m-d H:i:s');
			$insert['updated_at'] = date('Y-m-d H:i:s');
			$insert['removed'] = 0;

			$this->_insert_subject($insert);
		}
		fclose($fp);

	}

	private function _getColumns()
	{
		$columns = array(
					0 => 'no',
					1 => 'category',
					2 => 'session_name',
					3 => 'title_ja',
					4 => 'present_start_time',
					5 => 'present_end_time',
					6 => 'present_date',
					7 => 'place_id',
					8 => 'belong_name',
					9 => 'presenter_name',
					10 => 'presenter_email',
					11 => 'password',
					12 => 'subject_no',
				);

		return $columns;
	}

	private function _insert_subject($input = array())
	{
		$model = \Model_Subject::forge($input);
		$model->save();
	}

	private function _getPlaceId($data)
	{
		$model = \Model_Place::find('first', array('where' => array(array('place_name', '=', $data), array('removed', '=', 0))));
		if($model) {
			return $model->id;
		}

		$input = array(
				'place_name' => $data,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
				'removed' => 0,
				);

		$model = \Model_Place::forge($input);
		$model->save();

		return $model->id;
	}

}
