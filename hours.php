<?php
class nmt_hours
{
// properties defined here
	protected $_conn;
	protected $_myID;

//constructor
	public function __construct($conn) {
		$this->_conn = $conn;
		$this->_myID = $_SESSION['id'];
	}
// methods defined here

	public function showAdminHeader($choose, $guides) //-------------- SHOW ADMIN HEADERS
	{
			if($_POST['pars']){  //					FILL THE SEARCH FIELDS WITH THE POST SEARCH PARAMETERS
				$pars = $_POST['pars'];
				$from = $pars['from'];
				$to = $pars['to'];
				$guide = $pars['guides'];
				$siti = $pars['sites'];  //			 SELECT CREDIT HOURS BY POST
				$acti = $pars['act'];  //			 SELECT NON CREDIT HOURS BY POST
			}
			//------------------------- SELECT BY GET
			if($_GET['a_choose']){
				$choose = $_GET['a_choose'];
				$from = $_GET['from'];
				$to = $_GET['to'];
				$guide = $_GET['guides'];
				$siti = $_GET['sites'];
				$acti = $_GET['act'];
			}

		$ntDutyList = getAll("SELECT * FROM duties where ntHoursOO = 1 order by seq asc", $this->_conn);
		$content = "";
		// GET ALL HOUR REPORTS FOR SPIDER
		$content .= '<a href="adminHours.php?spider_choose=hours"></a><a href="adminHours.php?spider_choose=hoursNC"></a>';

		$content .= '<form action="adminHours.php" method="post" target="_self">'; //--------- NEW ENTRY FORM START
		$content .= '<input name="choose" type="hidden" value="'.$choose.'" />';
		$content .= '<div id="menu">';

		switch($choose)
		{
			case "hours": //-------------------------------- FIND CREDIT HOURS REPORTED
				$content .= '&nbsp;'.CREDITHOURS.SPACER;
				if(empty($from)){
					$from = $this->findYear(time());
					$content .= '<input required type="text" class="txt" id="from" name="pars[from]" value="'.YEAR_START.$from.'" placeholder="FROM DATE">'.SPACER;
				}else{
					$content .= '<input required type="text" class="txt" id="from" name="pars[from]" value="'.$from.'" placeholder="FROM DATE">'.SPACER;
				}
				if(empty($to)){
					$to = date('Y', strtotime(YEAR_START.$from) + 31449600);
					$content .= '<input required type="text" class="txt" id="to" name="pars[to]" value="'.YEAR_END.$to.'" placeholder="TO DATE">'.SPACER;
				}else{
					$content .= '<input required type="text" class="txt" id="to" name="pars[to]" value="'.$to.'" placeholder="TO DATE">'.SPACER;
				}

				$schedules = getAll('SELECT * FROM volunteerType WHERE hasSchedule = 1 ORDER BY volunteerType ASC', $this->_conn);
				$content .= '<select name="pars[guides]" class="txt">';
				if(!empty($guide)){   //							 			SELECTED DOCENT
					if($guide == "all"){
						$content .= '<OPTION VALUE="all" selected>All '.ucfirst(VOLUNTEER).'s</option>';
					}else{
						$guideName = getQuery("SELECT `fname`, `lname` FROM guides where guide_id = '$guide'", $this->_conn);
						$content .= '<OPTION VALUE="'.$guide.'" selected>'.$guideName['fname'].' '.$guideName['lname'].'</option>';
						$content .= '<OPTION VALUE="all">All '.ucfirst(VOLUNTEER).'s</option>';
					}
				}else{
					$content .= '<OPTION VALUE="all" selected>All '.ucfirst(VOLUNTEER).'s</option>';
				}

				for($i = 0; $i < count($guides); $i++){ //							 DOCENTS LIST
					$nome = $guides[$i]['fname'].' '.$guides[$i]['lname'];
					$id = $guides[$i]['guide_id'];
					$content .= '<OPTION VALUE="'.$id.'">'.$nome.'</option>';
				}
				$content .= '</select>'.SPACER;
			//================================================================== 	DUTIES
				$content .= '<select name="pars[sites]" class="txt">';
				if(!empty($siti)){
					if($siti == "all"){
						$content .= '<OPTION VALUE="all" selected>All Duties</option>';
					}else{
						$content .= '<OPTION VALUE="'.$siti.'" selected>'.$siti.'</option>';
						$content .= '<OPTION VALUE="all">All Duties</option>';
					}
				}else{
					$content .= '<OPTION VALUE="all" selected>All Duties</option>';
				}
				for($i = 0; $i < count($schedules); $i++){ //-------------- SHOW LIST OF MAIN TYPES
					$content .= '<option value="" style="background:#e0e0e0;">'.$schedules[$i]['volunteerType'].' List</option>';
					$dutyArray = $this->getDutyArrays($schedules[$i]['shortName']);
					for($a = 0; $a < count($dutyArray); $a++){
						$content .= '<option value="'.$dutyArray[$a]['dutyName'].'" class="indented">'.$dutyArray[$a]['dutyName'].'</option>';
					}
				}

				$content .= '</select>'.SPACER;

				$content .= '&nbsp;<input type="submit" class="btn" value="SHOW">';
			break;

			case "hoursNC": //-------------------------------- FIND NON-CREDIT HOURS REPORTED
				$content .= NONCREDITHOURS.SPACER;
				if(empty($from)){
					$from = $this->findYear(time());
					$content .= '<input required type="text" class="txt" id="from" name="pars[from]" value="'.YEAR_START.$from.'" placeholder="FROM DATE">'.SPACER;
				}else{
					$content .= '<input required type="text" class="txt" id="from" name="pars[from]" value="'.$from.'" placeholder="FROM DATE">'.SPACER;
				}
				if(empty($to)){
					$to = date('Y', strtotime(YEAR_START.$from) + 31449600);
					$content .= '<input required type="text" class="txt" id="to" name="pars[to]" value="'.YEAR_END.$to.'" placeholder="TO DATE">'.SPACER;
				}else{
					$content .= '<input required type="text" class="txt" id="to" name="pars[to]" value="'.$to.'" placeholder="TO DATE">'.SPACER;
				}

				$content .= '<select name="pars[guides]" class="txt">';
				if(!empty($guide)){   //							 			SELECTED DOCENT
					if($guide == "all"){
						$content .= '<OPTION VALUE="all" selected>All '.ucfirst(VOLUNTEER).'s</option>';
					}else{
						$guideName = getQuery("SELECT `fname`, `lname` FROM guides where guide_id = '$guide'", $this->_conn);
						$content .= '<OPTION VALUE="'.$guide.'" selected>'.$guideName['fname'].' '.$guideName['lname'].'</option>';
						$content .= '<OPTION VALUE="all">All '.ucfirst(VOLUNTEER).'s</option>';
					}
				}else{
					$content .= '<OPTION VALUE="all" selected>All '.ucfirst(VOLUNTEER).'s</option>';
				}
				for($i = 0; $i < count($guides); $i++){
					$nome = $guides[$i]['fname'].' '.$guides[$i]['lname'];
					$id = $guides[$i]['guide_id'];
					$content .= '<OPTION VALUE="'.$id.'">'.$nome.'</option>';
				}
				$content .= '</select>&nbsp;';

				$content .= '<select name="pars[act]" class="txt">';
					if(!empty($acti)){
					if($acti == "all"){
						$content .= '<OPTION VALUE="all" selected>All Activities</option>';
					}else{
						$content .= '<OPTION VALUE="'.$acti.'" selected>'.$acti.'</option>';
						$content .= '<OPTION VALUE="all">All Activities</option>';
					}
				}else{
					$content .= '<OPTION VALUE="all" selected>All Activities</option>';
				}
				if(!empty($ntDutyList)){
					for($i = 0; $i < count($ntDutyList); $i++){
						$content .= '<option value="'.$ntDutyList[$i]['dutyName'].'">'.$ntDutyList[$i]['dutyName'].'</option>';
					}
				}
				$content .= '</select>&nbsp;';

				$content .= '<input type="submit" class="btn" value="SHOW">';
				$content .= '&nbsp;&nbsp;<a href="duties.php?dutyType=ntHoursOO" target="_self">Manage non-tour activities</a>';
			break;

			case "chart": //-------------------------------- DISPLAY AND EXPORT CHARTS
				$yearFrom = $this->establishDate("year");
				$month = $this->establishDate("month");
				$monthEnd = $this->establishDate("monthEnd");
				$allYears = $this->establishDate("allYears"); //---- ARRAY OF ALL YEARS WITH RECORDED HOURS REPORTS
				if(!empty($allYears)){ rsort($allYears); }

				if($_POST['yearSelection']) {
			 		$yearFrom = date('Y', $_POST['yearSelection']);  //---------- STARTING YEAR IS ESTABLISHER BY USER POST
			 	}
			 	$chart = $this->show_chart_header($yearFrom,$month,$monthEnd,$allYears);
				$content .= $chart;
			break;

			case "addHrs": //-------------------------------- DISPLAY HOURS INPUT INTERFACE
				$content .= 'Enter '.ucfirst(VOLUNTEER).'s tour hours';
			break;

			default:
			break;
		}

		$content .= '</div></form>'; // CLOSE MENU
		return $content;
	}

	//====================================================-------- SHOW ADMIN CONTENT
	public function showAdminHoursContent($choose)
	{
		$content = "";

		if($_GET['asc']){ $asc = $_GET['asc']; }else{ $asc = "desc"; } // ------ ASC OR DESC SELECTION

		if($_GET['selectBy']){ $selectBy = $_GET['selectBy']; }else{ $selectBy = "date"; } // ------ SELECT BY <WHICH ITEM>

		//------------------------- SELECT FOR SPIDER
		if($_GET['spider_choose']){
			$choose = $_GET['spider_choose'];
			if($choose == 'hours'){
				$allHours =  getAll("SELECT c.id, c.date, c.hours, c.visitors, c.children, c.tour, c.scheduleType, c.theme, c.comments, c.suggestions, g.guide_id, g.fname, g.lname
						            FROM hours as c, guides as g WHERE g.guide_id = c.guideID ORDER BY $selectBy $asc", $this->_conn);
			}

		//------------------------- SELECT NC FOR SPIDER
			if($choose == 'hoursNC'){
				$allNCHours = getAll("SELECT c.id, c.date, c.hours, c.activity, c.details, g.guide_id, g.fname, g.lname
								FROM hoursNC as c, guides as g
								WHERE g.guide_id = c.guideID
								ORDER BY date DESC", $this->_conn);
			}
		}
		//------------------------- SELECT CREDIT HOURS BY GET
		if($_GET['a_choose']){
			$choose = $_GET['a_choose'];
			if($choose == 'hours'){
				$f = $_GET['from'];
				$t = $_GET['to'];
				$to = strtotime($t);
				$from = strtotime($f);
				$guides = $_GET['guides'];
				$sites = $_GET['sites'];
				$pars = array($f, $t, $guides, $sites);

				$pars_qty = 0;
				foreach($pars as $key=>$value) {
					if($value != "all")
					$pars_qty++;
				}
			}
			if($choose == 'hoursNC'){ //------------------------- SELECT NON CREDIT HOURS BY GET
				$f = $_GET['from'];
				$t = $_GET['to'];
				$to = strtotime($t);
				$from = strtotime($f);
				$guides = $_GET['guides'];
				$act = $_GET['act'];
				$pars = array($f, $t, $guides, $act);

				$act_qty = 0;
				foreach($pars as $key=>$value) {
					if($value != "all")
					$act_qty++;
				}
			}
		}

		//------------------------- SELECT CREDIT HOURS BY POST
		if($_POST['choose']){
			$choose = $_POST['choose'];
			if($_POST['pars']){ $pars = $_POST['pars']; }
			if($choose == 'hours'){
				$f = $pars['from'];
				$t = $pars['to'];
				$to = strtotime($t);
				$from = strtotime($f);
				$guides = $pars['guides'];
				$sites = $pars['sites'];

				$pars_qty = 0;
				foreach($pars as $key=>$value) {
					if($value != "all")
					$pars_qty++;
				}
			}

			if($choose == 'hoursNC'){ //------------------------- SELECT NON CREDIT HOURS BY GET
				$f = $pars['from'];
				$t = $pars['to'];
				$to = strtotime($t);
				$from = strtotime($f);
				$guides = $pars['guides'];
				$act = $pars['act'];

				$act_qty = 0;
				foreach($pars as $key=>$value) {
					if($value != "all")
					$act_qty++;
				}
			}
		}


		if($pars_qty) //-------------  GET CREDIT HOURS
		{
		switch ($pars_qty)
			{
				case 3: //--------------------------------- ONE EXTRA PARAM
				//-guide param
					if($guides != "all")
					{
						if(is_numeric($guides)){ // IF VAR IS INTEGER, ERGO A GUIDE ID
							$docentName = get1("SELECT CONCAT_WS(' ', fname, lname) FROM guides where guide_id = '$guides'", $this->_conn);
							$allHours = getAll("SELECT c.id, c.date, c.hours, c.visitors, c.children, c.tour, c.scheduleType, c.theme, c.comments, c.suggestions, g.guide_id, g.fname, g.lname
							FROM hours as c, guides as g
							WHERE c.date > '$from' and c.date < '$to' and c.guideID = '$guides' and g.guide_id = c.guideID
							order by $selectBy $asc", $this->_conn);
						}else{ // IF VAR IS NOT AN INTEGER, ERGO A GROUP NAME
							$docentName = $guides;
							$allHours = getAll("SELECT c.id, c.date, c.hours, c.visitors, c.children, c.tour, c.scheduleType, c.theme, c.comments, c.suggestions, g.guide_id, g.fname, g.lname
							FROM hours as c, guides as g
							WHERE c.date > '$from' and c.date < '$to' AND c.scheduleType = '$guides' AND c.guideID = g.guide_id
							order by $selectBy $asc", $this->_conn);
						}
					}
					//-duty param
					if($sites != "all")
					{
							$duty = $sites;
							$allHours = getAll("SELECT c.id, c.date, c.hours, c.visitors, c.children, c.tour, c.scheduleType, c.theme, c.comments, c.suggestions, g.guide_id, g.fname, g.lname
							FROM hours as c, guides as g
							WHERE c.date > '$from' and c.date < '$to' and g.guide_id = c.guideID and c.tour = '$sites'
							order by $selectBy $asc", $this->_conn);
					}
				break;

				case 4: //--------------------------------- ALL PARAMETERS ACTIVATED

						$docentName = get1("SELECT CONCAT_WS(' ', fname, lname) FROM guides where guide_id = '$guides'", $this->_conn);
						$duty = $sites;
						$allHours = getAll("SELECT c.id, c.date, c.hours, c.visitors, c.children, c.tour, c.scheduleType, c.theme, c.comments, c.suggestions, g.guide_id, g.fname, g.lname
						FROM hours as c, guides as g
						WHERE c.date > '$from' and c.date < '$to' and c.guideID = '$guides' and g.guide_id = c.guideID and c.tour = '$sites'
						order by $selectBy $asc", $this->_conn);
				break;

				default: //--------------------------------- BASIC - JUST A DATE SPAN
						$allHours = getAll("SELECT c.id, c.date, c.hours, c.visitors, c.children, c.tour, c.scheduleType, c.theme, c.comments, c.suggestions, g.guide_id, g.fname, g.lname
						FROM hours as c, guides as g
						WHERE c.date > '$from' and c.date < '$to' and g.guide_id = c.guideID
						order by $selectBy $asc", $this->_conn);
				break;
			}
		}

		$content .= '<table class="hours">'; // BEGIN TABLE DISPLAY
		if(!empty($allHours)) //-------- DISPLAY CREDIT HOURS
		{
			$stringToPass = $from.'_'.$to.'_'.$guides.'_'.$sites.'_'.$selectBy.'_'.$asc;

			if(empty($docentName)){ $docentName = "All docents"; }
			if(empty($duty)){ $duty = "All tours"; }
			$content .= '<tr><td class="header" colspan="12">Displaying data for:'.SPACER.$docentName.SPACER.$duty.SPACER.' From: '.$f.' To: '.$t;
			if(!isset($_SESSION['device'])){
				$content .= SPACER.'<a href="print.php?printCrHrs='.$stringToPass.'&pageType=creditHours" target="_blank">PRINT</a>';
				$content .= '&nbsp;<a href="export.php?type=cHrs&my='.$from.'_'.$to.'">EXPORT</a>';
			}
			$content .= '</td></tr>';
			//**************************** HEADERS
			$content .= '<tr>';
			$content .= '<td>DATE'.$this->udLinks($choose,$f,$t,$guides,$sites,"date").'</td>';
			$content .= '<td>'.strtoupper(VOLUNTEER).' '.$this->udLinks($choose,$f,$t,$guides,$sites,"lname").'</td>';
			$content .= '<td>HOURS'.$this->udLinks($choose,$f,$t,$guides,$sites,"hours").'</td>';
			if(!isset($_SESSION['device'])){
				$content .= '<td>TOUR'.$this->udLinks($choose,$f,$t,$guides,$sites,"tour").'</td>';
				$content .= '<td>THEME</td>';
				$content .= '<td>'.strtoupper(VISITORS).$this->udLinks($choose,$f,$t,$guides,$sites,"visitors").'</td>';
				if(defined('VISITORS2')){ $content .= '<td>CHILDREN'.$this->udLinks($choose,$f,$t,$guides,$sites,"children").'</td>'; }
				$content .= '<td>COMMENTS</td>';
				$content .= '<td>SUGGESTIONS</td>';
			}
			$content .= '<td></td>';
			$content .= '</tr>';

			//**************************** CONTENT
			$visitorsCount = 0;
			$childrenCount = 0;
			$hoursCount = 0;

			for($i = 0; $i < count($allHours); $i++)
				{
					$dates = date("m/d/Y", $allHours[$i]['date']);
					//----------------------------Guide name
					$guideID = $allHours[$i]['guide_id'];
					$guideName = $allHours[$i]['fname'].' '.$allHours[$i]['lname'];
					$dutyName = $allHours[$i]['tour']; //--------------- which duty was performed?

					$content .= '<tr id="'.$allHours[$i]['id'].'_'.$choose.'">';
					$content .= '<td>'.$dates.'</td>';
					$content .= '<td>'.$guideName.'</td>';
					$content .= '<td>'.$allHours[$i]['hours'].'</td>';

					if(!isset($_SESSION['device'])){
						$credits = get1("SELECT credits FROM duties WHERE dutyName = '$dutyName'", $this->_conn); // SHOW THE CREDIT HOURS THIS DUTY HAS BEEN ASSIGNED
						$content .= '<td>'.$dutyName.'<br />(H: '.$credits.')</td>';
						$content .= '<td>'.$allHours[$i]['theme'].'</td>';
						$content .= '<td>'.$allHours[$i]['visitors'].'</td>';
						if(defined('VISITORS2')){ $content .= '<td>'.$allHours[$i]['children'].'</td>'; }
						$content .= '<td><div id="extraComment">'.$allHours[$i]['comments'].'</div></td>';
						$content .= '<td><div id="extraSuggestion">'.$allHours[$i]['suggestions'].'</div></td>';
						$content .= '<td>';
							$content .= '<a href="#" class="editCHours" id="'.$allHours[$i]['id'].'_'.$choose.'_'.$f.'_'.$t.'_'.$guides.'_'.$sites.'_'.$guideID.'">&#9998;</a>&nbsp;&nbsp; '; // EDIT ENTRY
							$content .= '<a href="#" class="zappHours" id="'.$allHours[$i]['id'].'_'.$choose.'">&#10008;</a>'; // DELETE ENTRY
							$content .= '</td>';
					}else{
						$content .= '<td><a id="'.$allHours[$i]['id'].'_hours_'.$allHours[$i]['scheduleType'].'_'.$guideID.'" class="popDetails" href="#"> ... </a></td>';
					}
					$content .= '</tr>';

					$visitorsCount = $visitorsCount + $allHours[$i]['visitors'];
					$childrenCount = $childrenCount + $allHours[$i]['children'];
					$hoursCount = $hoursCount + $allHours[$i]['hours'];

				}
				if(!isset($_SESSION['device'])){
					if(defined('VISITORS2')){ $content .= '<tr><td style="text-align:right;" colspan="5"><b>Partial totals:</b></td><td><b>'.$visitorsCount.'</b></td><td><b>'.$childrenCount.'</b></td><td colspan="3"></td></tr>'; }
						$totalCount = $visitorsCount + $childrenCount;
					$content .= '<tr><td style="text-align:right;" colspan="2"><b>Total hours:</b></td><td><b>'.$hoursCount.'</b></td>
					<td style="text-align:right;" colspan="2"><b>Total visitors:</b></td><td style="text-align:center;"><b>'.$totalCount.'</b></td><td><b>Total reports: '.$i.'</b></td><td colspan="2"></td></tr>';
				}else{
					$content .= '<tr><td style="text-align:right;" colspan="2"><b>Total hours:</b></td><td><b>'.$hoursCount.'</b></td><td></td></tr>';
				}
		}

		if($act_qty) //------------------ GET NON CREDIT HOURS
		{
			switch ($act_qty)
				{
					case 3: //--------------------------------- ONE EXTRA PARAM
					//-guide param
									if($guides != "all")
									{
										$docentName = get1("SELECT CONCAT_WS(' ', fname, lname) FROM guides where guide_id = '$guides'", $this->_conn);
										$allNCHours = getAll("SELECT c.id, c.date, c.hours, c.activity, c.details, g.guide_id, g.fname, g.lname
										FROM hoursNC as c, guides as g
										WHERE c.date > '$from' and c.date < '$to' and c.guideID = '$guides' and g.guide_id = c.guideID
										order by $selectBy $asc", $this->_conn);
									}
					//-duty param
									if($act != "all")
									{
										$duty = $act;
										$allNCHours = getAll("SELECT c.id, c.date, c.hours, c.activity, c.details, g.guide_id, g.fname, g.lname
										FROM hoursNC as c, guides as g
										WHERE c.date > '$from' and c.date < '$to' and g.guide_id = c.guideID and c.activity = '$act'
										order by $selectBy $asc", $this->_conn);
									}
					break;

					case 4: //--------------------------------- ALL PARAMETERS ACTIVATED (4)
									$allNCHours = getAll("SELECT c.id, c.date, c.hours, c.activity, c.details, g.guide_id, g.fname, g.lname
									FROM hoursNC as c, guides as g
									WHERE c.date > '$from' and c.date < '$to' and c.guideID = '$guides' and g.guide_id = c.guideID and c.activity = '$act'
									order by $selectBy $asc", $this->_conn);
					break;

					default: //--------------------------------- BASIC - JUST A DATE SPAN
								$allNCHours = getAll("SELECT c.id, c.date, c.hours, c.activity, c.details, g.guide_id, g.fname, g.lname
								FROM hoursNC as c, guides as g
								WHERE c.date > '$from' and c.date < '$to' and g.guide_id = c.guideID
								order by $selectBy $asc", $this->_conn);
					break;
				}
		}

		if(!empty($allNCHours)) //------- DISPLAY NON CREDIT HOURS
		{
			$stringToPass = $from.'_'.$to.'_'.$guides.'_'.$act.'_'.$selectBy.'_'.$asc;
			if(empty($docentName)){ $docentName = "All docents"; }
			if(empty($duty)){ $duty = "All activities"; }
			$content .= '<table class="hours">';
			$content .= '<tr><td class="header" colspan="12">Displaying data for: '.$docentName.SPACER.$duty.SPACER.' From: '.$f.' To: '.$t;
			$content .= '<a href="print.php?printNcHrs='.$stringToPass.'&pageType=ncHours" target="_blank">PRINT</a>';
			if(!isset($_SESSION['device'])){
				$content .= '<a href="export.php?type=ncHrs&my='.$from.'_'.$to.'">EXPORT</a>';
			}
			$content .= '</td></tr>';
			$htab = 0;
			//--------------------------------------- HEADERS
			$content .= '<tr>';
			$content .= '<td>DATE'.$this->udLinksNC($choose,$f,$t,$guides,$act,"date").'</td>';
			$content .= '<td>'.strtoupper(VOLUNTEER).' '.$this->udLinksNC($choose,$f,$t,$guides,$act,"lname").'</td>';
			$content .= '<td>HOURS'.$this->udLinksNC($choose,$f,$t,$guides,$act,"hours").'</td>';
			if(!isset($_SESSION['device'])){
				$content .= '<td>ACTIVITY'.$this->udLinksNC($choose,$f,$t,$guides,$act,"activity").'</td>';
				$content .= '<td>DETAILS</td>';
			}
			$content .= '<td></td></tr>';

			for($b = 0; $b < count($allNCHours); $b++) { //--------------------  DATA
				$thedate = date('D m/d/Y', $allNCHours[$b]['date']);
				$guideID = $allNCHours[$b]['guide_id'];
				$guideName = $allNCHours[$b]['fname'].' '.$allNCHours[$b]['lname'];

				$content .= '<tr id="'.$allNCHours[$b]['id'].'_'.$choose.'">';
				$content .= '<td>'.$thedate.'</td>';
				$content .= '<td>'.$guideName.'</td>';
				$content .= '<td>'.$allNCHours[$b]['hours'].'</td>';
				if(!isset($_SESSION['device'])){
					$content .= '<td>'.$allNCHours[$b]['activity'].'</td>';
					$content .= '<td><div id="extraSuggestion">'.$allNCHours[$b]['details'].'</div></td>';
					$content .= '<td><a href="#" class="editNCHours" id="'.$allNCHours[$b]['id'].'_'.$choose.'_'.$f.'_'.$t.'_'.$guides.'_'.$act.'_'.$guideID.'">&#9998;</a>&nbsp;&nbsp; '; // EDIT ENTRY
					$content .= '<a href="#" class="zappHours" id="'.$allNCHours[$b]['id'].'_'.$choose.'">&#10008;</a></td>';
				}else{
					$content .= '<td><a id="'.$allNCHours[$b]['id'].'_hoursNC_admin_'.$guideID.'" class="popDetails" href="#"> ... </a></td>';
				}
				$content .= '</tr>';
					$htab = $htab + $allNCHours[$b]['hours'];
			}
				$content .= '<tr><td style="text-align:right;" colspan="2"><b>Total hours:</b></td><td><b>'.$htab.'</b></td><td><b>Total reports: '.$b.'</b></td><td>';
				if(!isset($_SESSION['device'])){ $content .= '</td><td></td>'; }
				$content .= '</tr>';
		}

		if($choose == "chart")// ------------------------------------- ADMIN FULL YEAR CHART
		{
			if($_POST['yearSelection'])
			{
				$yearSelection = $_POST['yearSelection'];
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DISPLAY DATA ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				$adminChart = $this->getBigChart($yearSelection);
				$content .= $adminChart;
			}
		}

		//---------------------------------- ADMIN ADD HOURS AS A VOLUNTEER
		if($choose == "addHrs"){
			$guides = getAll("SELECT * FROM guides WHERE admin = 0 ORDER BY lname, fname", $this->_conn);
			$content .='<table class="duties">';
			$content .='<tr><td colspan="8">Click on the links below to report hours for the appropriate selection</td></tr>';
			$content .='<tr><td colspan="8"></td></tr>';
			for($i = 0; $i < count($guides); $i++){
				$nome = $guides[$i]['fname'].' '.$guides[$i]['lname'];
				$id = $guides[$i]['guide_id'];

				$types = getRow("SELECT `type` FROM vol_types WHERE guideID = '$id'", $this->_conn);
				$content .='<tr>
					<td>'.$nome.'</td>';
					if(!empty($types))
					{
						foreach($types as $k => $v){
							$typesLongName =  $this->getVolTypeName($v, $this->_conn);
							$content .= '<td><a href="#" class="newHoursReport" id="hours_'.$v.'_'.$typesLongName[1].'_'.$id.'">'.$typesLongName[0].'</a></td>';
						}
					}
				$content .='</tr>';
			}
		}

		if(empty($allNCHours) && empty($allHours) && empty($yearSelection)) //------ IF ANY OF THE 3 QUERIES (C, NC, CHART) RETURN NO RESULTS, STATE SO
		{
			if($_POST['choose'])
			$content .= '<tr><td colspan="6">No results available for this query!</td></tr>';
		}
		//------------------------ RETURN RESULTS
		$content .= '</table>';

		return $content;
	}

	//******************************************************************************************************************
	//******************************************************************************************************************
	//****************************************************** DOCENT PAGE ***********************************************
	//******************************************************************************************************************
	//******************************************************************************************************************

	public function showHeader($choose, $guides) //============== SHOW DOCENT HEADER
	{
		$content = "";
		// GET ALL HOUR REPORTS FOR SPIDER
		//$content .= '<a href="myHours.php?choose=spiderHours"></a>';

		$content .= '<div id="menu">';
		switch($choose)
		{
			case "hours":
				$content .= CREDITHOURS;
			break;
			case "hoursNC":
				$content .= NONCREDITHOURS;
			break;
			case "chart": //-------------------------------- DISPLAY AND EXPORT CHARTS
				$content .= '<form action="myHours.php" method="post" target="_self">'; //--------- TIME FRAME SELECT FORM
				$content .= '<input name="choose" type="hidden" value="'.$choose.'" />';
				$yearFrom = $this->establishDate("year");
				$month = $this->establishDate("month");
				$monthEnd = $this->establishDate("monthEnd");
				$allYears = $this->establishDate("allYears"); //---- ARRAY OF ALL YEARS WITH RECORDED HOURS REPORTS
				if(!empty($allYears)){ rsort($allYears); }

				if($_POST['yearSelection']) {
			 		$yearFrom = date('Y', $_POST['yearSelection']);  //---------- STARTING YEAR IS ESTABLISHER BY USER POST
			 	}
			 	$chart = $this->show_chart_header($yearFrom,$month,$monthEnd,$allYears);
				$content .= $chart;
				$content .= '</form>';
			break;
			default:
			break;
		}
		$content .= '</div>';
		return $content;
	}

	public function showHoursContent($choose) //==================SHOW DOCENT CONTENT
	{
		$content = "";
		//------------------------- SELECT FOR SPIDER
		if($_GET['spider_choose']){
			$choose = $_GET['spider_choose'];
		}
		$content .= '<table class="hours">';

		if($choose == "hours") //						DOCENT CREDIT HOURS or SPIDER HOURS
		{
			$hourSelect = getAll("SELECT type FROM vol_types WHERE guideID = '$this->_myID' ORDER BY type", $this->_conn);
			$content .= '<tr><th colspan="12">Report my ';
			if(!empty($hourSelect))
			{
				foreach($hourSelect as $k => $v){
					foreach($v as $val){
						if($val != "NA"){
							$schedule = get1("SELECT `volunteerType` FROM volunteerType WHERE shortName = '$val'", $this->_conn);
							$scheduleType = get1("SELECT `scheduleType` FROM volunteerType WHERE shortName = '$val'", $this->_conn);
							$content .= '<a href="#" id="hours_'.$val.'_'.$scheduleType.'" class="newHoursReport"><button>'.$schedule.'</button></a>&nbsp;'; // SELECT TYPE OF HOURS
						}
					}
				}
			}
			$content .= 'hours</th></tr>'; // REPORT NEW HOURS

			// VIEW CREDIT HOURS
			if(isset($_GET['showIDhours'])){ $IDhours = $_GET['showIDhours']; }
			$hoursList = $this->show_credit_hours($choose, $this->_myID, $IDhours);

			if(!empty($hoursList))
			{
				$vtab = 0;
				$htab = 0;
				$ctab = 0;
				//----------------------------------------------------------------- HEADER
				$content .= '<tr><td>DATE</td><td>'.strtoupper(VOLUNTEER).'</td><td>HOURS</td>';
				if(!isset($_SESSION['device'])){
					$content .= '<td>TOUR</td><td>THEME</td><td>'.strtoupper(VISITORS).'</td>';
					if(defined('VISITORS2')){ $content .= '<td>'.strtoupper(VISITORS2).'</td>'; }
					$content .= '<td>COMMENTS</td><td>SUGGESTIONS</td>';

					$startDate = $this->getTsmpStartDate();
					$endDate = $startDate + 31536000;
					$content .= '<td><b>

					<a href="print.php?printCrHrs='.$startDate.'_'.$endDate.'_'.$this->_myID.'_all_date_desc&amp;pageType=creditHours" target="_blank">PRINT</a></b></td>';
					//$content .= '<a href="print.php?printCrHrs='.$stringToPass.'&pageType=creditHours" target="_blank">PRINT</a>';
				}
				$content .= '</tr><tr>';
				for($b = 0; $b < count($hoursList); $b++) { //-------------------- DATA
					$thedate = date('m/d/Y', $hoursList[$b]['date']);
					$dutyName = $hoursList[$b]['tour'];
					//if(HOURSVIEW == "all"){
					$guideID = $hoursList[$b]['guideID'];
					$guideName = get1("SELECT CONCAT_WS(' ', fname, lname) FROM guides where guide_id = '$guideID'", $this->_conn);
					//}
					$content .= '<td>'.$thedate.'</td>';
					$content .= '<td><a href="myHours.php?choose='.$choose.'&showIDhours='.$guideID.'">'.$guideName.'</td>';
					$content .= '<td>'.$hoursList[$b]['hours'].'</td>';
					if(!isset($_SESSION['device'])){
						$credits = get1("SELECT credits FROM duties WHERE dutyName = '$dutyName'", $this->_conn); // SHOW THE CREDIT HOURS THIS DUTY HAS BEEN ASSIGNED
						$content .= '<td>'.$dutyName.'<br />(H: '.$credits.')</td>';
						$content .= '<td>'.$hoursList[$b]['theme'].'</td>';
						$content .= '<td>'.$hoursList[$b]['visitors'].'</td>';
						if(defined('VISITORS2')){ $content .= '<td>'.$hoursList[$b]['children'].'</td>'; }
						$content .= '<td><div id="extraComment">'.$hoursList[$b]['comments'].'</div></td>';
						$content .= '<td><div id="extraSuggestion">'.$hoursList[$b]['suggestions'].'</div></td>';
						if($guideID == $this->_myID){
							$content .= '<td><a href="myHours.php?delete='.$hoursList[$b]['id'].'&choose='.$choose.'&hourType='.$hourType.'"
							onclick="return confirm(\'WARNING: this entry will be deleted!\')"
							target="_self">&#10008;</a></td>';
						}
					}else{
						$content .= '<td><span id="'.$hoursList[$b]['id'].'_hours_'.$allHours[$i]['scheduleType'].'_'.$hoursList[$b]['guideID'].'" class="popDetails"> ... </span></td>';
					}
					$content .= '</tr>';

						$vtab = $vtab + $hoursList[$b]['visitors'];
						$ctab = $ctab + $hoursList[$b]['children'];
						if($ctab == 0){ $ctab = ""; }
						$htab = $htab + $hoursList[$b]['hours'];
						$allVisitors = $ctab + $vtab;
				}
					if(!isset($_SESSION['device'])){
						$content .= '<tr><td colspan="5"></td><td><b>'.$vtab.'</b></td><td><b>'.$ctab.'</b></td><td></td></tr>';
					}
					$content .= '<tr><td colspan="2" style="text-align:right;"><b>HOURS TOTAL:</b></td><td><b>'.$htab.'</b></td>';
					if(!isset($_SESSION['device'])){
						$content .= '<td></td><td style="text-align:right;"><b>ALL VISITORS</b>:</td><td style="text-align:center;"><b>'.$allVisitors.'</b></td><td colspan="3"></td>';
					}
					$content .= '</tr>';
			}
			else
			{
				$content .= '<tr><td>No hours entered yet.</td></tr>';
			}
		}

		if($choose == "hoursNC")// ------------------------------------- DOCENT NON-CREDIT HOURS
		{
			$content .= '<tr><th colspan="9" style="padding-left:3em;"><A HREF="#" class="newHoursReport" id="'.$choose.'_hoursNC">REPORT HOURS</a></th></tr>'; //------------ REPORT NEW HOURS
			if(isset($_GET['showIDhours'])){ $IDhours = $_GET['showIDhours']; }
			$hoursList = $this->show_credit_hours($choose, $this->_myID, $IDhours);
			if(!empty($hoursList))
			{
				$htab = 0;
				// ------------------------------------------------------------- HEADER
				$content .= '<tr><td>DATE</td><td>'.strtoupper(VOLUNTEER).'</td><td>HOURS</td>';
				if(!isset($_SESSION['device'])){
					$content .= '<td>ACTIVITY</td><td>DETAILS</td>';
					$startDate = $this->getTsmpStartDate();
					$endDate = $startDate + 31536000;
					$content .= '<td><b><a href="print.php?printNcHrs='.$startDate.'_'.$endDate.'_'.$this->_myID.'_all_date_desc&amp;pageType=ncHours" target="_blank">PRINT</a></b></td></tr><tr>';
				}
				$content .= '</tr>';
				$content .= '<tr>';
				for($b = 0; $b < count($hoursList); $b++) { //--------------------  DATA
					$thedate = date('m/d/Y', $hoursList[$b]['date']);
					$guideID = $hoursList[$b]['guideID'];
					$guideName = get1("SELECT CONCAT_WS(' ', fname, lname) FROM guides where guide_id = '$guideID'", $this->_conn);
					$content .= '<td>'.$thedate.'</td>';
					$content .= '<td><a href="myHours.php?choose='.$choose.'&showIDhours='.$guideID.'">'.$guideName.'</td>';
					$content .= '<td>'.$hoursList[$b]['hours'].'</td>';
					if(!isset($_SESSION['device'])){
						$content .= '<td>'.$hoursList[$b]['activity'].'</td>';
						$content .= '<td><div id="extraSuggestion">'.$hoursList[$b]['details'].'</div></td>';
						$content .= '<td><a href="myHours.php?delete='.$hoursList[$b]['id'].'&choose='.$choose.'"
						onclick="return confirm(\'WARNING: this entry will be deleted!\')"
						target="_self">&#10008;</a></td>';
					}else{
						$content .= '<td><span id="'.$hoursList[$b]['id'].'_hoursNC_docent_'.$hoursList[$b]['guideID'].'" class="popDetails"> ... </span></td>';
					}
					$content .= '</tr>';
						$htab = $htab + $hoursList[$b]['hours'];
				}
					$content .= '<tr><td colspan="2" style="text-align:right;"><b>HOURS TOTAL:</b></td><td><b>'.$htab.'</b></td>';
					if(!isset($_SESSION['device'])){
						$content .= '<td></td><td></td>';
					}
					$content .= '</tr>';
			}
			else
			{
				$content .= '<tr><td>No hours entered yet.</td></tr>';
			}
		}

		if($choose == "chart")// --- DOCENT FULL CHART
 		{
			if($_POST['yearSelection'])
			{
				$yearSelection = $_POST['yearSelection'];
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DISPLAY DATA ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				$docentChart = $this->getBigChart($yearSelection);
				$content .= $docentChart;
			}
 		}
 		$content .= '</table>';
		return $content;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++ SUPPORT FUNCTIONS +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	protected function show_chart_header($yearFrom,$month,$monthEnd,$allYears) // DISPLAY CHART HEADER
	{
		$yearTo = date('Y', (strtotime(YEAR_START.$yearFrom) + 31449600));
		$contents .= '
			<ul>
				<li>
					Select Year:
					<select name="yearSelection">';

					if($_POST['yearSelection']){
						$contents .='<OPTION selected VALUE="'.strtotime(YEAR_START.$yearFrom).'">'.ucfirst($month).' '.$yearFrom.' - '.ucfirst($monthEnd).' '.$yearTo.'</option>';
					}
					if(!empty($allYears)){
						foreach($allYears as $k => $val){
							$yearFromTsp = strtotime(YEAR_START.$val); //------- TIMESTAMP : START TIME (REFLECTS YEAR_START GLOBAL
							$yearFromPrint = $val;
							$toTsp = $yearFromTsp + 31449600;
							$yearToPrint = date('Y', $toTsp); //------- YEAR TO - THE CAL NUMBER

							$contents .='<OPTION VALUE="'.$yearFromTsp.'">'.ucfirst($month).' '.$yearFromPrint.' - '.ucfirst($monthEnd).' '.$yearToPrint.'</option>';
						}
					}
					$contents .='</select>';
					$contents .='&nbsp;<input type="submit" value="SHOW" class="btn" onmouseover="className=\'btnOn\';" onmouseout="className=\'btn\';">';
					if($_POST['yearSelection']){
						$contents .='&nbsp;'.ucfirst($month).' '.$yearFrom.' - '.ucfirst($monthEnd).' '.$yearTo;
						$contents .= '&nbsp;<span class="printButt"><a href="#" class="printChart">PRINT</a></span>';
						if(isset($_SESSION['adminid'])){ $contents .= '&nbsp;<span class="printButt"><a href="export.php?type=chart&my='.$_POST['yearSelection'].'">EXPORT</a></span>'; }
					}
		$contents .= '</li></ul>';
		return $contents;
	}

	protected function getBigChart($yearSelection) // MAIN BIG CHART FUNCTION
	{
		$content = "";
		$content .= '<table class="hours">';
		$guides = getAll($query = "SELECT * FROM guides where admin = 0 ORDER BY lname, fname", $this->_conn);
		$creditHours = getAll($query = "SELECT guideID, date, hours FROM hours ORDER BY guideID", $this->_conn);
		$nChours = getAll($query = "SELECT guideID, date, hours FROM hoursNC ORDER BY guideID", $this->_conn);
		$visitors = getAll($query = "SELECT guideID, date, visitors, children FROM hours ORDER BY guideID", $this->_conn);
		$c = substr(CREDITHOURS, 0, 1); // INITIALS FOR CREDIT HOURS
		$nc = substr(NONCREDITHOURS, 0, 1); // INITIALS FOR NON CREDIT HOURS

		if(!empty($guides))
		{
			$firsttMonth = explode('/', YEAR_START);
			$sm = $firsttMonth[0] - 1; //- fiscal year start month #
			$fullLoop = $sm + 12; // AMOUNT OF LOOPS TO DISPLAY ALL MONTHS NO MATTER WHERE THE START IS

			for($i = 0; $i < count($guides); $i++)
			{
				$id = $guides[$i]['guide_id'];
				$nome = $guides[$i]['fname'].' '.$guides[$i]['lname'];

				$content .= $this->displayCredits($creditHours, $id, $yearSelection, $nome);
				$content .= $this->displayNCredits($nChours, $id, $yearSelection);
				$content .= $this->displayVisitors($visitors, $id, $yearSelection);

			$content .= '</tr>'; //==================== CLOSE TRIPLE TR
			}
			$content .= '<tr><td colspan="2"></td>'; // C-NC-V HEADERS FOR BOTTOM TALLY
			for($x = 0; $x < 12; $x++){
				$content .= '<td class="header">'.$c.'</td><td class="header">'.$nc.'</td><td class="header">V</td>';
			}
			$content .= '<td></td></tr>';

			$content .= $this->totCredits($creditHours, $yearSelection); // find credit hrs total
			$content .= $this->totNCredits($nChours, $yearSelection); // find non-credit hrs total
			$content .= $this->totVisitors($visitors, $yearSelection); // find visitors total
		}
		return $content;
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CHART PARTS +++++++++++++++++++++++++++++++++++++

	protected function displayCredits($creditHours, $id, $yearSelection, $nome) //------------------ BIG CHART: GET CREDIT HOURS
	{

		$c = substr(CREDITHOURS, 0, 1); // INITIALS FOR CREDIT HOURS
		$content .= '<tr><td style="text-align:right;width:13%;padding-right:1em;" rowspan="3">'.$nome; // DOCENT NAME; TRIPLE ROW
		$total = 0; //------------------------- CREDIT HOURS START TAB
		$content .= '<td style="width:2%;text-align:right;padding-right:.3em;">'.$c.'</td>';
		for($a = 0; $a < 12; $a++) //---get all credit hours for the month of july for a specific guide, and add them up. display number in firsty <td>
		{
			$month = $this->getYearMonths($yearSelection, $a);
			$ch = 0;
			for($n = 0; $n < count($creditHours); $n++)
			{
				if($creditHours[$n]['guideID'] == $id && $creditHours[$n]['date'] > $month[0] && $creditHours[$n]['date'] < $month[1])
				{
					$ch = $ch + $creditHours[$n]['hours'];
				}
			}

			if($a % 2)
			{
				if($ch != 0)
				$content .= '<td class="c">'.$ch.'</td><td></td><td></td>';
				else
				$content .= '<td class="c"></td><td></td><td></td>';
			}
			else
			{
				if($ch != 0)
				$content .= '<td class="c">'.$ch.'</td><td></td><td></td>';
				else
				$content .= '<td class="c"></td><td></td><td></td>';
			}

			$total = $total + $ch;
		}
		$content .= '<td class="c">'.$total.'</td>';//---------- total box
		$content .= '</tr>';
		return $content;
	}

	protected function displayNCredits($nChours, $id, $yearSelection) //------------------------- BIG CHART: GET NON CREDIT HOURS
	{
		$nc = substr(NONCREDITHOURS, 0, 1); // INITIALS FOR NON CREDIT HOURS
		$content = "";
		$total = 0;
		$content .= '<tr><td style="width:2%;text-align:right;padding-right:.3em;">'.$nc.'</td>'; //------------------------- non credit hours

		for($a = 0; $a < 12; $a++)
		{
			$month = $this->getYearMonths($yearSelection, $a);
			$ch = 0;
			for($n = 0; $n < count($nChours); $n++)
			{
				if($nChours[$n]['guideID'] == $id && $nChours[$n]['date'] > $month[0] && $nChours[$n]['date'] < $month[1])
				{
					$ch = $ch + $nChours[$n]['hours'];
				}
			}
			if($a % 2)
			{
				if($ch != 0)
				$content .= '<td class="c"></td><td>'.$ch.'</td><td></td>';
				else
				$content .= '<td class="c"></td><td></td><td></td>';
			}
			else
			{
				if($ch != 0)
				$content .= '<td class="c"></td><td>'.$ch.'</td><td></td>';
				else
				$content .= '<td class="c"></td><td></td><td></td>';
			}

			$total = $total + $ch;
		}
		$content .= '<td class="c">'.$total.'</td>';
		$content .= '</tr>';
		return $content;
	}

	protected function displayVisitors($visitors, $id, $yearSelection) //------------------ BIG CHART: GET VISITORS
	{
		$c = substr(CREDITHOURS, 0, 1); // INITIALS FOR CREDIT HOURS
		$nc = substr(NONCREDITHOURS, 0, 1); // INITIALS FOR NON CREDIT HOURS
		$content = "";
		$total = 0;
		$content .= '<tr style="border-bottom:2px solid#bfbfbf;"><td style="width:2%;text-align:right;padding-right:.3em;">V</td>';

		for($a = 0; $a < 12; $a++)
		{
			$month = $this->getYearMonths($yearSelection, $a);

			$viz = 0;
			for($n = 0; $n < count($visitors); $n++)
			{
				if($visitors[$n]['guideID'] == $id && $visitors[$n]['date'] > $month[0] && $visitors[$n]['date'] < $month[1])
				{
					$allVisitors = $visitors[$n]['visitors'] + $visitors[$n]['children'];
					$viz = $viz + $allVisitors;
				}
			}
			if($a % 2)
			{
				if($viz != 0)
				$content .= '<td class="c"></td><td></td><td>'.$viz.'</td>';
				else
				$content .= '<td class="c"></td><td></td><td></td>';
			}
			else
			{
				if($viz != 0)
				$content .= '<td class="c"></td><td></td><td>'.$viz.'</td>';
				else
				$content .= '<td class="c"></td><td></td><td></td>';
			}
			$total = $total + $viz;
		}
		$content .= '<td class="c">'.$total.'</td>';
		$content .= '</tr>';
		return $content;
	}

	protected function totCredits($creditHours, $yearSelection) // BIG CHART: GET TOTAL CREDITS
	{
		$content = "";
		$content .= '<tr><td colspan="2">'.CREDITHOURS.'</td>';

		$ttl = 0;
		for($a = 0; $a < 12; $a++)
		{
		$month = $this->getYearMonths($yearSelection, $a);
		$allC = 0;
			for($n = 0; $n < count($creditHours); $n++)
			{
				if($creditHours[$n]['date'] > $month[0] && $creditHours[$n]['date'] < $month[1])
				{
					$allC = $allC + $creditHours[$n]['hours'];
				}
			}
			$ttl = $ttl + $allC;
			$content .= '<td>'.$allC.'</td><td></td><td></td>';
		}
		$content .= '<td>'.$ttl.'</td>';
		$content .= '</tr>';
		return $content;
	}

	protected function totNCredits($nChours, $yearSelection) // BIG CHART: GET TOTAL non CREDITS
	{
		$content = "";
		$content .= '<tr><td colspan="2">'.NONCREDITHOURS.'</td>';

		$totl = 0;
		for($a = 0; $a < 12; $a++)
		{
		$month = $this->getYearMonths($yearSelection, $a);
		$nch = 0;
			for($m = 0; $m < count($nChours); $m++)
			{
				if($nChours[$m]['date'] > $month[0] && $nChours[$m]['date'] < $month[1])
					{
						$nch = $nch + $nChours[$m]['hours'];
					}
			}

			$totl = $totl + $nch;
			$content .= '<td></td><td>'.$nch.'</td><td></td>';
		}
		$content .= '<td>'.$totl.'</td>';
		$content .= '</tr>';
		return $content;
	}

	protected function totVisitors($visitors, $yearSelection) // BIG CHART: GET TOTAL VISITORS
	{
		$content = "";
		$content .= '<tr><td colspan="2">Visitors</td>';

		$tl = 0;
		for($a = 0; $a < 12; $a++)
		{
		$month = $this->getYearMonths($yearSelection, $a);
		$vis = 0;
			for($p = 0; $p < count($visitors); $p++)
			{
				if($visitors[$p]['date'] > $month[0] && $visitors[$p]['date'] < $month[1])
				{
					$allVis = $visitors[$p]['visitors'] + $visitors[$p]['children'];
					$vis = $vis + $allVis;
				}
			}
			$tl = $tl + $vis;
			$content .= '<td></td><td></td><td>'.$vis.'</td>';
		}
		$content .= '<td>'.$tl.'</th>';
		$content .= '</tr>';
		return $content;
	}

	public function show_chart_masthead() //== BIG CHART: DISPLAY ABBREVIATED MONTHS NAMES AND HOURS CATEGORIES AT TOP (C, NC, V) - THIS GOES IN THE COMMANDS DIV
	{
		if($_POST['yearSelection']){
			$monthsArray = array( 'January','February','March','April','May','June','July ','August','September','October','November','December', 'January','February','March','April','May','June','July ','August','September','October','November','December');
			$firsttMonth = explode('/', YEAR_START);
			$sm = $firsttMonth[0] - 1; //- fiscal year start month #
			$fullLoop = $sm + 12; // AMOUNT OF LOOPS TO DISPLAY ALL MONTHS NO MATTER WHERE THE START IS

			$content .= '<div id="commands" style="padding:0;"><table class="monthsHeader">';
			$content .= '<tr>
			<th style="width:16.6%;"></th>'; //------------- MONTHS NAMES HEADER
			for($i = $sm; $i < $fullLoop; $i++) {
				$content .= '<th style="text-align:center" colspan="3">'.strtoupper(substr($monthsArray[$i], 0, 3)).'</th>';
			}

			$content .= '<th style="text-align:center" colspan="3">Tot</th>';
			$content .= '</tr>';

			$content .= '</table></div>';
		}
		return $content;
	}


	protected function show_credit_hours($table, $guide, $IDhours) //========== FIND ALL CREDIT AND NON-CREDIT HOURS FOR DOCENTS VIEW
	{
		// GET A TIMESTAMP OF THE BEGINNING DATE OF FISCAL YEAR

		$startDateTsmp = $this->getTsmpStartDate();
		if($table == "spider_choose")
		{
			$query = getAll("SELECT * FROM hours ORDER BY date desc", $this->_conn);
		}
		else
		{
			if(HOURSVIEW == "single") // SHOW JUST THE LOGGED DOCENT HOURS
			$query = getAll("SELECT * FROM $table WHERE guideID = '$guide' and date > '$startDateTsmp' ORDER BY date desc", $this->_conn);

			if(HOURSVIEW == "all") // SHOW ALL DOCENTS HOURS
			{
				if(!empty($IDhours)){
					$query = getAll("SELECT * FROM $table WHERE guideID = '$IDhours' and date > '$startDateTsmp' ORDER BY date desc", $this->_conn);
				}else{
					$query = getAll("SELECT * FROM $table WHERE date > '$startDateTsmp' ORDER BY date desc", $this->_conn);
				}
			}
		}
   		return $query;
	}

	protected function udLinks($choose,$from,$to,$guides,$sites,$selector) //========== PRINT SORTING ARROW-LINKS IN CREDIT HEADERS
	{
		$upNdown = '&nbsp;<a class="upDnArrows" href="adminHours.php?a_choose='.$choose.'&from='.$from.'&to='.$to.'&guides='.$guides.'&sites='.$sites.'&selectBy='.$selector.'&asc=desc" target="_self">&#x25BC;</a>
					 &nbsp;<a class="upDnArrows" href="adminHours.php?a_choose='.$choose.'&from='.$from.'&to='.$to.'&guides='.$guides.'&sites='.$sites.'&selectBy='.$selector.'&asc=asc" target="_self">&#x25B2;</a>';
		return $upNdown;
	}

	protected function udLinksNC($choose,$from,$to,$guides,$act,$selector) //======== PRINT SORTING ARROW-LINKS IN NON-CREDIT HEADERS
	{
		$upNdown = '&nbsp;<a class="upDnArrows" href="adminHours.php?a_choose='.$choose.'&from='.$from.'&to='.$to.'&guides='.$guides.'&act='.$act.'&selectBy='.$selector.'&asc=desc" target="_self">&#x25BC;</a>
					 &nbsp;<a class="upDnArrows" href="adminHours.php?a_choose='.$choose.'&from='.$from.'&to='.$to.'&guides='.$guides.'&act='.$act.'&selectBy='.$selector.'&asc=asc" target="_self">&#x25B2;</a>';
		return $upNdown;
	}

	protected function establishDate($sel) //=============================== ESTABLISH CURRENT YEAR
	{
		$t = time(); //- current day-time
		$ht = date('m-d-Y',$t); //- readable date
		$pcs = explode('-', $ht);
		$m = $pcs[0]; //- isolate m
		$year = $pcs[2]; //- current year

		$startMonth = explode('/', YEAR_START);
		$sm = $startMonth[0]; //- fiscal year start month #
		$monthName = $this->monthName($sm);

		$endMonth = explode('/', YEAR_END);
		$em = $endMonth[0]; //- fiscal year end month #
		$monthEndName = $this->monthName($em);

		if($m < $sm){
			$yearF = $year - 1;
		}else{
			$yearF = $year;
		}
		//---------------------------------------------- SEARCH DB FOR HOURS REPORTING BEGINNING YEAR
		if($sel == "allYears"){
			$dates = getRow("SELECT date FROM hours ORDER BY date ASC", $this->_conn); //--- GET ALL TIMESTAMP DATES, ASCENDING ORDER
			$datesNC = getRow("SELECT date FROM hoursNC ORDER BY date ASC", $this->_conn); //--- GET ALL TIMESTAMP DATES, ASCENDING ORDER
			if(!empty($dates)){
				foreach($dates as $k => $val){//--- GET THE YEAR IN XXXX FORMAT FROM THE HOURS TABLE
					$yearNum[] = $this->findYear($val);
				}
			}
			if(!empty($yearNum)){ $allYears = array_unique(array_values($yearNum)); }

			if(!empty($datesNC)){
				foreach($datesNC as $k => $val){//--- GET THE YEAR IN XXXX FORMAT FROM THE HOURS TABLE
					$yearNumNC[] = $this->findYear($val);
				}
			}
			if(!empty($yearNumNC)){
				$allYearsNC = array_unique(array_values($yearNumNC));
				$arrayMerged = array_merge($allYears, $allYearsNC);
				$arrayMergedClean = array_unique(array_values($arrayMerged));
				sort($arrayMergedClean);
			}
 		}
		if($sel == "year"){ return $yearF; } //- year from
		if($sel == "month"){ return $monthName; } //- first month of year cycle
		if($sel == "monthEnd"){ return $monthEndName; } //- last month of year cycle
		if($sel == "allYears"){ return $allYears; } //- ARRAY OF YEARS THAT HAVE REPORTED HOURS
	}

	protected function findYear($year) //=========================== GET YEAR # FROM TIMESTAMP
	{
		$dte = date('m-d-Y',$year); //- readable date
		$elems = explode('-', $dte);
		$theMonth =  $elems[0]; //---------- HOUR REPORT MONTH
		$m = explode('/', YEAR_START);
		$firstMonth = $m[0]; //-------------- FIRST MONTH OF CYCLE
		$theYear = $elems[2];

		if($theMonth > $firstMonth){ $year = $theYear; }else{ $year = $theYear - 1; }
		return $year;
	}

	protected function getTsmpStartDate() // RETURN A TIMESTAMP OF THE BEGINNING DATE OF FISCAL YEAR
	{
		$t = time(); //- current day-time
		$ht = date('m-d-Y',$t); //- today's date
		$pcs = explode('-', $ht);
		$m = $pcs[0]; //- isolate m
		$d = $pcs[1]; //- isolate d
		$year = $pcs[2]; //- isolate y

		$mon = explode('/', YEAR_START);
		$firstMonth = $mon[0];

		if($m <= $firstMonth){
		$year = --$year;
		}
		$year = strval($year);
		$ddate = strtotime(YEAR_START.$year);
		return $ddate;
	}

	public function getYearMonths($yearSelection, $cron){ // TIMESTAMP OF BEGINNING MONTH FOR THE YEAR + LOOP #
		$m = explode('/', YEAR_START);
		$mo = $m[0]; // FIRST CALENDAR MONTH ACCORDING TO YEAR_START (7)
		$diff = 12 - $mo; // 5
		$year = date('Y', $yearSelection); //- year # (ex: 2015)

		if($cron > $diff){
			$mo1 = $cron - $diff;
			$mo2 = $mo1 + 1;
			$year = $year + 1;
			$s = strtotime($mo1.'/1/'.$year.' 12:00 am');
			$e = strtotime($mo2.'/1/'.$year.' 12:00 am');
		}else{
			$mo1 = $mo + $cron;
			if($mo1 == 12){ // BETWEEN DECEMBER AND JANUARY
				$mo2 = 1;
				$s = strtotime($mo1.'/1/'.$year.' 12:00 am');
				$year2 = $year + 1;
				$e = strtotime($mo2.'/1/'.($year2).' 12:00 am');
			}else{
				$mo2 = $mo1 + 1;
				$s = strtotime($mo1.'/1/'.$year.' 12:00 am');
				$e = strtotime($mo2.'/1/'.$year.' 12:00 am');
			}
		}
		$allMonths = array(0=> $s, $e);
		return $allMonths;
	}

	protected function getDutyArrays($type)
	{
		$docentsDutyList = getAll("SELECT * FROM duties where hoursOO = 1 AND $type = 1 ORDER BY seq asc", $this->_conn);
		return $docentsDutyList;
	}

	//							GET MONTH NAME
	protected function monthName($val)
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

	protected function getVolTypeName($t, $conn)
	{
		$tName = getRow("SELECT `volunteerType`, `scheduleType` FROM volunteerType WHERE shortName = '$t'", $conn);
		return $tName;
	}

} //----- END OF CLASS
