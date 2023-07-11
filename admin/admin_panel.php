
<!DOCTYPE html>
<html>
<head>
    <title>Store Polling Unit Results</title>
    <style>
        .header {
            background-color: green;
            color: white;
            padding: 10px;
        }

        .footer {
            background-color: green;
            color: white;
            padding: 10px;
            text-align: center;
        }

        form {
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        button {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Store Polling Unit Results</h1>
    </div>

    <form method="post" action="../inc/store_results.php">
        <label for="pollingUnitId">Polling Unit ID:</label>
        <input type="text" name="pollingUnitId" id="pollingUnitId">

        <label for="partyResults">Party Results:</label>
        <textarea name="partyResults" id="partyResults" placeholder="PDP: 150
APC: 200
SDP: 50
"></textarea>

        <button type="submit">Submit Results</button>
    </form>

    <div class="footer">
        &copy; 2023 INEC
    </div>
</body>
</html>
