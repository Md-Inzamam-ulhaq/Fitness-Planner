<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Planner</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file if needed -->
</head>
<body>
<ul class="nav__links">
    <li class="link"><a href=""><img src="logo.png" alt="Logo"></a></li>
    <li class="link"><a href="home.php">Home</a></li>
    <li class="link"><a href="planner.php">Planner</a></li>
    <li class="link"><a href="#">Service</a></li>
    <li class="link"><a href="profile.php">Profile</a></li>
    <li class="link"><a href="#">Community</a></li>
</ul>

<div>
    <h2>Generate Your Fitness Plan</h2>
    <form method="POST" action="">
        <label for="goal">Select Goal:</label>
        <select name="goal" id="goal">
            <option value="Weight Loss">Weight Loss</option>
            <option value="Muscle Gain">Muscle Gain</option>
            <option value="General Fitness">General Fitness</option>
        </select>
        <label for="plan_type">Select Plan Type:</label>
        <select name="plan_type" id="plan_type">
            <option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
            <option value="Monthly">Monthly</option>
        </select>
        <input type="submit" value="Generate Plan">
    </form>

    <?php
    session_start();
    include 'db_connect.php'; // Make sure your db_connect.php file is correctly set up
    if (!isset($_SESSION['username'])) {
        header("Location: login.html");
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['username'];
        $goal = $_POST['goal'];
        $plan_type = $_POST['plan_type'];

        // Fetch user data using prepared statements
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user_result = $stmt->get_result();
        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $height = $user['height'];
            $weight = $user['weight'];
        } else {
            die("No user found.");
        }
        $stmt->close();
        // Generate a personalized plan based on user's data and fitness goal
        $plan = generatePlan($height, $weight, $goal, $plan_type);

        // Display the plan in a table format
        echo "<h2>Your $plan_type Plan for $goal</h2>";
        echo "<table>
                <tr>
                    <th>Time</th>
                    <th>Activity</th>
                    <th>Diet</th>
                </tr>";
        foreach ($plan as $entry) {
            echo "<tr>
                    <td>{$entry['time']}</td>
                    <td>{$entry['activity']}</td>
                    <td>{$entry['diet']}</td>
                  </tr>";
        }
        echo "</table>";
    }
    $conn->close();

    function generatePlan($height, $weight, $goal, $plan_type) {
        $plan = [];
        // Example logic for generating a plan
        if ($goal == 'Weight Loss') {
            if ($plan_type == 'Daily') {
                $plan[] = ['time' => 'Morning', 'activity' => '30 minutes of moderate cardio (e.g., brisk walking, cycling)', 'diet' => 'Low-calorie meals, high in protein and vegetables, avoid sugary snacks.'];
                $plan[] = ['time' => 'Afternoon', 'activity' => '20 minutes of strength training (focus on full-body exercises)', 'diet' => 'Balanced meal with lean protein and vegetables.'];
                $plan[] = ['time' => 'Evening', 'activity' => '15 minutes of yoga or stretching', 'diet' => 'Light dinner with salad and lean protein.'];
            } elseif ($plan_type == 'Weekly') {
                $plan[] = ['time' => 'Mon-Fri', 'activity' => '30 minutes of cardio daily', 'diet' => 'Balanced meals, focus on portion control, include fruits and vegetables.'];
                $plan[] = ['time' => 'Wed-Sat', 'activity' => '45 minutes of strength training (alternate muscle groups)', 'diet' => 'High-protein meals, avoid processed foods.'];
                $plan[] = ['time' => 'Sun', 'activity' => 'Active rest (light walking or swimming)', 'diet' => 'Light meals, focus on hydration.'];
            } elseif ($plan_type == 'Monthly') {
                $plan[] = ['time' => 'Weeks 1-3', 'activity' => 'Cardio 5 days a week, strength training 3 days a week', 'diet' => 'Consistent low-calorie intake, avoid processed foods, drink plenty of water.'];
                $plan[] = ['time' => 'Week 4', 'activity' => 'Mix of cardio and lighter strength exercises', 'diet' => 'Maintain balanced diet, focus on recovery.'];
            }
        } elseif ($goal == 'Muscle Gain') {
            if ($plan_type == 'Daily') {
                $plan[] = ['time' => 'Morning', 'activity' => '15 minutes of light cardio (e.g., jogging)', 'diet' => 'High-protein breakfast.'];
                $plan[] = ['time' => 'Afternoon', 'activity' => '60 minutes of strength training (focus on one muscle group)', 'diet' => 'Protein-rich meal (e.g., lean meats, legumes).'];
                $plan[] = ['time' => 'Evening', 'activity' => 'Light stretching or yoga', 'diet' => 'Balanced dinner with complex carbs and healthy fats.'];
            } elseif ($plan_type == 'Weekly') {
                $plan[] = ['time' => 'Mon, Wed, Fri', 'activity' => 'Heavy strength training (target different muscle groups)', 'diet' => 'High-protein meals, include post-workout supplements.'];
                $plan[] = ['time' => 'Tue, Thu', 'activity' => '30 minutes of cardio', 'diet' => 'Balanced meals with complex carbs.'];
                $plan[] = ['time' => 'Sat', 'activity' => 'Full-body workout', 'diet' => 'High-protein meals, focus on recovery.'];
                $plan[] = ['time' => 'Sun', 'activity' => 'Rest and recovery', 'diet' => 'Light meals, focus on hydration.'];
            } elseif ($plan_type == 'Monthly') {
                $plan[] = ['time' => 'Weeks 1-3', 'activity' => 'Strength training 4 days a week, cardio 2 days', 'diet' => 'Increase calorie intake with a focus on protein and nutrient-dense foods.'];
                $plan[] = ['time' => 'Week 4', 'activity' => 'Active recovery and flexibility exercises', 'diet' => 'Maintain balanced diet, focus on recovery.'];
            }
        } elseif ($goal == 'General Fitness') {
            if ($plan_type == 'Daily') {
                $plan[] = ['time' => 'Morning', 'activity' => '20 minutes of mixed cardio (e.g., running, cycling)', 'diet' => 'Balanced breakfast with protein and carbs.'];
                $plan[] = ['time' => 'Afternoon', 'activity' => '30 minutes of strength and conditioning', 'diet' => 'Balanced lunch with lean protein and vegetables.'];
                $plan[] = ['time' => 'Evening', 'activity' => 'Light stretching or yoga', 'diet' => 'Light dinner with salad and lean protein.'];
            }
        }
        return $plan;
    }
    ?>
</div>
</body>
</html> 
