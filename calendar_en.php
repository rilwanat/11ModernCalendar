<?php
/**
 **/

$servername = "localhost";
$username = "croot"; //"mydemosuser";//
$password = "sroot"; //"akELd4oRiL9k";//
$database = "my_demos";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
$heroes = array();
$heroesfname = array();
$sql = "SELECT Birthday, Fname FROM civil_table;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($bda, $fna);
while ($stmt->fetch()) {
    $temp = $bda;
    array_push($heroes, $temp);

    $tempname = $fna;
    array_push($heroesfname, $tempname);
}

class Calendar
{
    /**
     ** Constructor
     **/
    public function __construct()
    {
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
    /********************* PROPERTY ********************/
    private $dayLabels = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    private $naviHref = null;
    private $highlight_dates;

    private $highlight_fnames;

    /********************* PUBLIC **********************/
    /**
     ** Print out the calendar
     **/
    public function show()
    {
        global $heroes;
        $this->highlight_dates = $heroes;

        global $heroesfname;
        $this->highlight_fnames = $heroesfname;

        $year = null;
        $month = null;
        if (null == $year && isset($_GET['year'])) {
            $year = htmlentities($_GET['year'], ENT_QUOTES);
        } elseif (null == $year) {
            $year = date("Y", time());
        }
        if ((!is_numeric($year)) || ($year == "")) {
            $year = date("Y", time());
        }
        if (null == $month && isset($_GET['month'])) {
            $month = htmlentities($_GET['month'], ENT_QUOTES);
        } elseif (null == $month) {
            $month = date("m", time());
        }
        if ((!is_numeric($month)) || ($month == "")) {
            $month = date("m", time());
        }
        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->daysInMonth = $this->_daysInMonth($month, $year);
        $content = '<div id="calendar">' . "\r\n" . '<div class="calendar_box">' . "\r\n" . $this->_createNavi() . "\r\n" . '</div>' . "\r\n" . '<div class="calendar_content">' . "\r\n" . '<div class="calendar_label">' . "\r\n" . $this->_createLabels() . '</div>' . "\r\n";
        $content .= '<div class="calendar_clear"></div>' . "\r\n";
        $content .= '<div class="calendar_dates">' . "\r\n";
        $weeksInMonth = $this->_weeksInMonth($month, $year);
        // Create weeks in a month
        for ($i = 0; $i < $weeksInMonth; $i++) {
            // Create days in a week
            for ($j = 1; $j <= 7; $j++) {
                $content .= $this->_showDay($i * 7 + $j);
            }
        }
        $content .= '</div>' . "\r\n";
        $content .= '<div class="calendar_clear"></div>' . "\r\n";
        $content .= '</div>' . "\r\n";
        $content .= '</div>' . "\r\n";
        return $content;
    }
    /********************* PRIVATE **********************/
    /**
     ** Create the calendar days
     **/
    private function _showDay($cellNumber)
    {
        if ($this->currentDay == 0) {
            $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));
            if (intval($cellNumber) == intval($firstDayOfTheWeek)) {
                $this->currentDay = 1;
            }
        }
        if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {
            $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;
        } else {
            $this->currentDate = null;
            $cellContent = null;
        }
        // hard way of testing if the day being displayed is today
        //$today_day = date("d");
        //$today_mon = date("m");
        //$today_yea = date("Y");
        //$class_day = ($cellContent == $today_day && $this->currentMonth == $today_mon && $this->currentYear == $today_yea ? "calendar_today" : "calendar_days");

        // easy way of testing if the day being displayed is today
        $today = date('Y-m-d');
        $class_day = $this->currentDate == $today ? "calendar_today" : "calendar_days";

        //echo json_encode($this->highlight_dates);
        //echo json_encode($this->currentDate);

        $bday = $this->currentDay - 1;

        /*
        //$key = array_search($this->currentDate, $this->highlight_dates); //first match ONLY
        //++$key;
        //echo $key." ";
         */

        /*
        $keys = array_keys($this->highlight_dates, $this->currentDate); //all matches
        //if (count($keys) > 0) {
        // At least one match...
        //}
        for ($ky = 0; $ky < count($keys); $ky++) {
        echo ++$keys[$ky] . " " . count($keys) . ", ";
        }
         */

        // to add highlighting or different cellContent do that here
        if (in_array($this->currentDate, $this->highlight_dates)) {
            $class_day = "calendar_birthday"; // uses the existing 'today' css. change as needed
            //$cellContent = '<a href="link.php?key=' . $key . '">' . $bday . '</a>'; // produce the desired content (link) as needed
            $cellContent = '<a href="link.php?bdate=' . $this->currentDate . '">' . $bday . '</a>'; // produce the desired content (link) as needed
            //$cellContent = $this->currentDay;
        }

        return '<div class="' . $class_day . '">' . $cellContent . '</div>' . "\r\n";
    }
    /**
     ** Create navigation
     **/
    private function _createNavi()
    {
        $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth) + 1;
        $nextYear = $this->currentMonth == 12 ? intval($this->currentYear) + 1 : $this->currentYear;
        $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth) - 1;
        $preYear = $this->currentMonth == 1 ? intval($this->currentYear) - 1 : $this->currentYear;
        return '<div class="calendar_header">' . "\r\n" . '<a class="calendar_prev" href="' . $this->naviHref . '?month=' . sprintf('%02d', $preMonth) . '&amp;year=' . $preYear . '">Prev</a>' . "\r\n" . '<span class="calendar_title">' . date('Y M', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')) . '</span>' . "\r\n" . '<a class="calendar_next" href="' . $this->naviHref . '?month=' . sprintf("%02d", $nextMonth) . '&amp;year=' . $nextYear . '">Next</a>' . "\r\n" . '</div>';
    }
    /**
     ** Create calendar week labels
     **/
    private function _createLabels()
    {
        $content = '';
        foreach ($this->dayLabels as $index => $label) {
            $content .= '<div class="calendar_names">' . $label . '</div>' . "\r\n";
        }
        return $content;
    }
    /**
     ** Calculate number of weeks in a particular month
     **/
    private function _weeksInMonth($month = null, $year = null)
    {
        if (null == ($year)) {
            $year = date("Y", time());
        }
        if (null == ($month)) {
            $month = date("m", time());
        }
        // Find number of days in this month
        $daysInMonths = $this->_daysInMonth($month, $year);
        $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);
        $monthEndingDay = date('N', strtotime($year . '-' . $month . '-' . $daysInMonths));
        $monthStartDay = date('N', strtotime($year . '-' . $month . '-01'));
        if ($monthEndingDay < $monthStartDay) {
            $numOfweeks++;
        }
        return $numOfweeks;
    }
    /**
     ** Calculate number of days in a particular month
     **/
    private function _daysInMonth($month = null, $year = null)
    {
        if (null == ($year)) {
            $year = date("Y", time());
        }

        if (null == ($month)) {
            $month = date("m", time());
        }

        return date('t', strtotime($year . '-' . $month . '-01'));
    }
}
$calendar = new Calendar();
echo $calendar->show();
