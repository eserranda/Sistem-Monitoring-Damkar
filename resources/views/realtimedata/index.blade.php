@extends('layouts.master')
@section('content')
    <div class="card">
        <h5 class="card-header">Monitoring Sensor</h5>
        <div class="card-body">
            <h5 id="humadity"></h5>
            <h5 id="temperature"></h5>
        </div>
    </div>

    @push('script')
        <script src="https://www.gstatic.com/firebasejs/8.8.1/firebase.js"></script>
        <script>
            const firebaseConfig = {
                apiKey: "{{ config('services.firebase.api_key') }}",
                databaseURL: "{{ config('services.firebase.database_url') }}",
            };
            firebase.initializeApp(firebaseConfig);

            const database = firebase.database();
            const sensorRef = database.ref("Sensor");
            sensorRef.on('value', (snapshot) => {
                const sensorData = snapshot.val();
                console.log(sensorData);

                const humadityValue = sensorData.Humadity.humadity;
                const temperatureValue = sensorData.Temperature.celcius;

                document.getElementById("humadity").innerHTML = humadityValue
                document.getElementById("temperature").innerHTML = temperatureValue

                // document.getElementById("temperature").value;
                // document.querySelector(".temperature").innerHTML = humadityValue;
                // document.querySelector(".celcius").innerHTML = temperatureValue;
            });
        </script>
    @endpush
@endsection
