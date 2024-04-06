<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datepicker Example</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1, h4 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"], button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            $("#datepicker").datepicker();
        });
    </script>
</head>
<body>
<div class="container">
    <h1>Hello <?php echo $user["name"]; ?>,</h1>
    
    <div>
        <?php
        $diff = date_diff(date_create($date), date_create($user_setting["last_period"]));
        $diff2 = $diff->format("%R%a");
        if($diff2 <= -1) {
            $diff3 = $diff2 * -1;
            if($diff3 <= $user_setting["day_last"]) {
                echo "<h1>Hey, looks like this is your day ".($diff3 + 1)." of your period</h1>";
            }
        }

        $day_add = $user_setting["day_last"] + $user_setting["day_length"] . " days";
        $date = date_add(date_create($user_setting["last_period"]), date_interval_create_from_date_string($day_add));
        echo "<h1>Your next period will hit on " . date_format($date, "d/m/Y") . "</h1>";
        ?>
    </div>

    <div>
        <!-- Placeholder for any additional content -->
    </div>

    <div <?php if($user["first_time"] == 0) { echo "hidden"; } ?>>
        <h4>Menstrual Cycle Settings</h4>
        <form action="user_setting" method="post">
            <input type="text" id="user_id" name="user_id" value= <?php echo $user["id"] ?> hidden>
            <label for="datepicker">First Day of Your Last Period:</label>
            <input type="text" id="datepicker" value="<?php echo ($user_setting["last_period"] != "") ? date_format(date_create($user_setting["last_period"]), "d/m/Y") : ''; ?>" name="last_period">
            <br>
            <label for="day_last">Average Day of Your Period</label>
            <select id="day_last" name="day_last">
                <?php if($user_setting["day_last"]) {?>
                    <option value= "<?php echo $user_setting["day_last"] ?>" ><?php echo $user_setting["day_last"] ?> Days</option>
                <?php } else { ?>
                    <option value="">Select Days</option>
                <?php } ?>
                <option value="1">1 day</option>
                <?php for($i=2; $i <= 10 && $i != $user_setting["day_last"]; $i++) {?>
                    <option value="<?php echo $i ?>"><?php echo $i ?> days</option>
                <?php } ?>
            </select>
            <br>
            <label for="day_length">Average Days to Your Next Period (After Your Period Ends)</label>
            <select id="day_length" name="day_length">
                <?php if($user_setting["day_length"]) {?>
                    <option value="<?php echo $user_setting["day_length"] ?>"><?php echo $user_setting["day_length"] ?> Days</option>
                <?php } else { ?>
                    <option value="">Select Days</option>
                <?php } ?>
                <?php for($i=22; $i <= 44; $i++) {?>
                    <option value="<?php echo $i ?>"><?php echo $i ?> days</option>
                <?php } ?>
            </select>
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>

    <div style="text-align: center; padding-top: 20px;" <?php if($user["first_time"] == 1) { echo "hidden"; } ?>>
        <a href="set_first_time"><button>Change Setting</button></a>
    </div>

    <div style="text-align: center; padding-top: 20px;">
        <a href="logout"><button>Logout</button></a>
    </div>
</div>

</body>
</html>
