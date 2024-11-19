<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Request Form</title> 
	
	
    <style>
		
        /* Styling remains the same */
		
        body { background-color: #000; color: #1E90FF; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100%; margin: 20px; }
		
        .container {
            background-color: #1A1A1A; /* Dark gray for container */
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
		
		h2 { color: #00b0ff; margin-bottom: 20px; }
		
        label { display: block; text-align: left; margin: 10px 0 5px; color: #b3b3b3; }
		
        input[type="text"], input[type="number"], textarea, input[type="file"] {
            width: 100%; padding: 10px; margin-bottom: 15px; background-color: #2b2b2b; border: 1px solid #444; border-radius: 4px; color: #f1f1f1; font-size: 14px;
        }
		
        input[type="submit"] { background-color: #00b0ff; color: #fff; font-size: 16px; padding: 10px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease; }
        input[type="submit"]:hover { background-color: #0081c2; }
    </style>	
</head>
<body>
    <div class="form-container">
		<div class="box form-box">
        <h2>Request to Sell Clothes</h2>
        <form action="processSellRequest.php" method="post" enctype="multipart/form-data">
		<div class="field input">
            <label>Name:</label>
            <input type="text" name="name" required></div>

		<div class="field input">
            <label>Brand:</label>
            <input type="text" name="brand" required></div>
            
		<div class="field input">
            <label>Category:</label>
            <input type="text" name="category" required></div>
            
		<div class="field input">
            <label>Description:</label>
            <textarea name="description" required></textarea></div>
           
		<div class="field input">
            <label>Price:</label>
            <input type="number" name="price" step="0.01" required></div>
            
		<div class="field input">
            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*" required></div>
           
		<div class="field input">
            <input type="submit" value="Submit Request"></div>
        </form>
		</div>
		<br>
		<a href="index.php">Continue Shopping</a></div> 
    </div>
</body>
</html>
