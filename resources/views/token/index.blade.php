<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Token System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f9;
        }
        .logo {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }
        .hospital-name {
            font-size: 30px;
            font-weight: bold;
            color: #000;
            margin-bottom: 20px;
        }
        .hospital-info {
            font-size: 20px;
            color: #333;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .hospital-info p {
            margin: 0;
        }
        .token-container {
            margin-top: 40px;
        }
        .token-number {
            font-size: 90px;
            color: #007bff;
            font-weight: bold;
        }
        .get-well {
            font-size: 24px;
            color: #007bff;
            margin-top: 20px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 30px;
        }

        /* Mobile responsiveness */
        @media (max-width: 600px) {
            .hospital-name {
                font-size: 40px;
            }
            .hospital-info {
                flex-direction: column;
                gap: 10px;
            }
            .token-number {
                font-size: 50px;
            }
        }

        /* Print styles to hide the print button */
        @media print {
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Hospital Logo -->
    <img src="{{ asset('images/m1.png') }}" alt="Hospital Logo" class="logo">

    
    <!-- Hospital Name -->
    <div class="hospital-name">SUWASEWANA HOSPITAL</div>

    <!-- Display Hospital Information (Date and Time) -->
    <div class="hospital-info">
        <p id="currentDate">{{ $currentDate }}</p>
        <p id="timeDisplay">Time: 10:45 AM</p>
    </div>

    <!-- Current Token Display -->
    <div class="token-container">
        <p>Current Token:</p>
        <div class="token-number" id="tokenNumber">{{ $token }}</div>
    </div>

    <!-- Get well message -->
    <div class="get-well">Get well soon</div>

    <!-- Print Button -->
    <button class="btn" id="printButton">Print Token</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Update the time every second
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            
            // Update the time on the page
            document.getElementById('timeDisplay').innerText = `Time: ${timeString}`;
        }

        // Call the updateTime function every second
        setInterval(updateTime, 1000);
        
        // Initial call to set the time immediately when the page loads
        updateTime();

        // Handle the print button click
        document.getElementById('printButton').addEventListener('click', function() {
            // Send the current token to the server for printing and update
            $.ajax({
                url: '{{ route('print.token') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    // Update the token number on the page immediately without delay
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
