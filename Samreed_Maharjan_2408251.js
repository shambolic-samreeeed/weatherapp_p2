// Student Name: Samreed Maharjan
// Student Id: 2408251

// Declaration of constants
const apiKey = "7af5331f2d5f06a34fcb20d6f92962a0";
const apiUrl = "http://api.openweathermap.org/data/2.5/weather?units=metric&q=";
const searchBox = document.querySelector(".searches input");
const searchBtn = document.querySelector(".searches button");
const weatherIcon = document.querySelector(".weatherimg");
const cityName = "Dibrugarh";
const weekContainer=document.querySelector(".daysContainer");

/* The async and await keywords help return and wait for a promise. the async keywords returns promise whereas the await keyword  waits until the promis is returned*/
async function checkWeather(city) {
  const response = await fetch(apiUrl + city + `&appid=${apiKey}`);
  /* fetch method returns a promise.It fetches data from the api */
  if (response.status == 404) {
    document.querySelector(".error").style.display = "block";
    document.querySelector(".weather").style.display = "none";
    document.querySelector(".div2").style.display = "none";
  } else {
    var data = await response.json();

    console.log(data);

    // Updating the contents with the data from the api
    document.querySelector(".city").innerHTML = data.name;
    document.querySelector(".temp").innerHTML =
      Math.round(data.main.temp) + "°C";
    document.querySelector(".condition").innerHTML = data.weather[0].main;
    document.querySelector(".humidity_value").innerHTML =
      data.main.humidity + "%";
    document.querySelector(".atmpressure_value").innerHTML =
      data.main.pressure + " hPa";
    document.querySelector(".windspeed_value").innerHTML =
      data.wind.speed + " Km/Hr";
    document.querySelector(".winddirection_value").innerHTML =
      data.wind.deg + "°";

    // Image according to the weather
    if (data.weather[0].main == "Clouds") {
      weatherIcon.src =
        "https://cdn-icons-png.flaticon.com/512/3222/3222808.png";
    } else if (data.weather[0].main == "Clear") {
      weatherIcon.src =
        "https://cdn-icons-png.flaticon.com/512/4814/4814275.png";
    } else if (data.weather[0].main == "Rain") {
      weatherIcon.src =
        "https://storage.googleapis.com/kaggle-datasets-images/2825742/4873466/2dfa51e6be9baf43326f1bf0ba42a562/dataset-card.png?t=2023-01-19-21-34-19";
    } else if (data.weather[0].main == "Drizzle") {
      weatherIcon.src =
        "https://cdn-icons-png.flaticon.com/512/2675/2675897.png";
    } else if (data.weather[0].main == "Mist") {
      weatherIcon.src =
        "https://cdn-icons-png.flaticon.com/512/1197/1197102.png";
    } else if (data.weather[0].main == "Snow") {
      weatherIcon.src =
        "https://img.genial.ly/63a4b4b62c1b3100128d0792/3aa5abac-1258-43dd-8dc5-2e278cc734f7.png";
    } else if (data.weather[0].main == "Haze") {
      weatherIcon.src =
        "https://cdn-icons-png.flaticon.com/512/4151/4151022.png";
    }
    document.querySelector(".error").style.display = "none";
  }
}

// Eventlistener for the button

searchBtn.addEventListener("click",()=>{
  checkWeather(searchBox.value)
})

// event listener for when user presses enter key in the search bar
searchBox.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    checkWeather(searchBox.value);
  }
});

// Weather data for the default city using local storage.
checkWeather(cityName);
// Retrieving cached weather data from local storage
const cachedWeatherData = localStorage.getItem("defaultWeatherData");
if (cachedWeatherData) {
  // Parse the cached data from JSON to a JavaScript object
  const weather = JSON.parse(cachedWeatherData);
  //perform operations with the cached weather data
  populateWeatherData(weather);
}
// Selecting the search bar element
const city = document.querySelector(".searchbar");
// Fetch weather data for the city entered in the search bar
function searchWeather() {
  fetchData(city.value);
  // Clear the search bar value after fetching data
  city.value = "";
}

// declaring function for displaying the current date
function clock() {
  // Arrays for month and day names
  var monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  var dayNames = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];

  // Get the current date
  var today = new Date();
  document.getElementById("date").innerHTML =
    dayNames[today.getDay()] +
    " " +
    today.getDate() +
    " " +
    monthNames[today.getMonth()] +
    " " +
    today.getFullYear();
  // Set up an interval to call the clock function repeatedly at a specific interval (every 400 milliseconds)
}
var inter = setInterval(clock, 400);

//pastweather

async function pastWeatherData(){
  try{
    document.querySelector("pastWeatherContainer h1").innerText= `${cityName} Past Weather`;
    //fetching past data from php
    let url=`http://localhost/Samreed_Maharjan_2408251_Prototype2/Samreed_Maharjan_2408251.php`;
    let response=await fetch (url);
    if (!response.ok){
      throw new Error(`HTTP error! status: ${response.status}`);
    }else{
      let data=await response.json();
      let weekBoxHTML="";

      data.foreach((weather)=>{
        weekBoxHTML+=`
        <div class="week-box">
        <div class="date">${weather.Day_and_Date}</div>
        <div class="db-info">
        <p>${weather.Day_of_Week}</p>
        <figure><img src="./icons/ ${weather.Weather_Icon}.svg" /></figure>
        <p>${weather.Temperature}°C</p>
        <p>${weather.Pressure} Pa</p>
        <p>${weather.Wind_Speed}m/s</p>
        <p>${weather.Humidity}%</p>
        </div>
        </div>
        <hr>`;
      });

      //set inner html
      weekContainer.innerHTML=weekBoxHTML;
      savePastData();
    }
  }catch(error){
    console.error(error);
  }
}

//pastdatacall
pastWeatherData();
function savePastData(){
  localStorage.setItem("data", weekContainer.innerHTML);
}

function showPastData(){
  weekContainer.innerHTML=localStorage.getItem("data");
}

showPastData();
