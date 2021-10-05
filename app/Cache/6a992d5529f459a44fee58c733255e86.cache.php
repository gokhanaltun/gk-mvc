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
        <input type="text" name="text">
        <button type="submit"> test </button>
    </form>
    <br><br><br><br><br>

    <?php foreach ($data as $data1): ?>
    <p><?=$data1['news_content']?></p>
    <?php endforeach; ?>

</body>
</html>