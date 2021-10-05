<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ana Sayfa </title>
</head>
<body>
    

    <h1>Ana Sayfa</h1>
    <form action="deneme" method="POST">
        <input type="hidden" name="csrf" value="e1d881dbc6914297406a4b76be4c65c1">
        <input type="text" name="text">
        <input type="text" name="text2">
        <button type="submit"> test </button>
    </form>
    <br><br><br><br><br>

    <?php foreach ($users as $user): ?>
    <p><?=$user['name']?></p>
    <?php endforeach; ?>

</body>
</html>





