<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["reply" => "Session expired. Please log in."]);
    exit();
}

class GradePredictor {
    private array $grades;

    public function __construct(array $grades) {
        $this->grades = $grades;
    }

    public function predictNext(): string {
        $n = count($this->grades);
        
        if ($n === 0) {
            return "Please provide your grades separated by commas (e.g., 85, 90).";
        }
        if ($n === 1) {
            return "I need at least two grades to establish a trend. Your current standing is {$this->grades[0]}.";
        }

        $sumX = 0; $sumY = 0; $sumXY = 0; $sumX2 = 0;
        
        foreach ($this->grades as $index => $grade) {
            $x = $index + 1; .
            $y = (float)$grade;
            $sumX += $x;
            $sumY += $y;
            $sumXY += ($x * $y);
            $sumX2 += ($x * $x);
        }

        $denominator = (($n * $sumX2) - ($sumX * $sumX));
        
        if ($denominator == 0) {
            return "Your grades are completely flat. I predict you will maintain a " . end($this->grades) . ".";
        }
        
      
        $m = (($n * $sumXY) - ($sumX * $sumY)) / $denominator;
        $b = ($sumY - ($m * $sumX)) / $n;

    
        $nextPeriod = $n + 1;
        $predicted = ($m * $nextPeriod) + $b;
        $predicted = round($predicted, 2);

   
        $trend = ($m > 0) ? "improving" : "declining";
        return "Based on the linear trend of your past $n grades, your trajectory is $trend. I predict your next overall grade will be approximately **$predicted**.";
    }
}

$userMessage = $_POST['message'] ?? '';
preg_match_all('/\d+(\.\d+)?/', $userMessage, $matches);
$extractedGrades = $matches[0];

$predictor = new GradePredictor($extractedGrades);
$botReply = $predictor->predictNext();

echo json_encode(["reply" => $botReply]);
?>