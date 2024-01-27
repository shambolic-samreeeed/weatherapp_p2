<?php
/* header('Content-Type: application/json');
$city_name="Dibrugarh";
function fetch_weather_data(){
    global $city_name;
    $api_key="7af5331f2d5f06a34fcb20d6f92962a0";
    $url="http://api.openweathermap.org/data/2.5/weather?units=metric&q=";

    $json_data= file_get_contents($url);
    $response_data= json_decode($json_data);

    if ($response_data===null || isset($response_data->cod)&& $response_data->cod !==200){
        return false;
    }

    if ($response_data->cod === 200){
        $day_of_week=date('D');
        $day_and_date = date('M j, Y');
        $weather_condition=$response_data-> weather[0]-> description;
        $weather_icon=$response_data->main->icon;
        $temperature=$response_data->main->temp;
        $pressure= $response_data->main->pressure;
        $wind_speed=$response_data->main->speed;
        $humidity=$response_data->main->humidity;

        return [$day_of_week, $day_and_date, $weather_condition, $weather_icon, $temperature, $pressure, $wind_speed, $humidity];
    }else{
        echo "Unexpected Error Occured While Fetching Weather Data";
    }

    function create_DB($servername, $username, $password, $dbname)
    {

        //create connection
        $conn=new mysqli($servername, $username, $password);

        //check connection
        if ($conn-> connect_error){
            die("Connection Failed: " .$conn-> connect_error);
        }

        //create database
        $sql="CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($sql)!==TRUE){
            echo "Error Creating Database: " . $conn->error;
        }

        $conn->close();
    }

    // function to create table if it doesnot exist
    function create_table($servername, $username, $password, $dbname)
    {
        global $city_name;
        //create connection
        $conn=new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error){
            die("Connection Failed: " . $conn-> connect_error);
        }
    //sql to create table
    $sql="CREATE TABLE if not exists $city_name(
        id INT(6) UNSIGNED AUTO INCREMENT PRIMARY KEY,
        Day_of_Week VARCHAR(15),
        Day_and_Date VARCHAR(20),
        Weather_Condition VARCHAR(50),
        Weather_Icon VARCHAR(100),
        Temperature INT(5),
        Pressure INT(6),
        Wind_speed DECIMAL(5,2),
        Humidity INT(5)
        )";
        if ($conn->query($sql)!==TRUE){
            echo "Error creating Table: " . $conn->error;
        }
        $conn->close();
    }

    //function to insert and update data into db
    function insert_update_data($servername, $username, $password, $dbname){
        global $city_name;
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error){
            die("Connection Failed: " . $conn->connect_error);
        }
        list($day_of_week, $day_and_date, $weather_condition, $weather_icon, $temperature, $pressure, $wind_speed, $humidity)=

        $existing_sql="Select * FROM $city_name WHERE Day_of_Week= '$day_of_week'";
        $existing_result=$conn->query($existing_sql);

if ($existing_result->num_rows === 0) {
    $insert_sql = "INSERT INTO $city_name (Day_of_Week, Day_and_Date, Weather_Condition, Weather_Icon, Temperature, Pressure, Wind_Speed, Humidity) VALUES ('$day_of_week', '$day_and_date', '$weather_condition', '$weather_icon', '$temperature', '$pressure', '$wind_speed', '$humidity')";
    if ($conn->query($insert_sql) !== TRUE) {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
} else {
    $update_sql = "UPDATE $city_name
                    SET
                        Weather_Condition='$weather_condition',
                        Weather_Icon='$weather_icon',
                        Temperature='$temperature',
                        Pressure='$pressure',
                        Wind_Speed='$wind_speed',
                        Humidity='$humidity',
                        Day_and_Date='$day_and_date'
                    WHERE Day_of_Week='$day_of_week'";
    if ($conn->query($update_sql) !== TRUE) {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}
$conn->close();
    }

    // function to display weather data from database
    function display_data($servername, $username, $password, $dbname){
        global $city_name;

        // create connection
        $conn= new mysqli($servername, $username, $password, $dbname);

        //check connection
        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        $sql ="SELECT * FROM $city_name ORDER BY id ASC";
        $result= $conn->query($sql);
        if ($result->num_rows>0){
            $all_data=array();
            //output weather data of each row
            while ($row=$result->fetch_assoc()){
                array_push($all_data, $row);
            }
            return json_encode($all_data);

        }else{
            echo "0 results";
        }
        $conn->close();
    }

    //function to connect to database, create table insert/update data and display daata
    function connect_DB(){
        $servername="localhost";
        $username="root";
        $password="";
        $dbname="city_weather";

        //create database
        create_DB($servername, $username, $password, $dbname);

        //create table
        create_table($servername, $username, $password, $dbname);

        //insert into table
        insert_update_data($servername, $username, $password, $dbname);

        $json_data=display_data($servername, $username, $password, $dbname);

        return $json_data;
    }
    echo connect_DB();
} */
<?php
// PHP code to fetch and display past weather data
header('Content-Type: application/json');
$city_name = "Dibrugarh";

// Fetch weather data function
function fetch_weather_data()
{
    global $city_name;
    $api_key = "7af5331f2d5f06a34fcb20d6f92962a0";
    $url = "http://api.openweathermap.org/data/2.5/weather?units=metric&q=" . $city_name . "&appid=" . $api_key;

    $json_data = file_get_contents($url);
    $response_data = json_decode($json_data);

    if ($response_data === null || isset($response_data->cod) && $response_data->cod !== 200) {
        return false;
    }

    if ($response_data->cod === 200) {
        // Extract relevant weather data
        $day_of_week = date('D');
        $day_and_date = date('M j, Y');
        $weather_condition = $response_data->weather[0]->description;
        $weather_icon = $response_data->weather[0]->icon;
        $temperature = $response_data->main->temp;
        $pressure = $response_data->main->pressure;
        $wind_speed = $response_data->wind->speed;
        $humidity = $response_data->main->humidity;

        // Return weather data as an array
        return [$day_of_week, $day_and_date, $weather_condition, $weather_icon, $temperature, $pressure, $wind_speed, $humidity];
    } else {
        return "Unexpected Error Occurred While Fetching Weather Data";
    }
}

// Function to create and connect to the database, create table, insert/update data, and display data
function connect_DB()
{
    global $city_name;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "city_weather";

    // Create database
    create_DB($servername, $username, $password, $dbname);

    // Create table
    create_table($servername, $username, $password, $dbname);

    // Insert/update data
    insert_update_data($servername, $username, $password, $dbname);

    // Display data
    $json_data = display_data($servername, $username, $password, $dbname);

    return $json_data;
}

// Function to create the database if it does not exist
function create_DB($servername, $username, $password, $dbname)
{
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) !== TRUE) {
        echo "Error Creating Database: " . $conn->error;
    }

    $conn->close();
}

// Function to create the table if it does not exist
function create_table($servername, $username, $password, $dbname)
{
    global $city_name;

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // SQL to create table
    $sql = "CREATE TABLE IF NOT EXISTS $city_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Day_of_Week VARCHAR(15),
        Day_and_Date VARCHAR(20),
        Weather_Condition VARCHAR(50),
        Weather_Icon VARCHAR(100),
        Temperature INT(5),
        Pressure INT(6),
        Wind_Speed DECIMAL(5,2),
        Humidity INT(5)
    )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating Table: " . $conn->error;
    }
    $conn->close();
}

// Function to insert or update data into the database
function insert_update_data($servername, $username, $password, $dbname)
{
    global $city_name;

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    $weather_data = fetch_weather_data();

    // Check if weather data is fetched successfully
    if ($weather_data) {
        list($day_of_week, $day_and_date, $weather_condition, $weather_icon, $temperature, $pressure, $wind_speed, $humidity) = $weather_data;

        $existing_sql = "SELECT * FROM $city_name WHERE Day_of_Week = '$day_of_week'";
        $existing_result = $conn->query($existing_sql);

        if ($existing_result->num_rows === 0) {
            $insert_sql = "INSERT INTO $city_name (Day_of_Week, Day_and_Date, Weather_Condition, Weather_Icon, Temperature, Pressure, Wind_Speed, Humidity) VALUES ('$day_of_week', '$day_and_date', '$weather_condition', '$weather_icon', '$temperature', '$pressure', '$wind_speed', '$humidity')";
            if ($conn->query($insert_sql) !== TRUE) {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        } else {
            $update_sql = "UPDATE $city_name
                            SET
                                Weather_Condition = '$weather_condition',
                                Weather_Icon = '$weather_icon',
                                Temperature = '$temperature',
                                Pressure = '$pressure',
                                Wind_Speed = '$wind_speed',
                                Humidity = '$humidity',
                                Day_and_Date = '$day_and_date'
                            WHERE Day_of_Week = '$day_of_week'";
            if ($conn->query($update_sql) !== TRUE) {
                echo "Error: " . $update_sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Failed to fetch weather data.";
    }
    $conn->close();
}

// Function to display weather data from the database
function display_data($servername, $username, $password, $dbname)
{
    global $city_name;

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM $city_name ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $all_data = array();
        // Output weather data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($all_data, $row);
        }
        return json_encode($all_data);
    } else {
        echo "0 results";
    }
    $conn->close();
}

// Fetch weather data and connect to database
echo connect_DB();
?>

?>