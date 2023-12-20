<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Real-time Data</title>
</head>

<body>

    <script src="https://www.gstatic.com/firebasejs/8.8.1/firebase.js"></script>
    <script>
        // Initialize Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyBLaQsN7nMTAJePQeFhmETD3OIwEna4Hx4",
            // authDomain: "https://accounts.google.com/o/oauth2/auth",
            databaseURL: "https://sensordamkar-default-rtdb.asia-southeast1.firebasedatabase.app/",
        };
        firebase.initializeApp(firebaseConfig);

        // Listen for data changes
        const database = firebase.database();
        const sensorRef = database.ref("Sensor");
        // const temperatureRef = database.ref("Sensor/Humidity");
        sensorRef.on('value', (snapshot) => {
            const sensorData = snapshot.val();
            console.log(sensorData);

            const humadityValue = sensorData.Humadity.humadity;
            const temperatureValue = sensorData.Temperature.celcius;

            document.querySelector(".temperature").innerHTML = humadityValue;
            document.querySelector(".celcius").innerHTML = temperatureValue;
        });
    </script>

    <div class="temperature"></div>
    <div class="celcius"></div>
</body>

</html>
