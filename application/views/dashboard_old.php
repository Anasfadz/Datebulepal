<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Datepicker Example</title>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  $("#datepicker").datepicker();
});
</script>
</head>
<body>
<div>
    <h1>Hello <?php print_r($user["name"])?>,</h1>  
</div>

<div>
    <h1> <?php $diff = date_diff(date_create($date), date_create($user_setting["last_period"]));
    $diff2 = $diff->format("%R%a");
    if($diff2 <= -1)
    {
        $diff3 = $diff2 * -1;
        if($diff3 <= $user_setting["day_last"])
        {
            echo "hey looks like this is your day ".$diff3." of your period";
        }
        else
        {
            $day_add = $user_setting["day_last"]+ $user_setting["day_length"] . " days";
            $date = date_add(date_create($user_setting["last_period"]), 
            date_interval_create_from_date_string($day_add));
            echo "your next period will hit on " . date_format($date, "d/m/Y");
        }

    }
    ?></h1>  
</div>

<div>
    <?php ?>
</div>


<div <?php if($user["first_time"] == 0){ echo "hidden";}?>>
<h4>Menstrual cycle Settings</h4>
    <form action="user_setting" method="post">
        <input type="text" id="user_id" name="user_id" value= <?php echo $user["id"] ?> hidden>
        <label for="datepicker">First Day of Your Last Period:</label>
        <input type="text" id="datepicker" 
        value = <?php if($user_setting["last_period"] != "")
        {echo date_format(date_create($user_setting["last_period"]), "d/m/Y");}
        else
        {echo "";}?> name="last_period">
        <br>
        <label for="day_last">Average day of your period</label>
        <select id="day_last" name="day_last">
            <?php if($user_setting["day_last"]) {?>
                <option value= <?php echo $user_setting["day_last"] ?>> <?php echo $user_setting["day_last"] ?> Days</option>
            <?php } else{ ?>
            <option value="">Select Days</option>
            <?php } ?>
            <option value= "1" > 1 day</option>
            <?php for($i=2; $i <= 10 && $i != $user_setting["day_last"]; $i++) {?>
            <option value= "<?php echo $i ?>" > <?php echo $i ?> days</option>
            <?php }?>
        </select>
        <br>
        <label for="day_length">Average days to your next period (after your period ends)</label>
        <select id="day_length" name="day_length">
            <?php if($user_setting["day_length"]) {?>
            <option value= <?php echo $user_setting["day_length"] ?> > <?php echo $user_setting["day_length"] ?> Days</option>
            <?php } else { ?>
            <option value="">Select Days</option>
            <?php } ?>
            <?php for($i=22; $i <= 44; $i++) {?>
            <option value= <?php echo $i ?> > <?php echo $i ?> days</option>
            <?php }?>
        </select>
        <br>
        <input type="submit" value="Submit">
    </form>

</div>

<div style="padding-top: 20px;">
    <a href="set_first_time"><button>Change Setting</button></a>
</div>

<div style="padding-top: 20px;">
    <a href="logout"><button>logout</button></a>
</div>

</body>
</html>

