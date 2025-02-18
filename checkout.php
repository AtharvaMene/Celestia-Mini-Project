<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celestia</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('./images/celestia_background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: 'Poppins', sans-serif;
            color: white;
            position: relative;
            text-align: center;
            overflow: hidden;
        }


        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .main-content {
            position: relative;
            z-index: 2;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        p {
            font-size: 1.2rem;
            margin-top: 10px;
            opacity: 0.9;
        }

        /* Button Styling */
        .btn {
            padding: 12px 25px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            background: linear-gradient(45deg, #ff7eb3, #ff758c);
            color: white;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            margin-top: 20px;
            box-shadow: 0px 4px 10px rgba(255, 117, 140, 0.4);
        }

        .btn:hover {
            background: linear-gradient(45deg, #ff6b9b, #ff3c78);
            transform: scale(1.05);
            box-shadow: 0px 6px 14px rgba(255, 117, 140, 0.6);
        }

        /* Loading Spinner */
        .loading-container {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: absolute;
            z-index: 3;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            opacity: 0.9;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="main-content">
        <h1>Thanks For Purchasing From Celestia</h1>
        <p>Discover the finest collection of premium cosmetics, tailored just for you.</p>
        <button class="btn" onclick="redirectToProducts()">Shop More</button>
    </div>

    <div class="loading-container" id="loading">
        <div class="spinner"></div>
        <p class="loading-text">Redirecting...</p>
    </div>

    <script>
        function redirectToProducts() {
            document.querySelector('.main-content').style.display = 'none';
            document.getElementById('loading').style.display = 'flex';

            setTimeout(() => {
                window.location.href = 'user_displayproducts.php';
            }, 2000);
        }
    </script>

</body>

</html>