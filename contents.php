<?php
class nmt_contents
{
	// properties defined here
	protected $_link;
	protected $_parts;
	protected $_conn;
	protected $_myID;
	
	//constructor
	public function __construct($link, $parts, $conn) {
		$this->_link = $link;
		$this->_parts = $parts;
		$this->_conn = $conn;
		$this->_myID = $_SESSION['id'];
	}
	
	// methods defined here
	public function main()
	{
		foreach($this->_parts as $k=>$val){ // SCHEDULES
			if($k == "calMonth")
			$calMonth = $val;
			
			if($k == "status")
			$status = $val;
			
			if($k == "sequence")
			$seq = $val;
			
			if($k == "dutyType")
			$dutyType = $val;
			
			if($k == "group")
			$group = $val;
			
			if($k == "pageType")
			$pageType = $val;
			
			if($k == "editPage")
			$editPage = $val;
			
			if($k == "editIndex")
			$editPage = $val;
			
			if($k == "newSpex")
			$newSpex = $val;
			
			if($k == "currentShifts")
			$currentShifts = $val;
			
			if($k == "guideSelectSpexId")
			$spId = $val;
			
			if($k == "choose")
			$choose = $val;
			
			if($k == "hourType")
			$hourType = $val;
			
			if($k == "order")
			$order = $val;
			
			if($k == "select")
			$select = $val;
			
			if($k == "command")
			$command = $val;
			
			if($k == "viewPostsFor")
			$viewPostsFor = $val;
			
			if($k == "newTopic")
			$newTopic = $val;
			
			if($k == "item")
			$item = $val;
			
			if($k == "url")
			$url = $val;
			
			if($k == "id")
			$id = $val;
			
			if($k == "eventName")
			$eventName = urldecode($val);

			if($k == "newLink")
			$newLink = $val;
			
			if($k == "view")
			$viewLink = $val;
			
			if($k == "page")
			$page = $val;

			if($k == "viewTrip")
			$tripID = $val;
			
			if($k == "editTrip")
			$tripID = $val;
			
			if($k == "viewPicsFor")
			$tripID = $val;
			
			if($k == "signup")
			$tripID = $val;
			
			if($k == "tripID")
			$tripID = $val;
			
			if($k == "sorter")
			$sorter = $val;
			
			if($k == "flag")
			$prefix = $val;
			
			if($k == "reminder")
			$reminder = $val;
		}
		
		$content = "";
		switch($this->_link)
		{
			case "home.php":
				$content = $this->home($editPage);
			break;
			case "duties.php":
				$content = $this->duties($seq,$dutyType);
			break;
			case "matrix.php":
				$content = $this->matrix($prefix);
			break;
			case "calendario2.php":
				$content = $this->calendario2();
			break;
			case "adminCal.php":
				$content = $this->adminCal($calMonth, $status, $prefix);
			break;
			case "adminPubCal.php":
				if(isset($_SESSION['adminid'])){ $content = $this->adminPubCal($calMonth,$status, $prefix); }
				if(isset($_SESSION['userid'])){ $content = $this->userLCal($calMonth,$status, $prefix); }
			break;
			case "archive.php":
				$content = $this->archive();
			break;
			case "userCal.php":
				$content = $this->userLCal($calMonth, $status, $prefix);
			break;
			case "userLCal.php":
				$content = $this->userLCal($calMonth, $status, $prefix);
			break;
			case "eAlert.php":
				$content = $this->eAlert($reminder, $group);
			break;
			case "adminHours.php":
				if(isset($_SESSION['adminid'])){ $content = $this->adminHours($choose); }
				if(isset($_SESSION['userid'])){ $content = $this->myHours($choose, $hourType); }
			break;
			case "myHours.php":
				$content = $this->myHours($choose, $hourType);
			break;
			case "adminDirectory.php":
				if(isset($_SESSION['adminid'])){ $content = $this->adminDirectory($choose, $order); }
				if(isset($_SESSION['userid'])){ $content = $this->userDirectory($choose, $order); }
			break;
			case "directory.php":
				$content = $this->userDirectory($choose, $order);
			break;
			case "editProfile.php":
				$content = $this->editProfile();
			break;
			case "communications.php":
				$content = $this->communication($select, $command, $viewPostsFor);
			break;
			case "adminContEd.php":
				if(isset($_SESSION['adminid'])){ $content = $this->adminContEd($newTopic, $item); }
				if(isset($_SESSION['userid'])){ $content = $this->contEd($item); }
			break;
			case "contEd.php":
				$content = $this->contEd($item);
			break;
			case "adminEvents.php":
				$content = $this->events($prefix);
			break;
			case "events.php":
				$content = $this->events($prefix);
			break;
			case "signUp.php":
				$content = $this->signUp($id, $eventName, $sorter, $prefix);
			break;
			case "eventCalendarAdmin.php":
				$content = $this->eventCalendar();
			break;			
			case "eventCalendar.php":
				$content = $this->eventCalendar();
			break;
			case "signUpCal.php":
				$content = $this->signUpCal($id, $eventName, $sorter);
			break;
			case "adminTrips.php":
				if(isset($_SESSION['adminid'])){ $content = $this->adminTrips($tripID, $sorter); }
				if(isset($_SESSION['userid'])){ $content = $this->trips($tripID, $sorter); }
			break;
			case "trips.php":
				$content = $this->trips($tripID, $sorter);
			break;
			case "vvUpload.php":
				$content = $this->adminNewsletter($url);
			break;
			case "newsletter.php":
				$content = $this->adminNewsletter($url);
			break;
			case "editor.php":
				if(isset($_SESSION['adminid'])){ $content = $this->editor($newLink, $viewLink); }
				if(isset($_SESSION['userid'])){ $page = $newLink; $content = $this->pages($page); }
			break;
			case "pages.php":
				$content = $this->pages($page);
			break;
			case "print.php":
				$content = $this->printing($calMonth, $pageType, $printDir, $prefix);
			break;
			case "index.php":
				$content = $this->index();
			break;
			default:
				$content = $this->index();
			break;
		}
		return $content;
	}
	
	protected function index() //==================== INDEX
	{
		$content = "";
		
		if(isset($_SESSION['device'])){ // 					SHOW LOGIN PAGE IN MOBILE
			$content .= '<div id="indexPage">';
			$content .= '<img src="img/small/logo_m.png" alt="'.LOGO_ALT.'" border="0" />'; 
			if(file_exists('homeTxt/index.txt')){
				$content .= '<div style="text-align:center;">';
				$content .= htmlspecialchars_decode(file_get_contents('homeTxt/index.txt')); // GET AND SHOW HOME PAGE COPY
			}
			$content .= '</div></div>';
		}else{											// SHOW LOGIN PAGE IN DESKTOP
				if(defined('BODYCAPTION'))
				{
					$content .= '<div id="indexPage">';
					$content .= '<div id="hpTextInner">';
					if(file_exists('homeTxt/index.txt')){
						$content .= htmlspecialchars_decode(file_get_contents('homeTxt/index.txt')); // GET AND SHOW HOME PAGE COPY
					}
					$content .= '</div></div>';
				}
		}
		return $content;
	}
	
	protected function home($editPage) //==================== HOME
	{
		$content = "";
		$content .= '<div id="hpText"><div id="hpTextInner">';
		
		if(file_exists('homeTxt/home.txt')){
			$hpText = htmlspecialchars_decode(file_get_contents('homeTxt/home.txt')); // GET AND SHOW HOME PAGE COPY
		}

		if(isset($_SESSION['adminid'])){
			if(isset($editPage)){
				$copyFile = $editPage.'.txt'; //		EDIT HOME OR INDEX PAGE
				if(file_exists('homeTxt/'.$copyFile)){
					$editText = htmlspecialchars_decode(file_get_contents('homeTxt/'.$copyFile)); // GET AND SHOW HOME PAGE COPY
				}
				$content .= '<form method=post action="home.php" name="form1">';
				$content .= '<input type="hidden" name="homePageQualifier" value="'.$editPage.'">';
				$content .= '<p><textarea id="homePagePost" name="homePagePost" class="extendable">'.$editText.'</textarea></p>';
				$content .= '<p><input type="submit" value="SAVE" name=send" id=send" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
				$content .= '&nbsp;<a href="home.php" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">CANCEL</a></p></form>';
			}else{
				$content .= '<span class="editHome"><a href="home.php?editPage=home">[edit this page]</a>&nbsp;&nbsp;&nbsp;<a href="home.php?editPage=index">[edit login page]</a></p>';
				$content .=  htmlspecialchars_decode($hpText);
			}
		}
		if(isset($_SESSION['userid'])){
			$content .=  htmlspecialchars_decode($hpText);
		}
		$content .= '</div></div>';
		
		return $content;
	}
	
	protected function eAlert($reminder,$group) //==================== EDIT EMAIL WARNING FOR UPCOMING SHIFT
	{
		$content = "";
		$content .= '<div id="limited">';
		if($reminder == "email")
		{
			if(file_exists('custom/duty_reminder/'.$group.'.txt')){
				$eAlert = htmlspecialchars_decode(file_get_contents('custom/duty_reminder/'.$group.'.txt'));
			}
			$content .= '<form method=post action="eAlert.php" name="form1">';
			$content .= '<input type="hidden" name="group" value="'.$group.'">';
			$content .= '<textarea id="eAlertBody" name="eAlertBody" style="width:96%;height:auto;">'.$eAlert.'</textarea>';
			$content .= '<br /><input type="submit" value="SAVE" name=send" id=send" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
			$content .= '&nbsp;<a href="home.php" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">CANCEL</a></form>';
		}
		if($reminder == "dues")
		{
			if(file_exists('custom/dues/duesGreen.txt')){
				$duesGreen = htmlspecialchars_decode(file_get_contents('custom/dues/duesGreen.txt'));
			}
			$content .= '<p>Friendly reminder: appears between early payment date and final deadline</p>';
			$content .= '<form method=post action="eAlert.php" name="form1">';
			$content .= '<textarea id="duesGreenBody" name="duesGreenBody" style="width:96%;height:auto;">'.$duesGreen.'</textarea>';
			$content .= '<br /><input type="submit" value="SAVE" name=send" id=send" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
			$content .= '&nbsp;<a href="home.php" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">CANCEL</a></form>';
			
			if(file_exists('custom/dues/duesRed.txt')){
				$duesRed = htmlspecialchars_decode(file_get_contents('custom/dues/duesRed.txt'));
			}
			$content .= '<p>Final reminder: appears after final deadline</p>';
			$content .= '<form method=post action="eAlert.php" name="form1">';
			$content .= '<textarea id="duesRedBody" name="duesRedBody" style="width:96%;height:auto;">'.$duesRed.'</textarea>';
			$content .= '<br /><input type="submit" value="SAVE" name=send" id=send" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
			$content .= '&nbsp;<a href="home.php" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">CANCEL</a></form>';
		}
		$content .= '</div>';
		
		return $content;
	}
	
	protected function duties($seq, $dutyType) //==================== DUTIES
	{
		$content = "";
		if(isset($seq)){ //--------------------------------------------------- show edit sequence
			$duties = getAll("SELECT * FROM duties WHERE $dutyType = 1 order by seq asc", $this->_conn); 
			$content .= '<div id="limited">';
			$content .= '<table id="schedule" class="limited">';
			$content .= '<form action="duties.php" method="post" target="_self">';
			$content .= '<input name="dutyType" type="hidden" value="'.$dutyType.'">';
				for($i = 0; $i < count($duties); $i++){
					$content .= '<input name="newSeq['.$i.'][id]" type="hidden" value="'.$duties[$i]['id'].'">';
					$content .= '<tr><td colspan="7"><input name="newSeq['.$i.'][theseq]" type="text" value="'.$duties[$i]['seq'].'" size="2">&nbsp;'.$duties[$i]['dutyName'].'</td></tr>';
	
				}
				$content .= '<tr><td colspan="7"><input type="submit" value="SAVE" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></form>&nbsp;or <a href="duties.php?dutyType='.$dutyType.'" target="_self">CANCEL</a></td></tr>';
				$content .= '</table></div>';
		}	
		//--------------------------- end edit sequence
		else //							DISPLAY ITEMS
		{
			$duties = getAll("SELECT * FROM duties WHERE $dutyType = 1 order by seq asc", $this->_conn); //		show the list of duties
			$dutyTypeName = get1("SELECT volunteerType FROM volunteerType WHERE shortName = '$dutyType'", $this->_conn); //		show the list of duties
			$content .= '<div id="limited">';
			$content .=  '<table id="schedule" class="limited">';
			$content .=  '<tbody>';
			if(!empty($dutyTypeName)){
				$content .=  '<tr><td colspan="3">'.$dutyTypeName.' duties:</td></tr>';
			}else{
				$content .=  '<tr><td colspan="3">'.NONCREDITHOURS.' duties:</td></tr>';
			}
			for($i = 0; $i < count($duties); $i++){
				$content .=  '<tr><td>&nbsp;'.$duties[$i]['seq'].'</td>
				<td><a class="showEdit" id="'.$duties[$i]['id'].'_'.$dutyType.'" href="#" target="_self">&nbsp;'.$duties[$i]['dutyName'].'</a></td>';
				$content .=  '<td><a href="duties.php?deleteme='.$duties[$i]['id'].'&dutyType='.$dutyType.'" target="_self" 
				onclick="return confirm(\'WARNING: any data bound with this schedule item will become unretrievable upon deletion!\')">&#10008;</a></td></tr>';
			}
			$content .= '</table></div>';
		}
		return $content;
	}
	
	protected function matrix($prefix) //==================== MATRIX - MAKE A PREFILLED SCHEDULE
	{
		$content = "";
		$content .= '<table class="duties">';

		$guides = getAll("SELECT * FROM guides as g, vol_types as v WHERE v.guideID = g.guide_id AND v.type = '$prefix' ORDER BY g.lname, g.fname", $this->_conn);  //-------- show the requested list
		$shifts = getAll("SELECT id, dutyName FROM duties where $prefix = 1 order by seq asc", $this->_conn); //-------- get all duties
		$days = Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"); //--------array of days
		$weeks = Array("1", "2", "3", "4", "5", "6"); //--------array of weeks

		$content .= '<form action="matrix.php" method="post">';  //----------- begin form to add docents to public tours - fixed menu
		$content .= '<input type="hidden" name="flag" value="'.$prefix.'">';
		if(!isset($_SESSION['device'])){
		$content .= '<tr>'; // ------------------------ header with days names
		$content .= '<td class="small"></td>';
			foreach ($days as $k => $day) {	
				$content .= '<td>'.$day.'</td>';
			}
		$content .= '</tr>';
		}
		foreach ($weeks as $k => $val) { //----------- week level	
			$content .= '<tr>';
			$content .= '<td class="small">Week&nbsp;'.$val.'</td>'; 
			if(isset($_SESSION['device'])){ $content .= '</tr>'; } 
				foreach ($days as $key => $day) { //----------- day level
					//---------------------------------------------------- add new name-duty
					$content .= '<td>';
					$content .= '<input name="selectedGuide['.$val.$key.'][wk]" type="hidden" value="'.$val.'" />';
					$content .= '<input name="selectedGuide['.$val.$key.'][day]" type="hidden" value="'.$day.'" />';
					if(isset($_SESSION['device'])){ $content .= '<p style="color:red;">'.$day.'</p>'; } //--------- write day if mobile
					$content .= '<select name="selectedGuide['.$val.$key.'][shift]" class="small">';
						$content .=  '<option value="">Duty</option>';
						for($i = 0; $i < count($shifts); $i++) {
							$shiftNome = $shifts[$i]['dutyName'];
							$content .=  '<option value="'.$shiftNome.'">'.$shiftNome.'</option>';  //-------- duties
						}
						$content .= '</select>';
					$content .= '<select name="selectedGuide['.$val.$key.'][guide]" class="small">';
						$content .=  '<option value="">Docent</option>';
						for($i = 0; $i < count($guides); $i++) {
							$id = $guides[$i]['guide_id'];
							$content .=  '<option value="'.$id.'">'.$guides[$i]['fname'].' '.$guides[$i]['lname'].'</option>';  //-------- docents 
						}
						$content .= '</select>';
				
				//----------------------------------- display previously selected docents
					$scheduled = getAll("SELECT sm.* FROM scheduleMatrix AS sm, duties AS d WHERE sm.scheduleType = '$prefix'AND sm.wk = '$val' AND sm.day = '$day' AND sm.shift = d.dutyName ORDER BY d.seq", $this->_conn); // get current list of selected docents
					if(!empty($scheduled)){
						foreach($scheduled as $k => $value) {
							$guideID = $value['docentID'];
							$dutyName = $value['shift'];
							$scheduleMatrixID = $value['id'];
							$docentNome = get1("SELECT CONCAT_WS(' ', fname, lname) FROM guides where guide_id = '$guideID'", $this->_conn);
							$content .=  '<p id="'.$scheduleMatrixID.'"><span class="dutyBlue">'.$dutyName.'</span><br />'.$docentNome.' <a href="#" class="zapp" id="'.$scheduleMatrixID.'" title="delete">x</a></p>'; 
						}
					}
					if(isset($_SESSION['device'])){ $content .= '</td></tr>'; }
				}  //----------- end day level
				if(!isset($_SESSION['device'])){ 
				$content .= '</td>';
			$content .= '</tr>'; 
			}
		} //----------- end week level

		$content .= '<tr><td colspan="8"><input type="submit" value="SAVE" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></td></tr></form></table>';	
		
		return $content;
	}
	
	protected function calendario2() //==================== CALENDARIO2
	{
		$content = ""; 
		$content .= '<table class="duties">';
		if($_POST['month'] && $_POST['year']){
		if($_POST['prefix']){ $prefix = $_POST['prefix']; }	 
			 $month = $this->monthName($_POST['month']);
			 $year = $_POST['year'];
			 $doppioNome = $prefix.$month.$year;
			 $start = mktime (1, 0, 0, $_POST['month'], 1, $_POST['year']);
			 $firstDayArray = getdate($start);
			 
			 //----------- check for duplicates
			 $checkForDupes = get1("SELECT name FROM monthyear where name = '$doppioNome'", $this->_conn);
				if(!empty($checkForDupes)){
					$content .=  '<SCRIPT>alert ("The '.ucfirst($month).' '.$year.' calendar already exists.");</SCRIPT>';
					return $content;
					exit;
				}
			$content .= '<tr><td colspan="7">';
			$content .= '<form action="calendario2.php" method="post" target="_self">
			<input name="mese" type="hidden" value="'.$month.'">
			<input name="anno" type="hidden" value="'.$year.'">
			<input name="monNum" type="hidden" value="'.$_POST['month'].'">';
			if(!empty($prefix)){ $content .= '<input name="prefix" type="hidden" value="'.$prefix.'">'; }
			// IF SETTINGS ALLOW IT, SHOW OPTION TO CREATE A FILLED SCHEDULE (DUTIES AND NAMES)
			if(defined('CREATEFILLCAL')){
				$content .= '<input type="submit" value="create a standard '.$month.' '.$year.' calendar" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
				// IS THERE A DIGIT IN THE FLAG/PREFIX?
				if (!preg_match('#[0-9]#',$prefix)){
					$content .= '  or'.SPACER.'<a class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';" href="calendario_prefilled.php?mese='.$_POST['month'].'&anno='.$year.'&flag='.$prefix.'" target="_self">
					create a prefilled '.$month.' '.$year.' calendar</a>';
				}
			}else{
				$content .= '<input type="submit" value="create '.$month.' '.$year.' calendar" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
			}
			$content .= '</form></td></tr></table>';
		}
		return $content;
	} // end calendario
	
	protected function adminCal($calMonth, $status,$prefix) //==================== ADMIN CAL
	{
		if($_POST['calMonth']){ $calMonth = $_POST['calMonth']; }
		
		$content = "";
		$content .= '<table class="duties">';
		if(!empty($calMonth)) //------- specific month selected
		{ 
			$blabber = get1("SELECT blabla FROM monthyear where name = '$calMonth'", $this->_conn);
			$blabla = htmlspecialchars_decode($blabber);
			$content .= '<form action="adminCal.php" method="post">'; // FORM FOR BLABLA CONTENT
			$content .= '<input name="calMonth" value="'.$calMonth.'" type="hidden">';
			$content .= '<input name="flag" value="'.$prefix.'" type="hidden">';
			$content .= '<input name="editBlabla" value="theBlabla" type="hidden">';
			$content .= '<tr><td colspan="7"><textarea name="blabla" class="blabla">'.$blabla.'</textarea><br />';
			$content .= '<input type="submit" class="btn" value="update"></td></tr></form>';
			
			//----------------------------------------------- begin loops

			$cls = new nmt_scheduleDisplay($this->_conn, $calMonth, $status);  
			$val = $cls->main("adminCal", $prefix, 0);
			$content .=  $val;
			
			//$content .= '<tr><td colspan="7"><input type="submit" value="SUBMIT" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></form></td></tr>';
		} //------- end specific month display
		//$content .= '</table>';
		return $content;
	}
	
	protected function adminPubCal($calMonth, $status, $prefix) //==================== ADMINPUBCAL
	{
		if($_POST['calMonth']){ $calMonth = $_POST['calMonth']; $status = $_POST['status']; } // CALMONTH AND STATUS FROM POST
		$content = "";
		$content .= '<table class="duties">';
		if(!empty($calMonth)){ //------- specific month selected
		$blabber = get1("SELECT blabla FROM monthyear where name = '$calMonth'", $this->_conn);
		$blabla = htmlspecialchars_decode($blabber);
		$content .= '<form action="adminPubCal.php" method="post">';
		$content .= '<input name="calMonth" value="'.$calMonth.'" type="hidden">';
		$content .= '<input name="flag" value="'.$prefix.'" type="hidden">';
		$content .= '<input name="status" value="'.$status.'" type="hidden">';
		$content .= '<input name="editBlabla" value="theBlabla" type="hidden">';
		$content .= '<tr><td colspan="7"><textarea name="blabla" class="blabla">'.$blabla.'</textarea><br />';
		$content .= '<input type="submit" class="btn" value="update"></td></tr></form>';

		//----------------------------------------------- begin loops

		$cls = new nmt_scheduleDisplay($this->_conn, $calMonth, $status);  
		$val = $cls->main("adminPubCal", $prefix, 0);
		$content .=  $val;

		} //------- end specific month display

		return $content;
	}
	
	protected function archive() //==================== ARCHIVE
	{
		$content = "";
		$content .= '<div id="limited">';
		$content .= '<TABLE class="limited">';
		$content .= '<tr><td COLSPAN="3"><a href="archive.php?new=1">ARCHIVE A SCHEDULE</a></td></tr>';			
		if($_GET['new']){ //------------------------------ADD A NEW PDF TO FTP
		$content .=  '<FORM ENCTYPE="multipart/form-data" ACTION="archive.php" METHOD="POST">
		<INPUT TYPE="hidden" NAME="uploader" value="ok">
		<tr><td colspan="3">
			Select file: 
			<INPUT TYPE="FILE" NAME="new_pic">
			<INPUT TYPE="SUBMIT" class="btn" VALUE="Upload File">
			<INPUT TYPE="RESET" VALUE="Reset">
			</td></tr></FORM>';
		}
		$archives = getAll("SELECT * FROM archive ORDER BY seq ASC", $this->_conn);  
		
		 //------------------------------------------------- SHOW THE PDF LIST
		if(!empty($archives)){
			$content .= '<form action="archive.php" method="POST" name="reorder">';
			for($i = 0; $i < count($archives); $i++){
				$nome = $archives[$i]['filename'];
				$content .= '<INPUT TYPE="hidden" NAME="sequence['.$i.'][filename]" value="'.$archives[$i]['filename'].'">';
				$content .= '<tr id="'.$archives[$i]['id'].'">';
				$content .= '<td><INPUT TYPE="text" NAME="sequence['.$i.'][seq]" value="'.$archives[$i]['seq'].'" size="3"></td>';
				$content .= '<td><a href="schedule_archive/'.$nome.'" target="_blank">'.$nome.'</a></td>';
				$content .= '<td><a href="#" class="delete" id="'.$archives[$i]['id'].'">&#10008;</a></td></tr>';
			}
			$content .= '<tr><td COLSPAN="3"><input type="submit" value="RE-ORDER SEQUENCE" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></TD></tr>';
			$content .= '</form>';
		}
		$content .= '</table></div>';
		return $content;
	}
	
	protected function userLCal($calMonth, $status, $prefix) //==================== USERLCAL 
	{
		$content = "";
		//echo'<table class="duties">';
		if(!empty($calMonth)) //------- specific month selected
		{
			$blabber = get1("SELECT blabla FROM monthyear where name = '$calMonth'", $this->_conn);
			$blabla = nl2br(htmlspecialchars_decode($blabber));
			//--------------------------------------------------------------------------------- bla bla textarea
			if(!empty($blabla)){ $content .= '<p style="padding:1em;font-size:.9em;background:white;margin:0;">'.$blabla.'</p>'; }
			if($status == 1){ $linkName = "userCal"; }
			if($status == 2){ $linkName = "userLCal"; }
			
			$cls = new nmt_scheduleDisplay($this->_conn, $calMonth, $status);  
			$val = $cls->main($linkName,$prefix,0);
			$content .= $val;
		
			//$content .='<tr><td colspan="7">';
			//$content .='<input type="submit" value="SUBMIT" name="saveChoices" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></td></tr>';
		}
		//$content .= '</table></form>';
		return $content;
	}
	
	protected function adminHours($choose) //==================== ADMIN HOURS
	{
		$content = "";
			$cls = new nmt_hours($this->_conn);
			$val = $cls->showAdminHoursContent($choose);
			$content .=  $val;
		return $content;
	}
	
	protected function myHours($choose, $hourType) //====================  HOURS REPORTING
	{
		$content = "";
			
			if($_POST['choose']){ $choose = $_POST['choose']; }
			$cls = new nmt_hours($this->_conn);
			$val = $cls->showHoursContent($choose, $hourType);
			$content .=  $val;
		return $content;
	}
	
	protected function adminDirectory($choose, $order) //==================== ADMINDIRECTORY
	{
		$content = "";
		
		$guides = getAll("SELECT * FROM guides as g, vol_types as v WHERE v.guideID = g.guide_id AND v.type = '$choose' ORDER BY g.lname, g.fname", $this->_conn);  //-------- show the requested list
		
		if(!empty($choose)){
			if(defined('SENIORITY')){
				if($order == "old"){
					$guides = $this->subval_sort($guides,'seniority'); 
				}
			}
				//--------------------------------------------------------------------------------- display docents
				$cls = new nmt_directory($this->_conn);
				$val = $cls->showDirectoryContent($choose, $guides);
				$content .=  $val;
		}
		return $content;
	}
	
	protected function userDirectory($choose,$order) //==================== USERDIRECTORY
	{
		$guides = getAll("SELECT * FROM guides as g, vol_types as v WHERE v.guideID = g.guide_id AND v.type = '$choose' ORDER BY g.lname, g.fname", $this->_conn); //-------- show the requested list
		$content = "";
		if(!empty($choose)){
			if($order == "old"){
				$guides = $this->subval_sort($guides,'seniority'); 
			}
			$content .= '<table class="duties">';
				//--------------------------------------------------------------------------------- display calendar
				$cls = new nmt_directory($this->_conn);
				$val = $cls->showUserDirectoryContent($choose, $guides);
				$content .=  $val;

			$content .= '</table>';
		}
		return $content;
	}
	
	protected function editProfile() //==================== EDITPROFILE
	{
		//------------------------------------------------------ Get personal data from DATABASE

		if(isset($_SESSION['id'])){ $user = $_SESSION['id']; }
		if(defined('RENEW_BY'))
		{
			$now = time();
			$recordedYear =  get1("SELECT `renewDate` FROM guides WHERE guide_id = '$user'", $this->_conn); // takes recorded renewal year (ie: 2014)
			$nextRenewDateYear = $recordedYear + 1; //														 ... and ups it by 1 (ex: 2014 to 2015)
			$nextRenewDate = strtotime(RENEW_BY.$nextRenewDateYear); //										 next deadline for dues date
			$noticeTime = $nextRenewDate - RENEWAL_WARNING; //												 minus warning period
		}
		$row = getRow("SELECT * FROM guides WHERE guide_id = '$user'", $this->_conn);  
		$id = $row[0];
		$content = "";
		if(isset($_SESSION['device'])){ $content .= '<div id="limited">'; }
		if(defined('RENEW_BY') && isset($_SESSION['userid']))
		{
			if($now > $nextRenewDate ){ //---------- if we are past that date give option to pay
				$content .= '<div style="background:#f8e296;text-align:center;line-height:1.25;margin-top:0;padding:.5em;"><a style="font-size:1.25em;color:red;" href="'.GATEWAY_URL.'" target="_blank" title="Click here to go to '.GATEWAY.'">FEES OVERDUE</a><br />';
				if(file_exists('custom/dues/duesRed.txt')){
					$content .= htmlspecialchars_decode(file_get_contents('custom/dues/duesRed.txt'));
				}
				$content .= '</div>';
			}
			else if($now > $noticeTime && $now < $nextRenewDate){ //--------------- one month prior to due date, show the link to paypal
				$content .= '<div style="background:#f8e296;text-align:center;line-height:1.25;margin-top:0;padding:.5em;"><a style="font-size:1.25em; color:green;" href="'.GATEWAY_URL.'" target="_blank" title="Click here to go to '.GATEWAY.'">PAY DUES</a><br />';
				if(file_exists('custom/dues/duesGreen.txt')){
					$content .= htmlspecialchars_decode(file_get_contents('custom/dues/duesGreen.txt'));
				}
				$content .= '</div>';
			}
			else{
				$content .= '';
			}
		}
		$content .= '<table class="profile">';
		$content .= '<tr><th>';
			if(file_exists('docentPics/'.$id.'.jpg')) { //------------------------------------------ photo
				$content .= '<a href="#" class="changePic" id="'.$id.'"><IMG SRC="docentPics/'.$id.'.jpg" width="120" height="120" border="0" /></a>';
			}else{
				$content .= '<a href="#" class="changePic" id="'.$id.'"><IMG SRC="docentPics/docent.jpg" width="120" height="120" border="0" /></a>';
			}
			$content .= '</th>';
			if(!isset($_SESSION['device'])){ // IF NOT ON MOBILE, CAN CHANGE PIC
				$content .= '<td><span class="uploadPic" id="'.$id.'">
					<FORM ENCTYPE="multipart/form-data" ACTION="editProfile.php" METHOD="POST" name="uploader">
					<INPUT TYPE="hidden" NAME="editMyPic" value="'.$id.'.jpg">
					<INPUT TYPE="FILE" NAME="new_pic">
					<input type="submit" value="UPLOAD" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></FORM></span>';
				$content .= '<span class="uploadPicNote">Click on the picture to update<br />(max size 200 x 200 px please)</span></td>';
			}
		$content .= '</tr>';	
		$content .= '<form method=post action="editProfile.php">';
		$content .= '<input type="hidden" name="id" value="'.$id.'">'; 
		$content .= '<input type="hidden" name="email" value="'.$row[9].'">'; 
		$content .= '<tr><th><label for="update[fname]">First</label></th><td><input type="text" class="txtBox" name="update[fname]" value="'.$row[1].'"></td></tr>'; 
		$content .= '<tr><th><label for="update[lname]">Last</label></th><td><input type="text" class="txtBox" name="update[lname]" value="'.$row[2].'"></td></tr>'; 
		$content .= '<tr><th><label for="update[address]">Address</label></th><td><input type="text" class="txtBox" name="update[address]" value="'.$row[3].'"></td></tr>';
		$content .= '<tr><th><label for="update[city]">City</label></th><td><input type="text" class="txtBox" name="update[city]" value="'.$row[4].'"></td></tr>';
		$content .= '<tr><th><label for="update[state]">State</label></th><td><input type="text" class="txtBox" name="update[state]" value="'.$row[5].'" maxlength="2"></td></tr>';
		$content .= '<tr><th><label for="update[zip]">Zip</label></th><td><input type="text" class="txtBox" name="update[zip]" value="'.$row[6].'" maxlength="10"></td></tr>'; 
		$content .= '<tr><th><label for="update[tel]">Tel.</label></th><td><input type="text" class="txtBox" name="update[tel]" value="'.$row[7].'"></td></tr>'; 
		
		$content .= '<tr><th><label for="update[mobile]">Mobile</label></th><td><input type="text" class="txtBox" name="update[mobile]" value="'.$row[8].'"></td></tr>'; 
		$content .= '<tr><th><label for="update[email]">Email</label></th><td><input type="text" class="txtBox" name="update[email]" value="'.$row[9].'"></td></tr>'; 
		$content .= '<tr><th><label for="update[pass]">New Passw.</label></th><td><input type="text" class="txtBox" name="update[pass]" value="" maxlength="12" placeholder="Letters and numbers please"></td></tr>'; 
		$content .= '<tr><th><input type="submit" value="UPDATE" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></th><td>&nbsp;or <a href="home.php" target="_self">CANCEL</a></td></tr>';
		$content .= '</form>';

		$content .= '<tr><th colspan="2"><img width="1" height="1" vspace="15" src="img/dot_clear.gif"></th></tr>';
		$content .= '</table>';
		if(isset($_SESSION['device'])){ $content .= '</div>'; }
		return $content;
	}
	
	protected function communication($select, $command, $viewPostsFor) //==================== COMMUNICATION
	{
		$content = "";
		if(isset($_SESSION['userid'])){ //-------- show user interface
			$qualifier = 'userid';
		}
		if(isset($_SESSION['adminid'])){ //-------- show admin interface
			$qualifier = 'adminid';
		}
		
		$cls = new nmt_communicator($_SESSION['id'], $_SESSION['name'], $qualifier, $this->_conn); //---- call in the class 
		$content .= '<a name="top" id="top"></a>';
		if($select){  
			switch($select){
				case "threads":
					$content .= '<div id="comm">';
							if(isset($_SESSION['adminid'])){
								$content .= '<p><a href="#" id="new">Start a new thread</a>&nbsp;&nbsp;'.SPACER;
								$content .= '<a href="communications.php?select=threads&command=moderate" id="moderate">Moderate posts</a>&nbsp;&nbsp;'.SPACER;
								$content .= '<a href="#" class="sanction" id="sanction">Impose moderation on a '.ucfirst(VOLUNTEER).'</a></p>';
							}
							$threads = $cls->main("threads", $viewPostsFor);  // SHOW THREADS
							$content .=  $threads;
							if(isset($viewPostsFor)){
								$posts = $cls->main("posts", $viewPostsFor);
								$content .=  $posts;
							}else if(isset($command)){
								$posts = $cls->main("moderate", 0); //			GET ALL POSTS THAT NEED MODERATION
								$content .=  $posts;	
							}else
					$content .= '</div>'; // close COMM
				break;
		
				//case "notes":
				//break;
		
				case "alerts": //================================================= EMAIL GROUPS
					$types = $this->getDocentGlobals($this->_conn);
					$content .= '<div id="comm">';
						$content .= '<div id="threads" style="width:96%;">'; 
						$content .= '<p>Select a group of docents you would like to email now by clicking on the links provided below.<br />
						Your email software will open up a new message window with all addresses listed.<br />
						If you are using a browser-based email service (such as Gmail) please right click the desired link below, "Copy Email Address", 
						and paste in the browser email window.</p>';
						
						// 																			EVERYONE BUT ADMINS
						$emailsAll = getRow("SELECT email FROM guides WHERE admin = 0 ORDER BY lname, fname", $this->_conn);
							if(!empty($emailsAll)){ 
								$emailsList = implode(',', $emailsAll);  
								if(MAILTO == "to"){ $content .= '<p><a href="mailto:'.$emailsList.'">Everyone except Admins</a></p>'; }
								if(MAILTO == "bcc"){ $content .= '<p><a href="mailto:admin@'.WEBSITE.'?Bcc='.$emailsList.'">Everyone except Admins</a></p>'; }
							}
						
						for($i = 0; $i < count($types); $i++){	// 									GET AND DISPLAY DIRECTORY GROUPS
							$value = $types[$i]['shortName'];
							$emails = getRow("SELECT g.email FROM guides AS g, vol_types AS v WHERE v.type = '$value' AND g.guide_id = v.guideID ORDER BY lname, fname", $this->_conn);
							if(!empty($emails)){ 
								$emailsList = implode(',', $emails);  
								if(MAILTO == "to"){ $content .= '<p><a href="mailto:'.$emailsList.'">'.$types[$i]['volunteerType'].'</a></p>'; }
								if(MAILTO == "bcc"){ $content .= '<p><a href="mailto:admin@'.WEBSITE.'?Bcc='.$emailsList.'">'.$types[$i]['volunteerType'].'</a></p>'; }
							}
						}

						$dutyGroups = getAll("SELECT * FROM docentGroupTitles", $this->_conn); // GET DOCENT GROUPS BASED ON DUTY GROUPS
						if(!empty($dutyGroups)){
							foreach($dutyGroups as $k => $value){ // DISPLAY DOCENT DUTY-BASED GROUPS 
								$id = $value['id'];
								$emails4 = getRow("SELECT g.email FROM guides AS g, docentGroups AS dg WHERE dg.groupID = '$id' AND g.guide_id = dg.guideID ORDER BY g.lname, g. fname", $this->_conn);
								if(!empty($emails4)){ 
									$emailsList = implode(',', $emails4);  
									if(MAILTO == "to"){ $content .= '<p><a href="mailto:'.$emailsList.'">'.$value['groupName'].'</a></p>'; }
									if(MAILTO == "bcc"){ $content .= '<p><a href="mailto:admin@'.WEBSITE.'?Bcc='.$emailsList.'">'.$value['groupName'].'</a></p>'; }
								}
				
							}					
						}
						
						$emailGroups = getAll("SELECT * FROM emailgroups WHERE `madeBy` = 0 ORDER BY id asc", $this->_conn);  // GET CUSTOM ADMIN EMAIL GROUPS 
						if(!empty($emailGroups)){ 
							foreach($emailGroups as $k => $value){ // ------ DISPLAY CUSTOM ADMIN EMAIL GROUPS 
								$id = $value['id'];
								$emails2 = getRow("SELECT g.email FROM guides as g, emailGroupNames as eg WHERE g.guide_id = eg.guideId and eg.groupId = '$id' order by g.guide_id", $this->_conn);
								$emailsList2 = implode(',', $emails2);
								if(MAILTO == "to"){ $content .= '<p id="'.$id.'"><a href="mailto:'.$emailsList2.'">'.$value['groupName'].'</a>&nbsp;'; }
								if(MAILTO == "bcc"){ $content .= '<p id="'.$id.'"><a href="mailto:admin@'.WEBSITE.'?Bcc='.$emailsList2.'">'.$value['groupName'].'</a>'; }
								if(isset($_SESSION['adminid'])){ $content .= '&nbsp;&nbsp;<span class="editThisGroup" id="'.$id.'">&#x270D;</span>&nbsp;&nbsp;<a href="#" class="deleteGroup" id="'.$id.'">&#10008;</a>'; }
								$content .= '</p>';
							}
						}
						
						$docentGroups = getAll("SELECT * FROM emailgroups WHERE `madeBy` = '$this->_myID' ORDER BY id asc", $this->_conn); // GET DOCENT CUSTOM EMAIL GROUPS 
						if(!empty($docentGroups)){
							foreach($docentGroups as $k => $value){ // DISPLAY DOCENT CUSTOM EMAIL GROUPS 
								$id = $value['id'];
								$emails3 = getRow("SELECT g.email FROM guides as g, emailGroupNames as eg WHERE g.guide_id = eg.guideId and eg.groupId = '$id' order by g.guide_id", $this->_conn);
								$emailsList3 = implode(',', $emails3);
								if(MAILTO == "to"){ $content .= '<p id="'.$id.'"><a href="mailto:'.$emailsList3.'">'.$value['groupName'].'</a>&nbsp;'; }
								if(MAILTO == "bcc"){ $content .= '<p id="'.$id.'"><a href="mailto:admin@'.WEBSITE.'?Bcc='.$emailsList3.'">'.$value['groupName'].'</a>'; }
								$content .= '&nbsp;&nbsp;<span class="editThisGroup" id="'.$id.'">&#x270D;</span>&nbsp;&nbsp;<a href="#" class="deleteGroup" id="'.$id.'">&#10008;</a></p>';
							}
						}
						$content .= '<p><span id="emailGroup" class="emailGroup">... or select a custom group</span></p>';
						$content .= '</div>'; // close THREADS
					$content .= '</div>'; // close COMM
				break;
		
				default:
				break;
			}
		}
		return $content;
	}
		
	protected function adminContEd($newTopic, $item) //==================== ADMINCONTED 
	{
		$content = "";
		$content .= '<div id="limited">';
		$content .= '<table id="schedule" class="limited">';
		//=================================================== display files
		if(!empty($newTopic)){
			$listTours = getAll('SELECT * FROM contEdSub ORDER BY seq ASC', $this->_conn);
			$content .= '<form method=post action="adminContEd.php">';
			for($i = 0; $i < count($listTours); $i++){	
				$content .= '<input name="resequence['.$i.'][id]" type="hidden" value="'.$listTours[$i]['id'].'">';
				$content .= '<tr><td><input type="text" name="resequence['.$i.'][seq]" class="txt" value="'.$listTours[$i]['seq'].'" size="4"></td>
				<td><a href="adminContEd.php?item='.$listTours[$i]['id'].'" target="_self">'.$listTours[$i]['title'].'</a></td>
				<td><a href="adminContEd.php?deleteSubject='.$listTours[$i]['id'].'" 
				onclick="return confirm(\'WARNING: All sub-topics and associated files will be deleted!\')" target="_self">DELETE</A></td></tr>';
			}
			$content .= '<tr><td colspan="7"><input type="submit" value="RE-ORDER" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';"></form></td></tr>';
		}
		if(!empty($item)){
			$datafiles = getAll("SELECT * FROM contEd WHERE mainSubID = '$item' ORDER BY seq ASC", $this->_conn);   
			if($datafiles){
				for($i = 0; $i < count($datafiles); $i++)
				{	
					$subSubID = $datafiles[$i]['id'];
					$details = nl2br(htmlspecialchars_decode($datafiles[$i]['details']));
					$content .= '<tr><td>'.$datafiles[$i]['seq'].'- <span class="bigText">'.$datafiles[$i]['title'].'</span>
					&nbsp;<a href="#" id="'.$subSubID.'" class="showEdit" title="edit this item">&#9998;</a>&nbsp;
					&nbsp;<a href="#" class="startUpload" id="'.$subSubID.'" title="upload a file">&#10697;</a>&nbsp;
					&nbsp;<a href="adminContEd.php?delete='.$subSubID.'&item='.$item.'" onclick="return confirm(\'WARNING: All of this subject content and associated files will be deleted!\')" target="_self" title="delete">&#10008;</a><br />';
					
					$content .= '<span class="uploadPic" id="'.$subSubID.'">'; //------------------------------------------------ FILE UPLOAD
					$content .= '<FORM ENCTYPE="multipart/form-data" ACTION="adminContEd.php" METHOD="POST" name="uploader">';
					$content .= '<input name="file_id" type="hidden" value="'.$subSubID.'">';
					$content .= '<input name="main_id" type="hidden" value="'.$item.'">';
					$content .= '&nbsp;<INPUT TYPE="FILE" NAME="new_pic"><input type="submit" class="btn" value="UPLOAD FILE"></p></FORM></span>';

					$content .= '<br />'.$details.'<br />';
					$files = getAll("SELECT * FROM contEdFiles WHERE contEdId = '$subSubID' ORDER BY uploadDate desc", $this->_conn);   
					if($files)
					{
						$content .= '<br /><i>Files for download:</i><br />';
						for($d = 0; $d < count($files); $d++)
						{
							$url = 'contEd_files/'.$files[$d]['fileName'];
							$content .= '<a href="'.$url.'" target="_blank">'.$files[$d]['fileName'].'</a>';
							$content .= '<a href="adminContEd.php?deleteFile='.$files[$d]['contEdId'].'&deleteFileName='.$files[$d]['fileName'].'&item='.$item.'" target="_self">&nbsp;x</a><br />'; // downloadable file
						}
					}
					$content .= '</td></tr>';
				}
				$content .= '<tr><td colspan="7"><a href="#" class="resequence" id="'.$item.'">RE-ORDER SEQUENCE</a></td></tr>';
			}else{
				$content .= '<tr><td colspan="3">No files available at this moment.</td></tr>';
			}
		}
		$content .= '</table></div>';
		return $content;
	}
	
	protected function contEd($item) //==================== CONTED 
	{
		$content = "";
		$content .= '<div id="limited">';
		$content .= '<table id="schedule" class="limited">';
		$datafiles = getAll("SELECT * FROM contEd WHERE mainSubID = '$item' ORDER BY seq", $this->_conn);
			if($datafiles){
				for($i = 0; $i < count($datafiles); $i++){	
					$f = $datafiles[$i]['id'];
					$details = nl2br(htmlspecialchars_decode($datafiles[$i]['details']));
					$content .=  '<tr><td colspan="3"><br /><span class="bigText" id="'.$f.'">'.strtoupper($datafiles[$i]['title']).'</span>';
					$content .= '<div class="contedDetails" id="'.$f.'">';
					$content .=  '<p class="contedDetails" id="'.$f.'">'.$details.'</p>';
						$files = getAll("SELECT * FROM contEdFiles WHERE contEdId = '$f' ORDER BY uploadDate desc", $this->_conn);
							if(!empty($files)){
								$content .= '<p><b>Files for download:</b></p>';
								for($d = 0; $d < count($files); $d++){
									$url = 'contEd_files/'.$files[$d]['fileName'];
									$content .=  '<p><a href="'.$url.'" target="_blank">'.$files[$d]['fileName'].'</a></p>'; // downloadable file
								}
							}
					$content .= '</div>';
					$content .= '<br /></td></tr>';
				}
				$content .= '<tr><td><span class="bigText"></span><span class="contedDetails"></span></td></tr>'; // FAKE SPAN TO SHOW LAST IN LOOP. WEIRD...
			}
			else{
				$content .= '<tr><td colspan="3">No files available at this moment. Please try later</td></tr>';
			}
		$content .= '</table></div>';
		return $content;
	}
	
	protected function events($prefix) //==================== EVENT - LIKE SCHEDULES
	{
		$content = "";
		define("ADAY", (60*60*24));
		if($_POST['month'] && $_POST['year']){
			$monthYear = $_POST['month'].$_POST['year'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$prefix = $_POST['programShortName'];
		}
		if($_GET['month'] && $_GET['year']){
			$monthYear = $_GET['month'].$_GET['year'];
			$month = $_GET['month'];
			$year = $_GET['year'];
		}
		$content .= '<TABLE class="duties">';
			$cls = new nmt_events($this->_conn);
			$showContents = $cls->showEventContent($month, $year, $prefix);
			$content .=  $showContents;
		$content .= '</TABLE>';
		return $content;
	}
	
	protected function eventCalendar() //==================== CALENDAR EVENTS 
	{
		$content = "";
		define("ADAY", (60*60*24));
		if($_POST['month'] && $_POST['year']){
			$monthYear = $_POST['month'].$_POST['year'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$prefix = $_POST['programShortName'];
		}
		if($_GET['month'] && $_GET['year']){
			$monthYear = $_GET['month'].$_GET['year'];
			$month = $_GET['month'];
			$year = $_GET['year'];
		}
		$content .= '<TABLE class="duties">';
			$cls = new nmt_eventCalendar($this->_conn);
			$showContents = $cls->showEventContent($month, $year);
			$content .=  $showContents;
		$content .= '</TABLE>';
		return $content;
	}
	
	protected function signUp($id, $eventName, $sorter, $prefix) //==================== EVENT DUTY SIGNUP 
	{
		$content = "";
		$content .= '<TABLE class="eventSignUp">';
			$cls = new nmt_events($this->_conn);
			$showContents = $cls->signUpContent($id, $eventName, $sorter, $prefix);
			$content .=  $showContents;
		$content .= '</TABLE>';
		return $content;
	}
	
	protected function signUpCal($id, $eventName, $sorter) //==================== EVENT CALENDAR SIGNUP  
	{
		$content = "";
		$content .= '<TABLE class="eventSignUp">';
			$cls = new nmt_eventCalendar($this->_conn);
			$showContents = $cls->signUpContent($id, $eventName, $sorter);
			$content .=  $showContents;
		$content .= '</TABLE>';
		return $content;
	}
	
	protected function adminTrips($tripID, $sorter) //==================== ADMIN EXCURSIONS 
	{
		if(isset($_SESSION['photoTripID'])){ unset($_SESSION['photoTripID']); }
		
		$content = "";
		if(!empty($tripID))
		{
			$cls = new nmt_trips($this->_conn, $tripID);
			if($_GET['viewTrip']){ $getType = "viewTrip"; } // -----------------------VIEW EXCURSION
			if($_GET['editTrip']){ $getType = "editTrip"; }  // EDIT EXCURSION
			if($_GET['viewPicsFor']){ $getType = "viewPicsFor"; }  // ------------------------------VIEW PHOTOS
			if($_GET['signup'] || $_GET['sorter']){ $getType = $_GET['sorter']; }  // ============================VIEW SIGN UP
			$showContents = $cls->tripAdminContent($getType, "adminTrips.php");
			$content .=  $showContents;
		}
		return $content;	
	}
	
	protected function trips($tripID, $sorter) //==================== DOCENTS EXCURSIONS 
	{
		$content = "";
		if(!empty($tripID))
		{
			$cls = new nmt_trips($this->_conn, $tripID);
			if($_GET['viewTrip']){ $getType = "viewTrip"; } // ----------------------- VIEW EXCURSION
			if($_GET['viewPicsFor']){ $getType = "viewPicsFor"; } // ----------------- VIEW PHOTOS
			if($_GET['signup'] || $_GET['sorter']){ $getType = $_GET['sorter']; }  //  VIEW SIGN UP
			$showContents = $cls->tripContent($getType, "trips.php");
			$content .=  $showContents;
		}
		return $content;	
	}
	
	protected function adminNewsletter($url) //==================== ADMIN NEWSLETTER 
	{
		if(!isset($url)){
			$url = get1("SELECT url FROM newsletter ORDER BY date DESC LIMIT 1", $this->_conn);
		}
		$allNewsletters = getRow("SELECT url FROM newsletter ORDER BY date DESC", $this->_conn); // GET ALL NEWSLETTERS FILE NAMES FOR SEARCH ENGINE;
		$latest = 'newsletters/'.$url;
		$content = "";
		if(!empty($allNewsletters)){
			foreach($allNewsletters as $k => $val){ $content .= '<a href="newsletters/'.$val.'"></a>'; }
		}
		$content .= '<iframe id="pdfFrame" src = "ViewerJS/#../'.$latest.'" allowfullscreen webkitallowfullscreen></iframe>';
		return $content;	
	}
	
	protected function editor($newLink, $viewLink) //==================== INFO MENU EDITOR 
	{
		$content = "";
		$content .= '<TABLE class="editore">';
		$cls = new nmt_editor($this->_conn);
		if(!empty($newLink)){ $showContents = $cls->editorContent($newLink); }
		if(!empty($viewLink)){ $showContents = $cls->pagesContent($viewLink); }
		$content .=  $showContents;
		$content .= '</TABLE>';
		return $content;
	}
	
	protected function pages($page) //==================== INFO MENU EDITOR 
	{
		$content = "";
		//$content .= '<div id="limited">';
		$cls = new nmt_editor($this->_conn);
		$showContents = $cls->pagesContent($page);
		$content .=  $showContents;
		//$content .= '</div>';
		return $content;
	}
	
	protected function printing($calMonth, $pageType, $printDir, $prefix) //==================== PRINT 
	{
		require_once 'printer.php';
		$content = "";
		if(isset($calMonth)){
			$val = new nmt_printer($calMonth, $pageType, $prefix, $this->_conn);
			$content .=  $val;
		}
		if($_GET['printDir']){
			$printDir = $_GET['printDir']; // admin, guides, staff, etc
			$pageType = $_GET['pageType']; // directory
			$val = new nmt_printer($printDir, $pageType, $prefix, $this->_conn);
			$content .=  $val;
		}
		if($_GET['printCrHrs']){
			$printCrHrs = $_GET['printCrHrs']; // PRINT SELECTED CREDIT HOURS TIME SPAN
			$pageType = $_GET['pageType']; // CREDIT HOURS
			$val = new nmt_printer($printCrHrs, $pageType, $prefix, $this->_conn);
			$content .=  $val;
		}
		if($_GET['printNcHrs']){
			$printNcHrs = $_GET['printNcHrs']; // PRINT SELECTED CREDIT HOURS TIME SPAN
			$pageType = $_GET['pageType']; // CREDIT HOURS
			$val = new nmt_printer($printNcHrs, $pageType, $prefix, $this->_conn);
			$content .=  $val;
		}
		return $content;
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ HELPER FUNCTIONS ++++++++++++++++++++++++++++++++++++
	protected function subval_sort($a,$subkey) 
	{
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;
	}
	
	protected function monthName($val) //				GET MONTH NAME
	{
		switch ($val){
		  case 1:  
			$name = 'january';
		  break;
		  case 2:  
			$name = 'february';
		  break;
		  case 3:  
			$name = 'march';
		  break;
		  case 4:  
			$name = 'april';
		  break;
		  case 5:  
			$name = 'may';
		  break;
		  case 6:  
			$name = 'june';
		  break;
		  case 7:  
			$name = 'july';
		  break;
		  case 8:  
			$name = 'august';
		  break;
		  case 9:  
			$name = 'september';
		  break;
		  case 10:  
			$name = 'october';
		  break;
		  case 11:  
			$name = 'november';
		  break;
		  case 12:  
			$name = 'december';
		  break;
		  default:
		  break;
		}
		return $name;
	}
	
	protected function getDocentGlobals($cnt) //		GET DOCENTS TYPES LIST
	{
		$types = getAll("SELECT * FROM volunteerType ORDER BY shortName", $cnt);  
		return $types;
	}
	
	protected function getMailGroups($connection) //  	GET EMAIL GROUPS
	{ 
		$eg = getAll("SELECT * FROM emailgroups order by id asc", $connection);   
		return $eg;
	}

}// end class