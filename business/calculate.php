
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/pages.css"> -->
    <title>Price Calculator</title>
    <style>
        body {
            /* font-family: Arial, sans-serif; */
            padding: 0;
            margin: 0;
            width:100%
        }

        /* Container for overall layout */
        #calc-container{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* text-align: center; */
            justify-content:space-between;
        }


        .content-container {
            max-width: 1200px; /* Limit width on large screens */
            min-width: 325px;
            margin: 0 auto; /* Center the content */
            padding: 30px 10px 30px 30px;
            border-radius: 0.3em;
        }
        #section-container{
            background-color: red;
            margin-bottom: 20px
        }
        .unit-selector, .thickness-selector, .color-selector,{
            margin-bottom: 5px;
            margin-top: 20px;
            padding: 5px;
            font-size: 16px;
        }
        #remove-btn{
            margin-bottom: 5px;
            margin-top: 20px;
            padding: 5px;
            font-weight:bold;
            cursor: pointer;
            color: red;
            background: none;
        }

        .unit-selector label {
            margin-right: 20px;
        }

        .unit-selector, .thickness-selector, .color-selector {
            padding: 5px;
            font-size: 16px;
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 0 10px;
            align-items: center;
            margin-bottom: 0px;
        }

        .input-group input  {
            padding: 8px;
            min-width: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .input-group .remove-btn {
            background-color: transparent;
            border: none;
            font-size: 30px;
            cursor: pointer;
            color: #ff4d4d;
            padding: 5px;
        }

        .input-group .remove-btn:hover {
            color: #e60000;
        }

        .result-display {
            font-weight: bold;
            color: #333;
            white-space: nowrap; /* Prevent the text from wrapping */
        }

        .total-result {
            margin-top: 20px;
            font-size: 18px;
        }

        .add-box-btn {
            background-color: #4CAF50; /* Green color for the add button */
            border-radius: 0.3em;
            width: 40px;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .add-box-btn:hover {
            background-color: #45a049; /* Darker green on hover */

        }

        #calculate-total-btn, #new-section-btn {
            margin-left: 10px;
            margin-top:10px;
            padding: 10px;
            cursor: pointer;
            /* border-radius: 0.3em; */
            font-size: 16px;
        }
       
        .remove-btn {
            margin-left: 10px;
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
        .result-display {
            margin-top: 0px;
            
        }
        #result{
            margin-top: 10px;
            
        }

        

        /* Responsive Design for Mobile */
        @media only screen and (max-width: 600px) {
        .input-group {
            grid-template-columns: 1fr 1fr auto; /* Still maintain 2 columns for inputs and 1 auto-sized for button */
            }
            .result-display {
                grid-column: span 3; /* Result will take up the full width on small screens */
            }
         }
         
    </style>
</head>
<body>
    <div id="calc-container">
        <?php include 'includes/navbar.php'; ?>

        <div class="content-container">
            <h1>Price Calculator</h1>
            <div id="sections-container"></div>
            <button id="new-section-btn" >New Section</button>
            <button id="calculate-total-btn">Calculate Total</button>
            <div id="result"></div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>


    <script src="assets/js/calculate.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

