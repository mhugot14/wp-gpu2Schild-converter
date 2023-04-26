<?php
namespace untisSchildConverter;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


class LoeschFaecherHandler{

	private $loeschFaecher = array();
	private $tabellenname;
	private $wpdb;
	
	
	public function __construct(){
		global $wpdb;
		$this->wpdb=$wpdb;
		$this->tabellenname = $this->wpdb->prefix.'usc_loesch_faecher';
	}
	 
	
	public function loeschFaecherToDb($loeschFaecher){
		
		
		$timestamp = time();
		$date = date("Y-m-d H:i:s", $timestamp);

		
		try{
			$this->wpdb->query("TRUNCATE TABLE ".$this->tabellenname.';');
		} catch (Exception $ex) {
			echo "Die Tabelle konnte nicht geleert werden: ".$ex;
		}
		try{
			foreach($loeschFaecher as $row){
				$this->wpdb->insert(
				$this->tabellenname,
					
					array(
						'fach_untis' => $row['fach_untis'],
						'fach_schild' => $row['fach_schild'],
						'klasse' => $row['klasse'],
						'bemerkung' => $row['bemerkung'],
						'importdatum' => $date
					
					)
				);
			}
		} catch (Exception $ex) {
			echo "Die Faecher konnten nicht gespeichert werden: ".$ex;
		}
		
	}
	
	public function loeschFaecherAnzeigen(){
		
		$resultSet=$this->wpdb->get_results('SELECT * FROM '.$this->tabellenname.';');
		
			echo '<p>Anzahl Datensätze in der Datenbanktabelle: <b>'.count($resultSet).'</b>.</p>';
		if (count($resultSet)){
		 ?>
		<table class="wp-list-table sortable fixed striped table-view-list pages">
			<thead>
				<tr>
					<th>id</th><!-- comment -->
					<th>Fach Untis</th>
					<th>Fach Schild</th>
					<th>Klasse</th>
					<th>Bemerkung</th>
					<th>Importdatum</th>
				</tr>	
			</thead>
			<tbody>
			<?php
			
			foreach ( $resultSet as $row ) {
				echo "<tr>";
				echo "<td>" .$row->id  . "</td>";
				echo "<td>" .$row->fach_untis . "</td>";
				echo "<td>" .$row->fach_schild . "</td>";
				echo "<td>" .$row->klasse . "</td>";
				echo "<td>" .$row->bemerkung . "</td>";
				echo "<td>" .$row->importdatum . "</td>";
				echo "</tr>";
			}
			echo "</tbody></table>";
			
			echo "<h3>Und jetzt zum schnellen kopieren bei Neuanlage</h3> <p>";
				foreach ( $resultSet as $row ) {
					echo $row->fach_untis.",".$row->fach_schild.",".$row->klasse.",".$row->bemerkung."<br/>";
				}
			echo "</p>";

		}
		else{
			echo "Es sind keine Datensätze vorhanden.";
		}
			
	
	}
	
	
}