<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Token System</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 300px;
            padding: 15px;
            border: 2px solid #000;
            text-align: center;
            font-size: 16px;
            line-height: 1.6;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
        .hospital-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .hospital-info {
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between; /* Align items on left and right */
        }
        .hospital-info p {
            margin: 0;
        }
        .token-container {
            margin-top: 20px;
        }
        .token-number {
            font-size: 40px;
            font-weight: bold;
            color: black;
            margin: 10px 0;
        }
        .line {
            margin: 10px 0;
            border-bottom: 1px dashed #000;
        }
        .get-well {
            font-size: 16px;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            margin-top: 30px;
        }

        /* Print styles */
        @media print {
            body {
                padding: 0;
                text-align: center;
            }
            .container {
                width: 100%;
                max-width: 300px;
                padding: 10px;
            }
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Hospital Logo -->
        <img src="{{ asset('images/m1.png') }}" alt="Hospital Logo" class="logo">

        <!-- Hospital Name -->
        <div class="hospital-name">ESI HOSPITAL (OPD)</div>

        <!-- Display Hospital Information (Date and Time) -->
        <div class="hospital-info">
            <p>Time & Date</p>
            <p id="currentDate">15:43 23/05/17</p> <!-- This will be updated dynamically -->
        </div>

        <!-- Line Divider -->
        <div class="line"></div>

        <!-- Current Token Display -->
        <div class="token-container">
            <p>TOKEN NO:</p>
            <div class="token-number" id="tokenNumber">{{ $token }}</div> <!-- Dynamic token display -->
        </div>

        <!-- Line Divider -->
        <div class="line"></div>

        <!-- Get well message -->
        <div class="get-well">** Get Well Soon **</div>

        <!-- Print Button -->
        <button class="btn" id="printButton">Print Token</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to update the current time and date
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const date = new Date();
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear().toString().slice(-2);  // Get last two digits of the year
            const timeString = `${hours}:${minutes}:${seconds}`;
            const dateString = `${day}/${month}/${year}`;

            // Update the time and date on the page
            document.getElementById('currentDate').innerText = `${timeString} ${dateString}`;
        }

        // Call the updateTime function every second
        setInterval(updateTime, 1000);
        
        // Initial call to set the time immediately when the page loads
        updateTime();

        // Handle the print button click
        document.getElementById('printButton').addEventListener('click', function() {
            // Send the current token to the server for printing and update
            $.ajax({
                url: '{{ route('print.token') }}', // Adjust the route if necessary
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Laravel CSRF token
                },
                success: function(data) {
                    // Ensure that the token number does not change on the screen
                    document.getElementById('tokenNumber').innerText = `${data.newToken}`;
                    
                    // Print the current page (token) for the user
                    window.print();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>

</body>
</html>
