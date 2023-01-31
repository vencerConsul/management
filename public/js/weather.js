async function getWeather(city) {
    const apiKey = "ff982e30801c664902181711436705c9";
    const endpoint = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`;
    
    const response = await fetch(endpoint);
    if (response.ok) {
        const data = await response.json();
        return data;
    } else {
        return null;
    }
    }
    
    const city = "Baguio";
    const weatherTemperature = document.querySelector('.weather-tamp');
    const weatherLocation = document.querySelector('.weather-location');
    const weatherType = document.querySelector('.weather-type');
    const weatherImg = document.querySelector('.weather-img');
    const currentDate = new Date();
    const currentHour = currentDate.getHours();

    getWeather(city)
        .then((weather) => {
            if (weather) {
                weatherLocation.innerHTML = weather.name;
                weatherType.innerHTML = weather.weather[0].description;
                weatherTemperature.innerHTML = weather.main.temp;

                const id = weather.weather[0].id;
                let path = "../images/dashboard/weather/"

                if(id == 800){
                    weatherImg.setAttribute('src', path + 'clear.jpg');
                }else if(id >= 200 && id <= 232){
                    weatherImg.setAttribute('src', path + 'thunderstorms.png')  ;
                }else if(id >= 600 && id <= 622){
                    weatherImg.setAttribute('src', path + 'snow.png');
                }else if(id >= 701 && id <= 781){
                    weatherImg.setAttribute('src', path + 'haze.jpg');
                }else if(id >= 801 && id <= 804){
                    weatherImg.setAttribute('src', path + 'cloud.png');
                }else if((id >= 500 && id <= 531) || (id >= 300 && id <= 321)){
                    weatherImg.setAttribute('src', path + 'rain.png');
                }else{
                    if (currentHour >= 6 && currentHour < 18) {
                        weatherImg.setAttribute('src', path + 'clear.jpg');
                    } else {
                        weatherImg.setAttribute('src', path + 'clear-night.png');
                    }
                }

            } else {
                console.log("Failed to retrieve weather data.");
            }
        })
        .catch((error) => {
            console.error(error);
        });