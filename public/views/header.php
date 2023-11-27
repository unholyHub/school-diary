<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" 
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./public/assets/css/style.css">
    <title>Училищен дневник</title>
</head>

<body>
    <!-- title and login -->
    <section class="main-header">
        <section>
            <h1>
                <a href=".">Училищен дневник</a>
            </h1>
        </section>
        <section class="login-form">
            <?php include_once 'small-views/signin.php' ?>
        </section>
    </section>

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <main>