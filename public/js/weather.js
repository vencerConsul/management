async function getWeather(city) {
    const apiKey = "ff982e30801c664902181711436705c9";
    const endpoint = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=ph&appid=${apiKey}`;
    
    const response = await fetch(endpoint);
    if (response.ok) {
        const data = await response.json();
        return data;
    } else {
        return null;
    }
    }
    
    const city = "Baguio City";
    const weatherTemperature = document.querySelector('.weather-tamp');
    const weatherLocation = document.querySelector('.weather-location');
    const weatherType = document.querySelector('.weather-type');
    const weatherImg = document.querySelector('.weather-img');
    const currentDate = new Date();
    const currentHour = currentDate.getHours();

    getWeather(city)
        .then((weather) => {
            if (weather) {
                // console.log(weather);
                weatherLocation.innerHTML = weather.name;
                weatherType.innerHTML = weather.weather[0].description;
                weatherTemperature.innerHTML = weather.main.temp;
                
                const id = weather.weather[0].id;
                let path = "../images/dashboard/weather/"
                console.log(id);
                if(id == 800){
                    weatherImg.setAttribute('src', path + 'clear.png');
                }else if(id >= 200 && id <= 232){
                    weatherImg.setAttribute('src', path + 'thunderstorms.png')  ;
                }else if(id >= 600 && id <= 622){
                    weatherImg.setAttribute('src', path + 'snow.png');
                }else if(id >= 701 && id <= 781){
                    weatherImg.setAttribute('src', path + 'rain.png');
                }else if(id >= 801 && id <= 804){
                    if(id == 802){
                        weatherImg.setAttribute('src', path + 'cloud.png');
                    }else if(id == 803){
                        weatherImg.setAttribute('src', path + 'clear.png');
                    }
                }

            } else {
                console.log("Failed to retrieve weather data.");
            }
        })
        .catch((error) => {
            console.error(error);
        });