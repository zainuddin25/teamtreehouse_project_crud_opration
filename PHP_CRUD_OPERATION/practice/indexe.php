<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sending Request</title>
</head>
<body>

     <h2>Testing send data</h2>

     <!-- Data Form -->

     <form action="form.php" method="POST">
        <input type="text" name="name">
        <input type="password" name="password">
        <input type="submit" value="send"> 
        <select name="number">
               <option value="">choose number</option>
               <option value="1">one</option>
               <option value="2" selected>two</option>
               <option value="3">three</option>

        </select>   
     </form>
    
</body>
</html>